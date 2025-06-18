<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Chat;

class ChatController extends Controller
{
    function view()
    {
        // $categories = Chat::select(
        //     'categories.id',
        //     'categories.name',
        //     'categories.status',
        //     'categories.created_at',
        // )
        //     ->get();

        // return view('administrator/categories', ['categories' => $categories]);
        return view('chat');
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
        //     $category = Category::find($id);

        //     if (!$category) {
        //         return redirect()->back()->withErrors([
        //             'message' => 'Employee not found! Try again!',
        //         ]);
        //     }

        //     $isDeleted = $category->delete();
        //     if ($isDeleted) {
        //         return redirect()->back()->with('success', 'Category has been deleted successfully!');
        //     } else {
        //         return redirect()->back()->withErrors([
        //             'message' => 'Category delete failed! Try again!',
        //         ]);
        //     }
    }
}
