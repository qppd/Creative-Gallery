<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Art;

class BiddingController extends Controller
{
    function requests()
    {

        //SELECT `id`, `photo`, `user_id`, `name`, `category_id`, `starting_price`, 
        //`description`, `start_date`, `end_date`, `proof_of_ownership`, `status`, 
        //`created_at`, `updated_at` FROM `art` WHERE 1

        $requests = Art::select(
            'art.id',
            'art.photo',
            'users.name AS artist',
            'art.name',
            'categories.name AS category',
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
            ->where('art.status', '=', 0) // new
            ->where('users.status', '=', 1) // active
            ->where('users.verification_status', 1) // verified
            ->where('users.subscription_status', 1) // subscribed
            ->where('categories.status', 1) // active
            ->get();
        return view('administrator/requests', ['requests' => $requests]);
    }

    function approve($id)
    {
        $art = Art::find($id);
        $art->status = 2;
        $art->save();

        
        return redirect()->back()->with('success', 'Artwork has been approved!');
    }

    function reject($id)
    {
        $art = Art::find($id);
        $art->status = 4;
        $art->save();
        return redirect()->back()->with('success', 'Artwork request rejected!');
    }

    function biddings()
    {

        //SELECT `id`, `photo`, `user_id`, `name`, `category_id`, `starting_price`, 
        //`description`, `start_date`, `end_date`, `proof_of_ownership`, `status`, 
        //`created_at`, `updated_at` FROM `art` WHERE 1

        $biddings = Art::select(
            'art.id',
            'art.photo',
            'users.name AS artist',
            'art.name',
            'categories.name AS category',
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
            ->where('art.status', '=', 2) // bid
            ->where('users.status', '=', 1) // active
            ->where('users.verification_status', 1) // verified
            ->where('users.subscription_status', 1) // subscribed
            ->where('categories.status', 1) // active
            ->get();

        return view('administrator/biddings', ['biddings' => $biddings]);
    }

    function solds()
    {

        //SELECT `id`, `photo`, `user_id`, `name`, `category_id`, `starting_price`, 
        //`description`, `start_date`, `end_date`, `proof_of_ownership`, `status`, 
        //`created_at`, `updated_at` FROM `art` WHERE 1

        $solds = Art::select(
            'art.id',
            'art.photo',
            'users.name AS artist',
            'art.name',
            'categories.name AS category',
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
            
            ->where('art.status', '=', 3) // sold
            ->where('users.status', '=', 1) // active
            ->where('users.verification_status', 1) // verified
            ->where('users.subscription_status', 1) // subscribed
            ->where('categories.status', 1) // active
            ->get();

        return view('administrator/sold', ['solds' => $solds]);
    }
}
