<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Art;
use App\Models\Category;
use App\Models\Bidding;

class HomeController extends Controller
{
    public function view()
    {

        // Get the ID of the authenticated user
        $userId = Auth::id();
        // Query to fetch arts that the user has not bid on
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
                            FLOOR(TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) / 86400), "D ",
                            FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 86400) / 3600), "H ",
                            FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 3600) / 60), "M"
                        ) AS duration
                    '),
            DB::raw('
                        CASE
                            WHEN EXISTS (
                                SELECT 1, biddings.enthusiast_id AS buyer_id 
                                FROM biddings
                                WHERE biddings.art_id = art.id
                                  AND biddings.status = 1
                            ) THEN 1
                            ELSE 0
                        END AS has_active_bid
                    ')
        )
        ->join('users', 'users.id', '=', 'art.user_id')
        ->join('categories', 'categories.id', '=', 'art.category_id')
        ->leftJoin('biddings', 'biddings.art_id', '=', 'art.id')

        ->whereNotExists(function ($query) use ($userId) {
            $query->select(DB::raw(1))
                ->from('biddings')
                ->whereRaw('biddings.art_id = art.id')
                ->where('biddings.enthusiast_id', $userId);
        })
        ->whereIn('art.status', [1, 2, 3]) // arts with status 1, 2, or 3
        ->where('users.status', '=', 1) // active users
        ->where('users.verification_status', 1) // verified users
        ->where('users.subscription_status', 1) // subscribed users
        ->groupBy(
            'art.id',
            'art_name',
            'art.photo',
            'artist',
            'art.name',
            'category_name',
            'art.starting_price',
            'art.description',
            'art.start_date',
            'art.end_date',
            'art.proof_of_ownership',
            'art_status',
            'art.created_at'
        )
        ->get();

      
       


        $categories = Category::all();

        return view('user.home', ['arts' => $arts, 'categories' => $categories]);
    }
}