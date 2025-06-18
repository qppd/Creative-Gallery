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
                            FLOOR(TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) / 86400), " days, ",
                            FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 86400) / 3600), " hours, ",
                            FLOOR((TIMESTAMPDIFF(SECOND, STR_TO_DATE(art.start_date, "%m/%d/%Y %h:%i %p"), STR_TO_DATE(art.end_date, "%m/%d/%Y %h:%i %p")) % 3600) / 60), " minutes"
                        ) AS duration
                    ')
        )
            ->join('users', 'users.id', '=', 'art.user_id')
            ->join('categories', 'categories.id', '=', 'art.category_id')
            ->whereIn('art.status', [1, 2, 3]) // arts with status 1, 2, or 3
            ->where('users.status', '=', 1) // active users
            ->where('users.verification_status', 1) // verified users
            ->where('users.subscription_status', 1) // subscribed users
            ->where('categories.status', 1) // active categories
            ->where('art.user_id', $userId) // me
            ->get();

        $categories = Category::all();

        return view('user.offers', ['arts' => $arts, 'categories' => $categories]);
    }
}