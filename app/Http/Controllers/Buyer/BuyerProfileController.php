<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\BuyerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuyerProfileController extends Controller
{
    public function index()
    {
        // Fetch current authenticated user and their connected buyer profile
        $user = auth()->user();
        $buyer = $user->buyerDetail;

        // If buyer record doesn't exist yet, create an empty instance or object safely
        if (!$buyer) {
            $buyer = $user->buyerDetail()->create([
                'display_name' => $user->name,
                'preferred_language' => 'English',
                'preferred_currency' => 'USD',
                'newsletter' => true,
                'is_verified' => false
            ]);
        }

        return view('buyer.profile.index', compact('user', 'buyer'));
    }

    public function update(Request $request)
    {
        
        $user = auth()->user();

        // FIX: Tab variable ko yahan define karein
        $tab = $request->input('tab_name');

        // 1. Avatar Upload Logic
        if ($request->has('image_data')) {
            $imageData = $request->input('image_data');

            if (strpos($imageData, ',') !== false) {
                list(, $imageData) = explode(',', $imageData);
            }
            $imageData = base64_decode($imageData);

            $directory = 'profile';
            $fileName = 'avatar_' . $user->id . '_' . time() . '.jpg';
            $path = $directory . '/' . $fileName;

            if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $stored = Storage::disk('public')->put($path, $imageData);

            if ($stored) {
                $user->avatar = $path;
                $user->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Profile picture updated successfully.',
                    'path' => asset('storage/' . $path)
                ]);
            }
            return response()->json(['status' => 'error', 'message' => 'Failed to store image.'], 500);
        }

        // 2. Personal Details Logic
        if ($tab === 'personal_details') {
            $user->update([
                'name'  => $request->display_name ?? $user->name,
                'phone' => $request->phone,
            ]);

            BuyerDetail::updateOrCreate(
                ['user_id' => $user->id],
                $request->only(['display_name', 'bio', 'country', 'state', 'city'])
            );

            return response()->json(['success' => true, 'message' => 'Profile updated successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid request.'], 400);
    }
}
