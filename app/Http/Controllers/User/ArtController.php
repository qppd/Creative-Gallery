<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Art;

class ArtController extends Controller
{
    function fetchArts()
    {
        $arts = Art::select(
            'art.id',
            'art.name AS art_name',
            'art.photo',
            'users.name AS artist',
            'art.name',
            'categories.name AS category_name',
            'art.starting_price',
            'art.description',
            'art.start_date',
            'art.end_date',
            'art.proof_of_ownership',
            'art.status AS art_status',
            'art.created_at',
            DB::raw('
                    CONCAT(
                        FLOOR(TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) / 86400), " days, ",
                        FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 86400) / 3600), " hours, ",
                        FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 3600) / 60), " minutes"
                    ) AS duration
                ')
        )
            ->join('users', 'users.id', '=', 'art.user_id')
            ->join('categories', 'categories.id', '=', 'art.category_id')
            ->whereIn('art.status', [1, 2, 3]) // new
            ->where('users.status', '=', 1) // active
            ->where('users.verification_status', 1) // verified
            ->where('users.subscription_status', 1) // subscribed
            ->where('categories.status', 1) // active
            ->get();

        return view('user/index', ['arts' => $arts]);
    }

    function fetchArts2()
    {
        $arts = Art::select(
            'art.id',
            'art.name AS art_name',
            'art.photo',
            'users.name AS artist',
            'art.name',
            'categories.name AS category_name',
            'art.starting_price',
            'art.description',
            'art.start_date',
            'art.end_date',
            'art.proof_of_ownership',
            'art.status AS art_status',
            'art.created_at',
            DB::raw('
                    CONCAT(
                        FLOOR(TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) / 86400), " days, ",
                        FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 86400) / 3600), " hours, ",
                        FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 3600) / 60), " minutes"
                    ) AS duration
                ')
        )
            ->join('users', 'users.id', '=', 'art.user_id')
            ->join('categories', 'categories.id', '=', 'art.category_id')
            ->whereIn('art.status', [1, 2, 3]) // new
            ->where('users.status', '=', 1) // active
            ->where('users.verification_status', 1) // verified
            ->where('users.subscription_status', 1) // subscribed
            ->where('categories.status', 1) // active
            ->get();

        return view('user/not_verified', ['arts' => $arts]);
    }

    public function store(Request $request)
    {

        $validation = [
            'title' => 'required|min:2|max:255',
            'description' => 'required|min:2|max:255',
            'category' => 'required',
            'start_date' => 'required',
            'photo' => 'required',
            'end_date' => 'required',
            'start_price' => 'required',
        ];

        $request->validate($validation);

        //SELECT `id`, `photo`, `user_id`, `name`, `category_id`, `starting_price`, 
        //`description`, `start_date`, `end_date`, `proof_of_ownership`, `status`, 
        //`created_at`, `updated_at` FROM `art` WHERE 1

        $art = new Art;
        $art->user_id = Auth::id();
        //$art->user_id = 1;
        $art->name = $request->title;
        $art->category_id = $request->category;
        $art->starting_price = $request->start_price;
        $art->description = $request->description;
        $art->start_date = $request->start_date;
        $art->end_date = $request->end_date;
        $image = $request->file('photo');
        $imageName = time() . rand(1, 100) . '.' . $image->getClientOriginalExtension();
        $image->move('storage/images/arts', $imageName);

        $customName = time() . '.' . $request->video->getClientOriginalExtension();
        $videoPath = $request->video->move('storage/videos/proofs', $customName);

        $art->photo = $imageName;
        $art->proof_of_ownership = $videoPath;

        $isSaved = $art->save();
        if ($isSaved) {
            return redirect()->back()->with('success', 'Your artwork has been successfully created. Please wait while verify it for you!');
        } else {
            return redirect()->back()->withErrors([
                'message' => 'Artwork add failed! Try again!',
            ]);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');


        $arts = Art::select(
            'art.id',
            'art.name AS art_name',
            'art.photo',
            'users.username AS artist_username',
            'users.name AS artist',
            'art.name',
            'categories.name AS category_name',
            'art.starting_price AS starting_price',
            'art.description',
            'art.start_date',
            'art.end_date',
            'art.proof_of_ownership',
            'art.status AS art_status',
            'art.created_at',
            DB::raw('
                CONCAT(
                    FLOOR(TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) / 86400), " days, ",
                    FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 86400) / 3600), " hours, ",
                    FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 3600) / 60), " minutes"
                ) AS duration
            ')
        )
        ->join('users', 'users.id', '=', 'art.user_id')
        ->join('categories', 'categories.id', '=', 'art.category_id')
        ->whereIn('art.status', [1, 2, 3]) // new
        ->where('users.status', '=', 1) // active
        ->where('users.verification_status', 1) // verified
        ->where('users.subscription_status', 1) // subscribed
        ->where('categories.status', 1) // active
        ->where('art.name', 'LIKE', '%' . $query . '%')
        ->get();

        return response()->json($arts);
    }

}
