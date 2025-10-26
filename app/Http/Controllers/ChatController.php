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

public function inbox()
    {
        $userId = Auth::id();

        // Fetch all conversations where the user is either user_one or user_two
        $conversations = Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['userOne', 'userTwo', 'lastMessage'])
            ->latest('updated_at')
            ->get();

        return view('dashboard.message', compact('conversations', 'userId'));
    }

}
