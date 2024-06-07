<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LockScreenController extends Controller
{
    public function showLockScreen(Request $request)
    {
        // Passing $previousURL from Javascript's client-side storage to 
        // Laravel's sever-side session handling
        if ($request->has('previousURL')) {
            session()->put('previousURL', $request->query('previousURL'));
        }

        return view('lock-screen');
    }

    public function unlock (Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        if ($request->email === Auth::user()->email) {
            session()->put('unlocked', true);

            // Retrieve previous URL from session storage and redirect to it
            $previousURL = session()->pull('previousURL', '/'); //Default redirect -> '/' if URL isn't stored
            return redirect($previousURL);
        } else {
            return back()->withErrors(['email' => 'The provided email does not match the logged-in user.']);
        }
    }
}
