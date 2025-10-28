<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $conversations = Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['userOne', 'userTwo', 'lastMessage'])
            ->latest('updated_at')
            ->get();

        return view('dashboard.message', compact('conversations', 'userId'));
    }

public function shown($id)
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

    public function show(User $user)
    {
        // Load the chat view for the selected user
        return view('dashboard', compact('user'));
    }
}
