<?php
namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\User;

class RegistrationController extends Controller
{
    public function view()
    {
        return view('user/signup');
    }

    public function register(Request $request)
    {

        $user = User::select(
            'users.id',
        )
            ->where('users.email', $request->email)
            ->first();

        if ($user) {
            return redirect()->back()->withErrors([
                'message' => 'Email is already registered! Try again!',
            ]);
        }

        $user = User::select(
            'users.id',
        )
            ->where('users.contact', $request->contact)
            ->first();

        if ($user) {
            return redirect()->back()->withErrors([
                'message' => 'Contact No. is already used! Try again!',
            ]);
        }


        if ($request->hasFile('avatar_photo')) {
            $avatar_photo = $request->file('avatar_photo');
            $avatar_image_name = time() . rand(1, 100) . '.' . $avatar_photo->getClientOriginalExtension();
            $avatar_photo->move('storage/images/avatars', $avatar_image_name);
        }

        if ($request->hasFile('place_photo')) {
            $place_photo = $request->file('place_photo');
            $place_image_name = time() . rand(1, 100) . '.' . $place_photo->getClientOriginalExtension();
            $place_photo->move('storage/images/places', $place_image_name);

        }

        if ($request->hasFile('valid_id_photo')) {
            $valid_id_photo = $request->file('valid_id_photo');
            $valid_id_image_name = time() . rand(1, 100) . '.' . $valid_id_photo->getClientOriginalExtension();
            $valid_id_photo->move('storage/images/ids', $valid_id_image_name);
        }

        if ($request->hasFile('selfie_photo')) {
            $selfie_photo = $request->file('selfie_photo');
            $selfie_image_name = time() . rand(1, 100) . '.' . $selfie_photo->getClientOriginalExtension();
            $selfie_photo->move('storage/images/selfies', $selfie_image_name);
        }

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $username = '';
        $length = 6; // Minimum length of username

        for ($i = 0; $i < $length; $i++) {
            $username .= $characters[rand(0, strlen($characters) - 1)];
        }

        $birthdate = Carbon::createFromFormat('m/d/Y', $request->birthdate)->format('Y-m-d');

        $user = new User;
        $user->username = $username;
        $user->name = ucwords($request->firstname) . ' ' . ucwords($request->lastname);
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->birthdate = $birthdate;
        $user->password = Hash::make($request->password);
        $user->birthdate = $birthdate;
        $user->status = 1;
        $user->role = $request->role;
        $user->avatar = $avatar_image_name;
        if ($request->role == 2) {
            $user->place = $place_image_name;
        }

        $user->valid_id = $valid_id_image_name;
        $user->selfie = $selfie_image_name;


        // SELECT `id`, `username`, `name`, `email`, `contact`, `birthdate`, `password`, 
        // `status`, `role`, `avatar`, `place`, `valid_id`, `selfie`, `created_at`, 
        // `updated_at` FROM `users` WHERE 1

        $isSaved = $user->save();
        if ($isSaved) {
            return redirect()->back()->with('success', 'Thank you for signing up on our website! Your registration is currently under review. Please wait for approval.');
        } else {
            return redirect()->back()->withErrors([
                'message' => 'Registration failed! Try again!',
            ]);
        }


    }


    public function generateRandomUsername()
    {
        // Generate random username with letters and numbers
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $username = '';
        $length = 6; // Minimum length of username

        for ($i = 0; $i < $length; $i++) {
            $username .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $username;
    }

    // public function uploadAvatar(Request $request)
    // {
    //     $image = $request->file('file');
    //     $imageName = time() . rand(1, 100) . '.' . $image->extension();
    //     $image->move('storage/images/avatars', $imageName);


    //     return response()->json(["success", $request]);
    // }

    // public function uploadPlace(Request $request)
    // {
    //     $image = $request->file('file');
    //     $imageName = time() . rand(1, 100) . '.' . $image->extension();
    //     $image->move('storage/images/places', $imageName);


    //     return response()->json(["success", $request]);
    // }

    // public function uploadId(Request $request)
    // {
    //     $image = $request->file('file');
    //     $imageName = time() . rand(1, 100) . '.' . $image->extension();
    //     $image->move('storage/images/ids', $imageName);


    //     return response()->json(["success", $request]);
    // }

    // public function uploadSelfie(Request $request)
    // {
    //     $image = $request->file('file');
    //     $imageName = time() . rand(1, 100) . '.' . $image->extension();
    //     $image->move('storage/images/selfies', $imageName);


    //     return response()->json(["success", $request]);
    // }


}
