<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Art;
use App\Models\Bidding;

class BiddingController extends Controller
{
    function offer(Request $request)
    {

        $bidding = Bidding::select(
            'biddings.id',
        )
            ->join('art', 'art.id', '=', 'biddings.art_id')
            ->join('users', 'users.id', '=', 'biddings.enthusiast_id')
            ->where('art.id', '=', $request->art_id)
            ->where('biddings.offer', '=', $request->offer)
            ->first();

        if ($bidding) {

            return redirect()->back()->withErrors([
                'message' => 'Bidding failed! Offer must be higher than the previous offer!',
            ]);
        }


        $bidding = Bidding::select(
            'biddings.id',
        )
            ->join('art', 'art.id', '=', 'biddings.art_id')
            ->join('users', 'users.id', '=', 'biddings.enthusiast_id')
            ->where('users.id', '=', Auth::id())
            ->where('art.id', '=', $request->art_id)
            //->where('biddings.offer', '=', $request->offer)
            ->first();

        if ($bidding) {
            // Use the ID to find the Bidding model instance
            $bidding = Bidding::find($bidding->id);

            // Update the fields as needed
            $bidding->offer = $request->offer;

        } else {
            $bidding = new Bidding;
            $bidding->art_id = $request->art_id;
            $bidding->enthusiast_id = Auth::id();
            $bidding->offer = $request->offer;
        }

        $isSaved = $bidding->save();
        if ($isSaved) {
            return redirect()->back()->with('success', 'Bidding has been added successfully!');
        } else {
            return redirect()->back()->withErrors([
                'message' => 'Bidding add failed! Try again!',
            ]);
        }
    }

    function offers(Request $request)
    {

        $biddings = Bidding::select(
            'biddings.id',
            'biddings.offer',
            'users.avatar',
            'users.email',
            'users.contact',
            'users.name'
        )
            ->join('users', 'users.id', '=', 'biddings.enthusiast_id')
            ->where('biddings.art_id', '=', $request->id)
            ->orderBy('biddings.offer', 'desc') // Sort by biddings.offer in descending order
            ->get();
        return response()->json($biddings);
    }
}
