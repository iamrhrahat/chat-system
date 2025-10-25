<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('chat', [
            'users' => $users,
            'receiver' => null,
            'messages' => collect()
        ]);
    }

    public function show($receiverId)
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $receiver = User::findOrFail($receiverId);

        $messages = Message::where(function ($q) use ($receiverId) {
                $q->where('sender_id', auth()->id())
                  ->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($q) use ($receiverId) {
                $q->where('sender_id', $receiverId)
                  ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at')
            ->get();

        return view('dashboard', compact('users', 'receiver', 'messages'));
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data['sender_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('chat-images', 'public');
        }

        Message::create($data);

        return redirect()->route('chat.show', $data['receiver_id']);
    }
}
