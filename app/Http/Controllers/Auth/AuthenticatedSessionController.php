<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create(Request $request)
    {
       
        if ($request->has('redirect')) {
            session(['redirect_after_login' => $request->redirect]);
        }
        
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

          
            if (session()->has('redirect_after_login')) {
                $redirectUrl = session('redirect_after_login');
                session()->forget('redirect_after_login');
                return redirect($redirectUrl);
            }

            
            return match ($user->role) {
                'admin'      => redirect()->route('admin.dashboard'),
                'shop_owner' => redirect()->route('shop.dashboard'),
                'customer'   => redirect()->route('index'),
                default      => redirect()->route('index'),
            };
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}