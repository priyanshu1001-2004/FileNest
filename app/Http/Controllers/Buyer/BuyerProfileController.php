<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerProfileController extends Controller
{
    public function index()
    {
        $buyer = auth()->user()->buyerDetail;

       

        return view('buyer.profile.index', compact('buyer'));
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
