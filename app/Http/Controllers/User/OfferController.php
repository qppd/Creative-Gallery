<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Art;
use App\Models\Category;
use App\Models\Bidding;

class OfferController extends Controller
{
    public function view()
    {
        $userId = Auth::id();

        $offers = Bidding::select(
            'art.id',
            'art.name AS art_name',
            'art.photo',
            'categories.name AS category_name',
            'highest_bids.highest_offer',
            'art.starting_price',
            'art.description',
            'art.start_date',
            'art.end_date',
            'art.proof_of_ownership',
            'art.status AS art_status',
            'art.created_at',
            'biddings.id AS bidding_id',
            'biddings.enthusiast_id',
            'biddings.status AS bidding_status',
            DB::raw('
                CONCAT(
                    FLOOR(TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) / 86400), " days, ",
                    FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 86400) / 3600), " hours, ",
                    FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 3600) / 60), " minutes"
                ) AS duration
            '),
            DB::raw('
                CASE
                    WHEN EXISTS (
                        SELECT 1
                        FROM biddings
                        WHERE biddings.art_id = art.id
                          AND biddings.status = 1
                    ) THEN 1
                    ELSE 0
                END AS has_active_bid
            ')
        )
            ->join('art', 'art.id', '=', 'biddings.art_id')
            ->join('categories', 'categories.id', '=', 'art.category_id')
            ->leftJoin(DB::raw('(
            SELECT art_id, MAX(offer) AS highest_offer 
            FROM biddings
            GROUP BY art_id
        ) AS highest_bids'), 'art.id', '=', 'highest_bids.art_id')
            ->whereIn('art.status', [1, 2, 3]) // arts with status 1, 2, or 3
            ->where('categories.status', 1) // active categories
            ->where('biddings.enthusiast_id', $userId) // me
            ->groupBy(
                'art.id',
                'art.name',
                'art.photo',
                'categories.name',
                'highest_bids.highest_offer',
                'biddings.enthusiast_id',
                'biddings.status',
                'art.starting_price',
                'art.description',
                'art.start_date',
                'art.end_date',
                'art.proof_of_ownership',
                'art.status',
                'art.created_at',
                'biddings.id'
            )
            ->get();


        $categories = Category::all();

        return view('user.offers', ['arts' => $offers, 'categories' => $categories]);
    }

    public function artworks()
    {
        $userId = Auth::id();
        $offers = DB::table('art')
            ->select(
                'art.id',
                'art.name AS art_name',
                'art.photo',
                'categories.name AS category_name',
                'highest_bids.highest_offer',
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
            '),
                DB::raw('
                CASE
                    WHEN EXISTS (
                        SELECT 1
                        FROM biddings
                        WHERE biddings.art_id = art.id
                          AND biddings.status = 1
                    ) THEN 1
                    ELSE 0
                END AS has_active_bid
            ')
            )
            ->leftJoin('categories', 'categories.id', '=', 'art.category_id')
            ->leftJoin(DB::raw('(
            SELECT art_id, MAX(offer) AS highest_offer
            FROM biddings 
            GROUP BY art_id
        ) AS highest_bids'), 'art.id', '=', 'highest_bids.art_id')
            ->whereIn('art.status', [1, 2, 3]) // arts with status 1, 2, or 3
            ->where('categories.status', 1) // active categories
            ->where('art.user_id', $userId) // me
            ->groupBy(
                'art.id',
                'art.name',
                'art.photo',
                'categories.name',
                'highest_bids.highest_offer',
                'art.starting_price',
                'art.description',
                'art.start_date',
                'art.end_date',
                'art.proof_of_ownership',
                'art.status',
                'art.created_at'
            )
            ->orderBy('art.status', 'DESC')
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })
            ->toArray();
        $categories = Category::all();

        return view('user.artworks', ['arts' => $offers, 'categories' => $categories]);
    }


    public function artworksSold()
    {
        $userId = Auth::id();
        $offers = DB::table('art')
            ->select(
                'art.id',
                'art.name AS art_name',
                'art.photo',
                'categories.name AS category_name',
                'highest_bids.highest_offer',
                'highest_bids.bid_at',
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
            '),
                DB::raw('
                CASE
                    WHEN EXISTS (
                        SELECT 1
                        FROM biddings
                        WHERE biddings.art_id = art.id
                          AND biddings.status = 1
                    ) THEN 1
                    ELSE 0
                END AS has_active_bid
            ')
            )
            ->leftJoin('categories', 'categories.id', '=', 'art.category_id')
            ->leftJoin(DB::raw('(
            SELECT art_id, MAX(offer) AS highest_offer, created_at AS bid_at 
            FROM biddings 
            GROUP BY art_id, created_at
        ) AS highest_bids'), 'art.id', '=', 'highest_bids.art_id')
            ->whereIn('art.status', [1, 2, 3]) // arts with status 1, 2, or 3
            ->where('categories.status', 1) // active categories
            ->where('art.user_id', $userId) // me
            ->groupBy(
                'art.id',
                'art.name',
                'art.photo',
                'categories.name',
                'highest_bids.highest_offer',
                'highest_bids.bid_at',
                'art.starting_price',
                'art.description',
                'art.start_date',
                'art.end_date',
                'art.proof_of_ownership',
                'art.status',
                'art.created_at'
            )
            ->where('art.status', 3)
            ->orderBy('art.status', 'DESC')
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })
            ->toArray();
       
            return response()->json($offers);
    }

    
    public function artworksAvailable()
    {
        $userId = Auth::id();
        $offers = DB::table('art')
            ->select(
                'art.id',
                'art.name AS art_name',
                'art.photo',
                'categories.name AS category_name',
                'highest_bids.highest_offer',
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
            '),
                DB::raw('
                CASE
                    WHEN EXISTS (
                        SELECT 1
                        FROM biddings
                        WHERE biddings.art_id = art.id
                          AND biddings.status = 1
                    ) THEN 1
                    ELSE 0
                END AS has_active_bid
            ')
            )
            ->leftJoin('categories', 'categories.id', '=', 'art.category_id')
            ->leftJoin(DB::raw('(
            SELECT art_id, MAX(offer) AS highest_offer
            FROM biddings 
            GROUP BY art_id
        ) AS highest_bids'), 'art.id', '=', 'highest_bids.art_id')
            ->whereIn('art.status', [1, 2, 3]) // arts with status 1, 2, or 3
            ->where('categories.status', 1) // active categories
            ->where('art.user_id', $userId) // me
            ->groupBy(
                'art.id',
                'art.name',
                'art.photo',
                'categories.name',
                'highest_bids.highest_offer',
                'art.starting_price',
                'art.description',
                'art.start_date',
                'art.end_date',
                'art.proof_of_ownership',
                'art.status',
                'art.created_at'
            )
            ->where('art.status', 2)
            ->orderBy('art.status', 'DESC')
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })
            ->toArray();
       
            return response()->json($offers);
    }



    // public function artworks()
    // {
    //     $userId = Auth::id();
    //     $offers = Bidding::select(
    //         'art.id',
    //         'art.name AS art_name',
    //         'art.photo',
    //         'art.name',
    //         'categories.name AS category_name',
    //         'highest_bids.highest_offer',
    //         'art.starting_price',
    //         'art.description',
    //         'art.start_date',
    //         'art.end_date',
    //         'art.proof_of_ownership',
    //         'art.status AS art_status',
    //         'art.created_at', 
    //         DB::raw('
    //             CONCAT(
    //                 FLOOR(TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) / 86400), " days, ",
    //                 FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 86400) / 3600), " hours, ",
    //                 FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 3600) / 60), " minutes"
    //             ) AS duration
    //         '),
    //         DB::raw('
    //                     CASE
    //                         WHEN EXISTS (
    //                             SELECT 1
    //                             FROM biddings
    //                             WHERE biddings.art_id = art.id
    //                               AND biddings.status = 1
    //                         ) THEN 1
    //                         ELSE 0
    //                     END AS has_active_bid
    //                 ')
    //     )
    //         ->join('art', 'art.id', '=', 'biddings.art_id')
    //         ->join('categories', 'categories.id', '=', 'art.category_id')
    //         ->leftJoin(DB::raw('(
    //             SELECT art_id, MAX(offer) AS highest_offer
    //             FROM biddings 
    //             GROUP BY art_id
    //         ) AS highest_bids'), 'art.id', '=', 'highest_bids.art_id')

    //         ->whereIn('art.status', [1, 2, 3]) // arts with status 1, 2, or 3
    //         ->where('categories.status', 1) // active categories
    //         ->where('art.user_id', $userId) // me
    //         ->groupBy(
    //             'art.id',
    //             'art.name',
    //             'art.photo',
    //             'categories.name',
    //             'highest_bids.highest_offer',
    //             'art.starting_price',
    //             'art.description',
    //             'art.start_date',
    //             'art.end_date',
    //             'art.proof_of_ownership',
    //             'art.status',
    //             'art.created_at'
    //         )
    //         ->orderBy('art.status', 'DESC')
    //         ->get();

    //     $categories = Category::all();

    //     return view('user.offers', ['arts' => $offers, 'categories' => $categories]);
    // }
}
