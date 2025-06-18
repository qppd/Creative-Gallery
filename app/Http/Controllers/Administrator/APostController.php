<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Post;

class APostController extends Controller
{
    function view()
    {
        $posts = Post::all();

        return view('administrator/posts', ['posts' => $posts]);
    }

    
}
