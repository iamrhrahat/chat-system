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

    public function send(Request $request, $conversationId)
{
    $request->validate([
        'body' => 'nullable|string|max:1000',
        'attachment' => 'nullable|file|max:2048',
    ]);

    $conversation = Conversation::findOrFail($conversationId);

    // Security: only conversation participants can send messages
    $userId = auth()->id();
    if ($conversation->user_one_id !== $userId && $conversation->user_two_id !== $userId) {
        abort(403, 'Unauthorized');
    }

    // Handle file upload
    $path = null;
    if ($request->hasFile('attachment')) {
        $path = $request->file('attachment')->store('attachments', 'public');
    }

    // Create message
    $message = $conversation->messages()->create([
        'sender_id' => $userId,
        'body' => $request->body ?? '',
        'attachment' => $path,
    ]);

    // ✅ Update conversation’s last message reference & updated_at timestamp
    $conversation->update([
        'last_message_id' => $message->id,
        'updated_at' => now(),
    ]);

    return back();
}


}
