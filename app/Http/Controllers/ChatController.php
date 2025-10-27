<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{

    public function index()
    {
        $userId = Auth::id();
        $conversations = Conversation::where('user_one_id', $userId)
        ->orWhere('user_two_id', $userId)
        ->with(['lastMessage', 'userOne', 'userTwo'])
        ->latest()
        ->get();

        return view ('dashboard.message', compact('conversations', 'userId'));
    }

    public function show($id)
    {
        $userId = Auth::id();
        $userName = Auth::user()->name;
        $conversation = Conversation::with(['messages.sender', 'userOne', 'userTwo'])->findOrFail($id);

        if ($conversation->user_one_id !== $userId && $conversation->user_two_id !== $userId) {
            abort(403, 'Unauthorized');
        }

        $otherUser = $conversation->user_one_id == $userId
            ? $conversation->userTwo
            : $conversation->userOne;

        return view('dashboard.chat', compact('conversation', 'otherUser', 'userId' ,'userName'));
    }
}
