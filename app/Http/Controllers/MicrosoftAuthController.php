<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MicrosoftAuthController extends Controller
{
   // Redirect to Microsoft login
   public function redirectToMicrosoft()
    {
        return Socialite::driver('microsoft')->redirect();
    }

   // Handle Microsoft callback
   public function handleMicrosoftCallback()
   {
       $mUser = Socialite::driver('microsoft')->user();

    //    $mUser = Socialite::driver('microsoft')->stateless()->user();

       $user = User::updateOrCreate(
           ['email' => $mUser->getEmail()],
           [
               'name' => $mUser->getName(),
               'password' => bcrypt(str()->random(16)),
               'role' => 'user' // Default role, change if needed
           ]
       );

       // Log in the user
       Auth::login($user);

       // Redirect to home or dashboard
       return match ($user->role) {
        'admin' => redirect('/admin'),
        'superAdmin' => redirect('/super-admin'),
        'deptHead' => redirect('/dept-head'),
        default => redirect('/user'),
    };
   }
}
