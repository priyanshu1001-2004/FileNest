<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SellerRegisterController extends Controller
{
    public function create()
    {
        return view('auth.seller-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::forceCreate([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 1,
            'status' => false,
        ]);

        auth()->login($user);

        if ($user->isSeller() && !$user->status) {
            auth()->logout();
            return redirect()->route('login')->with('status', 'Your seller registration was successful! Please wait for admin approval before logging in.');
        }

        return redirect('/dashboard');
    }
}
