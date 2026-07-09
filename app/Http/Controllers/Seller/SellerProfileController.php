<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            $tab = $request->input('tab_name');
            $user = auth()->user();

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthenticated access.'], 401);
            }

            // Fetch or dynamically initialize the seller profile context
            $seller = $user->sellerDetail ?: SellerDetail::create(['user_id' => $user->id]);

            switch ($tab) {
                case 'logo':
                case 'banner':
                    $base64Image = $request->input('image_data');
                    if (empty($base64Image)) {
                        return response()->json(['success' => false, 'message' => 'No image data string received.'], 422);
                    }

                    $extension = 'jpg';
                    if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
                        $extension = $matches[1];
                        $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                    }

                    $decodedData = base64_decode($base64Image);
                    if ($decodedData === false) {
                        return response()->json(['success' => false, 'message' => 'Data corruption detected.'], 422);
                    }

                    // Disk Cleanup Layer
                    $oldPath = ($tab === 'banner' ? $seller->store_banner : $seller->store_logo);
                    if (!empty($oldPath) && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }

                    $filename = 'seller_' . $tab . '_' . Str::random(12) . '.' . $extension;
                    $path = 'uploads/profile/' . $filename;
                    Storage::disk('public')->put($path, $decodedData);

                    $seller->update([($tab === 'banner' ? 'store_banner' : 'store_logo') => $path]);

                    return response()->json([
                        'success' => true,
                        'message' => ucfirst($tab) . ' updated successfully!',
                        'path' => asset('storage/' . $path)
                    ]);

                case 'store_info':
                    $validated = $request->validate([
                        'store_name' => 'required|string|max:100|unique:seller_details,store_name,' . $seller->id,
                        'store_tagline' => 'nullable|string|max:255',
                        'store_description' => 'nullable|string',
                    ]);

                    // Auto-compute unique slug parameter directly from name configurations dynamically
                    $validated['store_slug'] = Str::slug($request->input('store_name'));

                    $seller->update($validated);
                    return response()->json(['success' => true, 'message' => 'Store layout updated cleanly!']);

                case 'business_info':
                    $validated = $request->validate([
                        'seller_type' => 'required|in:individual,business',
                        'company_name' => 'nullable|string|max:150',
                        'tax_number' => 'nullable|string|max:100',
                        'business_address' => 'nullable|string',
                    ]);
                    $seller->update($validated);
                    return response()->json(['success' => true, 'message' => 'Business matrix updated!']);

                case 'contact_info':
                    $validated = $request->validate([
                        'support_email' => 'required|email|max:150',
                        'website' => 'nullable|url|max:255',
                        'country' => 'nullable|string|max:100',
                        'state' => 'nullable|string|max:100',
                        'city' => 'nullable|string|max:100',
                    ]);
                    $seller->update($validated);
                    return response()->json(['success' => true, 'message' => 'Geographic mapping updated!']);

                case 'store_policies':
                    $validated = $request->validate([
                        'support_policy' => 'nullable|string',
                        'refund_policy' => 'nullable|string',
                        'license_information' => 'nullable|string',
                    ]);
                    $seller->update($validated);
                    return response()->json(['success' => true, 'message' => 'Policies saved flawlessly!']);

                case 'social_links':
                    $validated = $request->validate([
                        'github_url' => 'nullable|url',
                        'youtube_url' => 'nullable|url',
                        'linkedin_url' => 'nullable|url',
                        'instagram_url' => 'nullable|url',
                        'twitter_url' => 'nullable|url',
                        'portfolio_url' => 'nullable|url',
                    ]);
                    $seller->update($validated);
                    return response()->json(['success' => true, 'message' => 'Social matrix profiles linked!']);

                default:
                    return response()->json(['success' => false, 'message' => 'Unsupported action requested.'], 400);
            }
        } catch (ValidationException $ve) {
            return response()->json(['success' => false, 'message' => $ve->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Execution Error: ' . $e->getMessage()], 500);
        }
    }
}
