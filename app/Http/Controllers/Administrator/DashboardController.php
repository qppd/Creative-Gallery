<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// use App\Models\User;

use App\Models\User;
use App\Models\Bidding;
use App\Models\Art;

// use App\Models\Like;

class DashboardController extends Controller
{
    function view()
    {

        // $administrators = User::whereIn('role', [0, 1])
        //     ->select(DB::raw('COUNT(*) as administrator_count'))
        //     ->get();

        $users = User::where('role', '>', 0)
            ->select(DB::raw('COUNT(*) as users'))
            ->get();

        $biddings = Bidding::select(DB::raw('COUNT(*) as biddings'))
            ->get();

        $arts = Art::whereIn('status', [1, 2])
            ->select(DB::raw('COUNT(*) as arts'))
            ->get();

        $sold = Art::where('status', 3)
            ->select(DB::raw('COUNT(*) as arts'))
            ->get();

        // $daily_posts_percentage = [];
        // $weekly_posts_percentage = [];
        // $monthly_posts_percentage = [];

        $currentDate = now()->format('Y-m');

        $daily_biddings_percentage = Bidding::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') AS date"),
            DB::raw("COUNT(*) AS total_biddings"),
            DB::raw("COUNT(*) / (SELECT COUNT(*) FROM biddings WHERE DATE_FORMAT(created_at, '%Y-%m') = '$currentDate') * 100 AS percentage")
        )
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $currentDate)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->get();

        $weekly_biddings_percentage = Bidding::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%v') AS week"),
            DB::raw("COUNT(*) AS total_biddings"),
            DB::raw("COUNT(*) / (SELECT COUNT(*) FROM biddings WHERE YEAR(created_at) = YEAR(NOW()) AND WEEK(created_at) = WEEK(NOW())) * 100 AS percentage")
        )
            ->whereYear('created_at', '=', now()->year)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%v')"))
            ->get();

        $monthly_biddings_percentage = Bidding::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') AS month"),
            DB::raw("COUNT(*) AS total_biddings"),
            DB::raw("COUNT(*) / (SELECT COUNT(*) FROM biddings WHERE YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())) * 100 AS percentage")
        )
            ->whereYear('created_at', '=', now()->year)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        return view('administrator/dashboard', [
            'users' => $users,
            'arts' => $arts,
            'biddings' => $biddings,
            'solds' => $sold,
            'daily_biddings_percentage' => $daily_biddings_percentage,
            'weekly_biddings_percentage' => $weekly_biddings_percentage,
            'monthly_biddings_percentage' => $monthly_biddings_percentage,
        ]);
    }
}
