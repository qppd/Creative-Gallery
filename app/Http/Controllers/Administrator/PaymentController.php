<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Payment;

class PaymentController extends Controller
{
    function view()
    {
        //SELECT `id`, `bidding_id`, `reference_id`, 
        //`url`, `status`, `created_at`, `updated_at` FROM `payments` WHERE 1

        $payments = Payment::select(
            'payments.id',
            'payments.reference_id',
            'art.name AS art_name', 
            'artist.name AS artist_name', 
            'biddings.offer AS bidding_offer', 
            'enthusiast.name AS enthusiast_name', 
            'payments.url',
            'payments.status',
            'payments.created_at'
        )
        ->join('biddings', 'biddings.id', '=', 'payments.bidding_id')
        ->join('art', 'art.id', '=', 'biddings.art_id')
        ->join('users AS enthusiast', 'enthusiast.id', '=', 'biddings.enthusiast_id') // enthusiast
        ->join('users AS artist', 'artist.id', '=', 'art.user_id') // artist
        ->get();

        return view('administrator/payments', ['payments' => $payments]);
    }

    function add(Request $request)
    {
        // $validation = [
        //     'name' => 'required|min:2|max:255',
        // ];

        // $request->validate($validation);

        // $category = new Category;
        // $category->name = $request->name;

        // $isSaved = $category->save();
        // if ($isSaved) {
        //     return redirect()->back()->with('success', 'Category has been added successfully!');
        // } else {
        //     return redirect()->back()->withErrors([
        //         'message' => 'Category add failed! Try again!',
        //     ]);
        // }
    }

    function edit(Request $request)
    {
        // $validation = [
        //     'id' => 'required',
        //     'name' => 'required|min:6|max:255',
        //     'status' => 'required',
        // ];

        // $request->validate($validation);

        // $category = Category::find($request->id);
        // $category->name = $request->employee_id;
        // $category->status = $request->surname;

        // if (!$category) {
        //     return redirect()->back()->withErrors([
        //         'message' => 'Category not found! Try again!',
        //     ]);
        // }
        // $isSaved = $category->save();

        // if ($isSaved) {
        //     return redirect()->back()->with(
        //         'success',
        //         'Category has been updated successfully!'
        //     );
        // } else {
        //     return redirect()->back()->withErrors([
        //         'message' => 'Category update failed! Try again later!',
        //     ]);
        // }

    }

    function delete($id)
    {
        // $category = Category::find($id);

        // if (!$category) {
        //     return redirect()->back()->withErrors([
        //         'message' => 'Employee not found! Try again!',
        //     ]);
        // }

        // $isDeleted = $category->delete();
        // if ($isDeleted) {
        //     return redirect()->back()->with('success', 'Category has been deleted successfully!');
        // } else {
        //     return redirect()->back()->withErrors([
        //         'message' => 'Category delete failed! Try again!',
        //     ]);
        // }
    }
}
