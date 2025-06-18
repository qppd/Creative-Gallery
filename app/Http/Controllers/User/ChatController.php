<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Chat;
use App\Models\Category;
use App\Models\User;
use App\Models\Art;

class ChatController extends Controller
{
    function view()
    {
        $categories = Category::select(
            'categories.id',
            'categories.name',
            'categories.status',
            'categories.created_at',
        )
            ->get();


        $userChatList = Chat::select('users.avatar', 'users.name', 'users.id')
            ->leftJoin('users', function ($join) {
                $join->on('chats.sender_id', '=', 'users.id')
                    ->orOn('chats.receiver_id', '=', 'users.id');
            })
            ->where(function ($query) {
                $userid = Auth::id();
                $query->where('chats.sender_id', '=', $userid)
                    ->orWhere('chats.receiver_id', '=', $userid);
            })
            ->where('users.id', '!=', Auth::id())
            ->groupBy('users.avatar', 'users.name', 'users.id')
            ->orderBy('chats.created_at', 'asc')
            ->get();

        $users = User::all();
        $arts = Art::all();

        return view('user.messages', ['arts' => $arts, 'categories' => $categories, 'chats' => $userChatList, 'users' => $users]);

    }

    public function sendMessage(Request $request)
    {
        $receiverId = $request->input('user_id');
        $message = $request->input('message');
        $user = User::findOrFail($receiverId);

        if ($user) {
            $chat = new Chat();
            $chat->sender_id = Auth::id();
            $chat->receiver_id = $receiverId;
            $chat->message = $message;
            $chat->save();
        }
        return response()->json($message);

    }
}
