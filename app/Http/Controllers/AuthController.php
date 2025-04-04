<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDO;

class AuthController extends Controller
{
    public function loginPage(){
        return view('auth.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()-> route('dashboard');
        }
        return back() -> withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }


    private function redirectTo($user)
    {
        // Redirect based on role
        return match ($user->role) {
            'admin' => 'admin.dashboard',
            'superAdmin' => 'superAdmin.dashboard',
            'deptHead' => 'deptHead.dashboard',
            'user' => 'user.dashboard',
            default => 'home', // Default fallback route
        };
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
