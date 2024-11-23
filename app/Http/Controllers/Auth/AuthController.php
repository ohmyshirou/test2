<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        Log::info('Attempting Login', [
            'credentials' => $credentials,
            'Auth::check() before' => Auth::check(),
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            $user = Auth::user(); // Ambil data user yang login
    
            Log::info('Login Successful', [
                'Auth::id()' => Auth::id(),
                'Auth::user()' => $user,
            ]);
    
            // Redirect berdasarkan role
            switch ($user->role->name) {
                case 'hima':
                    return redirect()->route('dashboard.user'); // Route untuk dashboard user
                case 'dekan':
                case 'warek':
                case 'bkal':
                    return redirect()->route('dashboard.admin'); // Route untuk dashboard admin
                default:
                    Log::warning('Unknown role for user', ['role' => $user->role->name]);
                    Auth::logout();
                    return redirect()->route('login')->withErrors('Your account does not have a valid role.');
            }
        }
    
        Log::error('Login Failed', ['credentials' => $credentials]);
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }
    

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have logged out successfully.');
    }
}
