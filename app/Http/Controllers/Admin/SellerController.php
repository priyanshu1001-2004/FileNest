<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SellerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    /**
     * Display a listing of sellers.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->get('search');
            $status = $request->get('status');
            $verification = $request->get('verification');

            $sellers = User::with(['sellerDetail'])
                ->where('role', 1)
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%")
                            ->orWhereHas('sellerDetail', function ($sq) use ($search) {
                                $sq->where('store_name', 'LIKE', "%{$search}%");
                            });
                    });
                })
                ->when($status, function ($query, $status) {
                    if ($status === 'active') {
                        return $query->whereHas('sellerDetail', function ($q) {
                            $q->where('is_verified', true)->where('is_suspended', false);
                        });
                    } elseif ($status === 'suspended') {
                        return $query->whereHas('sellerDetail', function ($q) {
                            $q->where('is_suspended', true);
                        });
                    }
                    return $query;
                })
                ->when($verification, function ($query, $verification) {
                    if ($verification === 'verified') {
                        return $query->whereHas('sellerDetail', function ($q) {
                            $q->where('is_verified', true);
                        });
                    } elseif ($verification === 'pending') {
                        return $query->whereHas('sellerDetail', function ($q) {
                            $q->where('is_verified', false);
                        });
                    }
                    return $query;
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            // Statistics
            $totalSellers = User::where('role', 1)->count();
            $verifiedSellers = User::where('role', 1)
                ->whereHas('sellerDetail', function ($q) {
                    $q->where('is_verified', true);
                })->count();
            $pendingSellers = User::where('role', 1)
                ->whereHas('sellerDetail', function ($q) {
                    $q->where('is_verified', false);
                })->count();
            $suspendedSellers = User::where('role', 1)
                ->whereHas('sellerDetail', function ($q) {
                    $q->where('is_suspended', true);
                })->count();

            return view('admin.sellers.index', compact(
                'sellers',
                'totalSellers',
                'verifiedSellers',
                'pendingSellers',
                'suspendedSellers'
            ));
        } catch (\Exception $e) {
            Log::error('Seller Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load sellers.');
        }
    }

    /**
     * Display the specified seller.
     */
    public function show(User $seller)
    {
        try {
            if ($seller->role !== 1) {
                abort(404, 'Seller not found.');
            }

            $seller->load(['sellerDetail', 'products']);
            $products = $seller->products()->paginate(10);

            return view('admin.sellers.show', compact('seller', 'products'));
        } catch (\Exception $e) {
            Log::error('Seller Show Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load seller details.');
        }
    }

    /**
     * Create seller detail for a user (Quick Fix)
     */
    public function createDetail(User $user)
    {
        try {
            if (!$user->isSeller()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not a seller.'
                ], 422);
            }

            if ($user->sellerDetail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seller detail already exists.'
                ], 422);
            }

            $sellerDetail = SellerDetail::create([
                'user_id' => $user->id,
                'store_name' => $user->name . "'s Store",
                'store_slug' => Str::slug($user->name . '-store'),
                'seller_type' => 'individual',
                'is_verified' => false,
                'is_suspended' => false,
                'is_featured' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Seller profile created for '{$user->name}' successfully!"
            ]);

        } catch (\Exception $e) {
            Log::error('Create Seller Detail Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create seller profile.'
            ], 500);
        }
    }

    /**
     * Verify a seller.
     */
    public function verify(SellerDetail $sellerDetail)
    {
        try {
            $sellerDetail->is_verified = true;
            $sellerDetail->verified_by = auth()->id();
            $sellerDetail->save();

            // Also update user status if inactive
            $user = $sellerDetail->user;
            if ($user && $user->status == false) {
                $user->status = true;
                $user->save();
            }

            return response()->json([
                'success' => true,
                'message' => "Seller '{$sellerDetail->store_name}' verified successfully!",
                'is_verified' => true
            ]);
        } catch (\Exception $e) {
            Log::error('Seller Verification Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify seller.'
            ], 500);
        }
    }

    /**
     * Unverify a seller.
     */
    public function unverify(SellerDetail $sellerDetail)
    {
        try {
            $sellerDetail->is_verified = false;
            $sellerDetail->verified_by = null;
            $sellerDetail->save();

            return response()->json([
                'success' => true,
                'message' => "Seller '{$sellerDetail->store_name}' unverified successfully!",
                'is_verified' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Seller Unverification Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to unverify seller.'
            ], 500);
        }
    }

    /**
     * Suspend a seller.
     */
    public function suspend(Request $request, SellerDetail $sellerDetail)
    {
        try {
            $validated = $request->validate([
                'suspension_reason' => 'required|string|max:500',
                'suspended_until' => 'nullable|date|after:now',
            ]);

            $sellerDetail->is_suspended = true;
            $sellerDetail->suspension_reason = $validated['suspension_reason'];
            $sellerDetail->suspended_until = $validated['suspended_until'] ?? null;
            $sellerDetail->save();

            return response()->json([
                'success' => true,
                'message' => "Seller '{$sellerDetail->store_name}' suspended successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('Seller Suspension Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to suspend seller.'
            ], 500);
        }
    }

    /**
     * Unsuspend a seller.
     */
    public function unsuspend(SellerDetail $sellerDetail)
    {
        try {
            $sellerDetail->is_suspended = false;
            $sellerDetail->suspension_reason = null;
            $sellerDetail->suspended_until = null;
            $sellerDetail->save();

            return response()->json([
                'success' => true,
                'message' => "Seller '{$sellerDetail->store_name}' unsuspended successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('Seller Unsuspension Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to unsuspend seller.'
            ], 500);
        }
    }

    /**
     * Feature or unfeature a seller.
     */
    public function toggleFeature(SellerDetail $sellerDetail)
    {
        try {
            $sellerDetail->is_featured = !$sellerDetail->is_featured;
            $sellerDetail->save();

            return response()->json([
                'success' => true,
                'message' => "Seller '{$sellerDetail->store_name}' " . ($sellerDetail->is_featured ? 'featured' : 'unfeatured') . " successfully!",
                'is_featured' => $sellerDetail->is_featured
            ]);
        } catch (\Exception $e) {
            Log::error('Seller Feature Toggle Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update seller feature status.'
            ], 500);
        }
    }
}