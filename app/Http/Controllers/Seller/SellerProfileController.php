<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerProfileController extends Controller
{
    public function index()
    {
        $seller = auth()->user()->sellerDetail;
        return view('seller.profile.index', compact('seller'));
    }

    public function store(Request $request)
    {
        // Create Seller Profile
    }

    public function update(Request $request)
    {
        // Update Seller Profile
    }
}
