<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Comment;

class CommentController extends Controller
{
    function view()
    {
        //SELECT `id`, `user_id`, `post_id`, `comment`, `created_at`, 
        //`updated_at` FROM `comments` WHERE 1
        $comments = Comment::select(
            'comments.id',
            'users.name',
            'comments.comment',
            'comments.created_at'
           
        )
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->get();
        return view('administrator/comments', ['comments' => $comments]);
    }

    

    function edit(Request $request)
    {
        $validation = [
            'id' => 'required',
            'name' => 'required|min:6|max:255',
            'status' => 'required',
        ];

        $request->validate($validation);

        $category = Category::find($request->id);
        $category->name = $request->employee_id;
        $category->status = $request->surname;

        if (!$category) {
            return redirect()->back()->withErrors([
                'message' => 'Category not found! Try again!',
            ]);
        }
        $isSaved = $category->save();

        if ($isSaved) {
            return redirect()->back()->with(
                'success',
                'Category has been updated successfully!'
            );
        } else {
            return redirect()->back()->withErrors([
                'message' => 'Category update failed! Try again later!',
            ]);
        }



    }

    function delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->back()->withErrors([
                'message' => 'Employee not found! Try again!',
            ]);
        }

        $isDeleted = $category->delete();
        if ($isDeleted) {
            return redirect()->back()->with('success', 'Category has been deleted successfully!');
        } else {
            return redirect()->back()->withErrors([
                'message' => 'Category delete failed! Try again!',
            ]);
        }
    }
}
