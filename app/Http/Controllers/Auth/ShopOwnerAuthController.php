<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ShopOwner;

class ShopOwnerAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register-shop', ['role' => 'shop_owner']);
    }

   public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'shop_name' => 'required|string|max:255',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'shop_owner',
    ]);

    ShopOwner::create([
        'user_id' => $user->id,
        'shop_name' => $request->shop_name,
    ]);

    auth()->login($user);

    return redirect('/shop/dashboard');
}

}
