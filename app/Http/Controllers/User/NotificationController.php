<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Art;
use App\Models\Bidding;
use App\Models\User;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function getNotifications()
    {

        $timezone = 'Asia/Manila';
        Carbon::setLocale('en');
        $currentDateTime = Carbon::now($timezone);

        $userId = Auth::id();

        try {
            $results = Art::select(
                'art.id as art_id',
                'art.name as art_name',
                'users.name as highest_bidder_name',
                'users.id as highest_bidder_id',
                'biddings.id as highest_bidding_id',
                'biddings.offer as highest_bidder_offer'
            )
                ->join(DB::raw('(SELECT art_id, MAX(offer) AS max_offer FROM biddings GROUP BY art_id) as b_max'), 'art.id', '=', 'b_max.art_id')
                ->join('biddings', function ($join) {
                    $join->on('biddings.art_id', '=', 'b_max.art_id')
                        ->on('biddings.offer', '=', 'b_max.max_offer');
                })
                ->join('users', 'biddings.enthusiast_id', '=', 'users.id')
                ->whereRaw("STR_TO_DATE(art.end_date, '%m/%d/%Y %l:%i %p') < ?", [ $currentDateTime])
                ->where('art.user_id', $userId)
                ->where('biddings.status', 0)
                ->get();



            return response()->json($results);
        } catch (\Exception $e) {
            \Log::error('Error fetching notifications: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching notifications'], 500);
        }
    }
}
