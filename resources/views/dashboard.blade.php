<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chat</title>
  <style>
    :root {
      --bg: #f4f6fa;
      --panel: #fff;
      --border: #e0e6ef;
      --primary: #2b8cff;
      --success: #25c38a;
      --muted: #8b97a9;
      --msg-me: #e9f3ff;
      --msg-other: #ffffff;
      font-family: Inter, "Segoe UI", sans-serif;
    }

    body {
      background: var(--bg);
      margin: 0;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .chat-wrapper {
      display: flex;
      width: 90%;
      max-width: 1100px;
      background: var(--panel);
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      height: 80vh;
    }

    /* Left: users list */
    .user-panel {
      width: 30%;
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
    }

    .search-box {
      padding: 12px;
      border-bottom: 1px solid var(--border);
    }
    .search-box input {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid var(--border);
      border-radius: 8px;
      outline: none;
      font-size: 14px;
    }

    .user-list {
      overflow-y: auto;
      flex: 1;
    }

    .user {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      border-bottom: 1px solid var(--border);
      cursor: pointer;
      text-decoration: none;
      color: #222;
    }
    .user:hover {
      background: #f9fbff;
    }

    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--primary);
      color: #fff;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .user-info {
      flex: 1;
    }
    .user-info h4 {
      margin: 0;
      font-size: 15px;
      font-weight: 600;
    }
    .user-info span {
      color: var(--muted);
      font-size: 13px;
    }

    /* Right: chat */
    .chat-panel {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .chat-header {
      padding: 16px;
      border-bottom: 1px solid var(--border);
      font-weight: 600;
      font-size: 16px;
    }

    .messages {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 10px;
      background: var(--bg);
    }

    .msg {
      padding: 10px 14px;
      border-radius: 10px;
      max-width: 70%;
      word-wrap: break-word;
    }

    .msg.me {
      align-self: flex-end;
      background: var(--msg-me);
    }

    .msg.other {
      align-self: flex-start;
      background: var(--msg-other);
      border: 1px solid #e8eef6;
    }

    .msg img {
      display: block;
      max-width: 220px;
      border-radius: 8px;
      margin-top: 6px;
    }

    .send-box {
      padding: 12px;
      border-top: 1px solid var(--border);
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .send-box input[type="file"] {
      display: none;
    }

    .send-box label {
      background: #f1f5fb;
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 8px 12px;
      cursor: pointer;
      font-size: 14px;
    }

    .send-box input[type="text"] {
      flex: 1;
      padding: 8px 12px;
      border-radius: 8px;
      border: 1px solid var(--border);
      outline: none;
      font-size: 14px;
    }

    .send-box button {
      background: var(--primary);
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
    }

    .send-box button:hover {
      background: #1a6de0;
    }

  </style>
</head>
<body>
    @php
    $users = $users ?? collect();
    $messages = $messages ?? collect();
    $receiver = $receiver ?? null;
@endphp

  <div class="chat-wrapper">
    <!-- Left side -->
    <div class="user-panel">
      <div class="search-box">
        <input type="text" placeholder="Search users...">
      </div>
      <div class="user-list">
        @foreach ($users as $user)
          <a href="{{ route('chat.show', $user->id) }}" class="user">
            <div class="avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
            <div class="user-info">
              <h4>{{ $user->name }}</h4>
              <span>{{ $user->is_online ? 'Online' : 'Offline' }}</span>
            </div>
          </a>
        @endforeach
      </div>
    </div>

    <!-- Right side -->
    <div class="chat-panel">
      <div class="chat-header">
        Chat with {{ $receiver->name ?? 'Select a user' }}
      </div>

      <div class="messages">
        @forelse ($messages as $msg)
          <div class="msg {{ $msg->sender_id == auth()->id() ? 'me' : 'other' }}">
            @if ($msg->message)
              <p>{{ $msg->message }}</p>
            @endif
            @if ($msg->image)
              <img src="{{ asset('storage/' . $msg->image) }}" alt="Attachment">
            @endif
          </div>
        @empty
          <p style="color:var(--muted); text-align:center;">No messages yet</p>
        @endforelse
      </div>

      @if(isset($receiver))
      <form action="{{ route('chat.send') }}" method="POST" enctype="multipart/form-data" class="send-box">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
        <label for="image">📎</label>
        <input type="file" name="image" id="image" accept="image/*">
        <input type="text" name="message" placeholder="Type your message...">
        <button type="submit">Send</button>
      </form>
      @endif
    </div>
  </div>
</body>
</html>
