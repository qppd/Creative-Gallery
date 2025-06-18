<?php
namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AccountController extends Controller
{
    function view()
    {

        // SELECT `id`, `username`, `name`, `email`, `contact`, `birthdate`, `password`, 
        // `status`, `role`, `avatar`, `place`, `valid_id`, `selfie`, `created_at`, 
        // `updated_at` FROM `users` WHERE 1

        $users = User::select(
            'users.id',
            'users.username',
            'users.name',
            'users.email',
            'users.contact',
            'users.birthdate',
            'users.status',
            'users.role',
            'users.avatar',
            'users.place',
            'users.valid_id',
            'users.selfie',
            'users.created_at',
        )
            ->whereIn('users.role', [1, 2])
            ->get();

        return view('administrator/accounts', ['accounts' => $users]);
    }

    function edit(){
        $users = User::select(
            'users.id',
            'users.username',
            'users.name',
            'users.avatar',
            'users.email',
            // 'users.email_verified_at',
        )
            ->where('users.is_admin', 0)
            ->get();

        return view('administrator/accounts', ['accounts' => $users]);
    }

    function deactivate($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->withErrors([
                'message' => 'User account not found! Try again!',
            ]);
        }
        $user->status = 0;

        $isSaved = $user->save();
        if ($isSaved) {
            return redirect()->back()->with('success', 'User account has been deactivated successfully!');
        } else {
            return redirect()->back()->withErrors([
                'message' => 'User account deactivation failed! Try again!',
            ]);
        }
    }

    function activate($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->withErrors([
                'message' => 'User account not found! Try again!',
            ]);
        }
        $user->status = 1;

        $isSaved = $user->save();
        if ($isSaved) {
            return redirect()->back()->with('success', 'User account has been activated successfully!');
        } else {
            return redirect()->back()->withErrors([
                'message' => 'User account activation failed! Try again!',
            ]);
        }
    }


}
