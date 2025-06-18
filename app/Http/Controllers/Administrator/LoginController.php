<?php

namespace App\Http\Controllers\Administrator;

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
            $userRole = $user->role;
            // $userName = $user->name . ', ' . $user->firstname;
            $userName = $user->name;
            $userPhoto = $user->avatar;

            if ($userRole != 0) {

                Auth::logout();
                
                return redirect()->back()->withErrors([
                    'message' => 'Account invalid!',
                ]);
            }

            $req->session()->put('administrator', $userId);
            $req->session()->put('role', $userRole);
            $req->session()->put('name', $userName);
            $req->session()->put('photo', $userPhoto);
            // Authentication passed...
            return redirect('/admin/dashboard');
        } else {


            return redirect()->back()->withErrors([
                'message' => 'Username or password invalid!',
            ]);
        }
    }
}
