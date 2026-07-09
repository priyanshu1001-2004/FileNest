<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\SellerDetail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SellerProfileController extends Controller
{
    public function index()
    {
        $seller = auth()->user()->sellerDetail;
        return view('seller.profile.index', compact('seller'));
    }

    public function update(Request $request)
    {
        try {
            // Identify active tab context from standard request body
            $tab = $request->input('tab_name');

            $user = auth()->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthenticated access attempt.'], 401);
            }

            // Fetch seller profile row or create it instantly on the fly
            $seller = $user->SellerDetail ?: SellerDetail::create(['user_id' => $user->id]);

            switch ($tab) {
                case 'logo':
                case 'banner':
                    // Extract payload using pure text decoding to bypass temporary folder limits
                    $base64Image = $request->input('image_data');
                    if (empty($base64Image)) {
                        return response()->json(['success' => false, 'message' => 'No image data string received.'], 422);
                    }

                    // Strip metadata signature safely
                    $extension = 'jpg';
                    if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
                        $extension = $matches[1];
                        $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                    }

                    $decodedData = base64_decode($base64Image);
                    if ($decodedData === false) {
                        return response()->json(['success' => false, 'message' => 'Data stream corruption detected.'], 422);
                    }

                    // Purge old asset files from the public storage disk
                    $oldPath = ($tab === 'banner') ? $seller->store_banner : $seller->store_logo;
                    if (!empty($oldPath) && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }

                    // Write new asset clean payload parameters
                    $filename = 'seller_' . $tab . '_' . Str::random(12) . '.' . $extension;
                    $path = 'uploads/profile/' . $filename;
                    Storage::disk('public')->put($path, $decodedData);

                    // Map path update directly back to model attributes
                    $seller->update([($tab === 'banner' ? 'store_banner' : 'store_logo') => $path]);

                    return response()->json([
                        'success' => true,
                        'message' => ucfirst($tab) . ' profile asset synchronized successfully!',
                        'path' => asset('storage/' . $path)
                    ]);

                case 'basic':
                    $validated = $request->validate([
                        'store_name' => 'required|string|max:100',
                        'store_headline' => 'nullable|string|max:255',
                    ]);

                    $seller->update($validated);
                    return response()->json(['success' => true, 'message' => 'Basic profile details modified.']);

                case 'terms':
                    $validated = $request->validate([
                        'terms_conditions' => 'required|string|min:10',
                    ]);

                    $seller->update($validated);
                    return response()->json(['success' => true, 'message' => 'Terms updates saved successfully.']);

                default:
                    return response()->json(['success' => false, 'message' => 'Invalid tab action context requested.'], 400);
            }
        } catch (ValidationException $ve) {
            return response()->json(['success' => false, 'message' => $ve->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Execution Error: ' . $e->getMessage()], 500);
        }
    }

   
}
