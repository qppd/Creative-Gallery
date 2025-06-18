<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use App\Mail\ApproveMailer;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    function view()
    {
        $unverified_accounts = User::select(
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
            ->where('users.verification_status', 0)
            ->get();
        return view('administrator/verifications', ['unverified_accounts' => $unverified_accounts]);
    }

    function approve($id)
    {

        $user = User::find($id);
        $user->verification_status = 1;
        $user->save();

        // $user = User::select(
        //     'users.name',
        //     'users.email'
        // )
           
        //     ->where('users.id', $id)
        //     ->get();

        Mail::to($user->email)->send(new ApproveMailer($user->name, "https://creative-gallery.online/signin"));


        return redirect()->back()->with('success', 'Account has been approved!');

        // return view('administrator/verifications', ['unverified_accounts' => $unverified_accounts]);
    }

    function reject($id)
    {
        $user = User::find($id);
        $user->verification_status = 2;
        $user->save();

        $unverified_accounts = User::select(
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
            ->where('users.verification_status', 0)
            ->get();

        return redirect()->back()->with('success', 'Account verification request rejected!');
    }

}
