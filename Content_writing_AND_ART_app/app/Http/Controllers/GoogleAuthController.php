<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            // get google user details
            $google_user = Socialite::driver('google')->user();

            // check if user exist by google id
            /**
             * Check if any user in the user table has the google id == google_user id
             */
            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                //check if user exist by email
                $user = User::where('email', $google_user->getEmail())->first();

                if (!$user) {
                    //create new user if email does not exist
                    $user = User::create([
                        'name' => $google_user->getName(),
                        'email' => $google_user->getEmail(),
                        'google_id' => $google_user->getId()
                    ]);     
    
                    $user->assignRole('student');
                } else {
                    //update existing user with google id
                    $user->update(['google_id' => $google_user->getId()]);
                }

            }
        
            Auth::login($user);
            return redirect()->intended('/');


        }catch (\Throwable $th) {
            \Log::error('Something went wrong'. $th->getMessage());
            return redirect()->route('login')->with('error', 'Something went wrong while logging in with Google');

        }
    }
}
