<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){

        $user = Auth::user(); // Get logged-in user

        // Redirect based on role
        switch ($user->role) {
            case 'admin':
                return redirect('/admin');
            case 'superAdmin':
                return redirect('/super-admin');
            case 'deptHead':
                return redirect('/dept-head');
            case 'user':
                return redirect('/user');
            default:
                return redirect('/home'); // Fallback route
        }
    }
    
}
