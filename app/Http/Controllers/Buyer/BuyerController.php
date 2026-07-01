<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function dashboard()
    {
        return view('buyer.dashboard');
    }
}
