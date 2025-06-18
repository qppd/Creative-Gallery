<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    function login(Request $req)
    {

        $credentials = $req->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $userId = Auth::id();
            $userName = $user->username;
            $name = $user->name;
            $userEmail = $user->email;
            $userContact = $user->contact;
            $userRole = $user->role;
            $userPhoto = $user->avatar;

            $subscriptionStatus = $user->subscription_status;
            $verificationStatus = $user->verification_status;

            if ($userRole == 2) {
                $userType = "ARTIST";
            } else {
                $userType = "BUYER";
            }

            if ($verificationStatus == 0) {
                Auth::logout();
                return redirect('/not-verified');
            }

            if ($userRole == 0) {
                Auth::logout();
                return redirect()->back()->withErrors([
                    'message' => 'Account invalid!',
                ]);
            }

            $req->session()->put('user', $userId);
            $req->session()->put('role', $userRole);
            $req->session()->put('username', $userName);
            $req->session()->put('name', $name);
            $req->session()->put('contact', $userContact);
            $req->session()->put('email', $userEmail);
            $req->session()->put('photo', $userPhoto);
            $req->session()->put('type', $userType);

            $req->session()->put('subscribed', $subscriptionStatus);
            // Authentication passed...
            return redirect('/home');
        } else {


            return redirect()->back()->withErrors([
                'message' => 'Username or password invalid!',
            ]);
        }
    }


}
