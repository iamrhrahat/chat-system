@extends('layout')
@section('content')
<div class="main_content_iner ">
<div class="container-fluid p-0">
<div class="row justify-content-center">
<div class="col-12">
<div class="dashboard_header mb_50">
<div class="row">
<div class="col-lg-6">
<div class="dashboard_header_title">
<h3> Chat</h3>
</div>
</div>
<div class="col-lg-6">
<div class="dashboard_breadcam text-end">
<p><a href="{{ route('dashboard') }}">Dashboard</a> <i class="fas fa-caret-right"></i> Chat</p>
</div>
</div>
</div>
</div>
</div>
<div class="col-lg-12">
<div class="messages_box_area">
<div class="messages_list">
<div class="white_box ">
<div class="white_box_tittle list_header">
<h4>Conversation List</h4>
</div>
<div class="serach_field_2">
<div class="search_inner">
<form active="#">
<div class="search_field">
<input type="text" placeholder="Search content here...">
</div>
<button type="submit"> <i class="ti-search"></i> </button>
</form>
</div>
</div>
@php
    $userId = Auth::id();

        $conversations = \App\Models\Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['userOne', 'userTwo', 'lastMessage'])
            ->latest('updated_at')
            ->get();
@endphp
<ul>
    @forelse($conversations as $conversation)
        @php
            // Determine the other participant
            $otherUser = $conversation->user_one_id == $userId
                ? $conversation->userTwo
                : $conversation->userOne;
        @endphp
<li>
<a href="{{ route('dashboard.chat', $conversation->id) }}">
<div class="message_pre_left">
<div class="message_preview_thumb">
<img src="{{ asset('asset/dashboard/img/messages/1.png')}}" alt>
</div>
<div class="messges_info">
<h4>{{ $otherUser->name }}</h4>
@if($conversation->lastMessage)
                    <p class="text-gray-600 text-sm truncate w-60 d-flex align-items-center">
                        {{-- If last message is mine, show a reply icon --}}
                        @if($conversation->lastMessage->sender_id == auth()->id())
                            <i class="fa fa-reply me-1 text-primary" title="You replied"></i>
                        @endif

                        {{ $conversation->lastMessage->body }}
                    </p>
                @else
                    <p class="text-gray-400 text-sm italic">No messages yet</p>
                @endif
</div>

</div>

<div class="messge_time">
      @if($conversation->lastMessage)
                 <span></span>   {{ $conversation->lastMessage->created_at   }} </span>
                @endif

</div>
@empty
        <p class="text-gray-500">No conversations yet.</p>
    @endforelse
</a>
</li>

</ul>
</div>
</div>
<div class="messages_chat mb_30">
    <div style="padding-left: 2%" class="message_pre_left">
        <div class="messges_info">
            <h4 style="font-weight: bold">{{ $otherUser->name }}</h4>

        </div>

    </div>
    @forelse($conversation->messages as $message)
    @php
        $isMine = $message->sender_id == $userId;
        // Fallback if sender relation missing:
        $senderName = $message->sender->name ?? ($isMine ? auth()->user()->name : $otherUser->name);
        @endphp

@if($isMine)

<div class="white_box ">
            <div class="single_message_chat sender_message">


                <div style="padding: 8px 12px;
                            border-radius: 10px;
                            word-wrap: break-word;"
                 class="message_content_view red_border">
                    <p>{{ $message->body }}</p>


                </div>
                 @if($message->attachment)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">
                                📎 View Attachment
                            </a>
                        </div>
                    @endif
                <p style="text-align: right">{{ $message->created_at  }}</p>
            </div>
            @else
            <div class="single_message_chat">


            <div style="padding: 8px 12px;
                            border-radius: 10px;
                            word-wrap: break-word;" class="message_content_view">
                <p>{{ $message->body }}</p>

            </div>
             @if($message->attachment)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">
                                📎 View Attachment
                            </a>
                        </div>
                    @endif
            <p style="text-align: left">{{ $message->created_at  }}</p>
        </div>
    @endif
    @empty
    <p class="text-gray-500">No messages yet.</p>
    @endforelse
</div>

        <div class="message_send_field">
        <form action="{{ route('chat.send', $conversation->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="message_send_field d-flex align-items-center p-2 border-top" style="background: #fff; border-radius: 8px; position: relative;">
    {{-- Emoji Button --}}
    <button type="button" id="emoji-btn" class="btn btn-light me-2" style="border-radius: 50%; font-size: 20px;">
        😊
    </button>

    {{-- Message Input --}}
    <div class="flex-grow-1 position-relative">
        <input type="text"
               name="body"
               id="message-input"
               class="form-control"
               placeholder="Write your message..."
               required
               style="border-radius: 20px; padding-left: 12px; padding-right: 40px;">

        {{-- Attachment --}}
        <label for="attachment"
               class="position-absolute end-0 top-50 translate-middle-y me-3"
               style="cursor: pointer;">
            <i class="fa fa-paperclip"></i>
        </label>
        <input type="file"
               id="attachment"
               name="attachment"
               class="d-none"
               accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
    </div>

    {{-- Send Button --}}
    <button class="btn btn-primary ms-2" type="submit" style="border-radius: 20px;">Send</button>
</div>

</form>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.2/dist/index.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const button = document.querySelector('#emoji-btn');
    const input = document.querySelector('#message-input');

    if (!button || !input) {
        console.error("❌ Emoji button or message input not found.");
        return;
    }

    // ✅ Use window.EmojiButton (fixes undefined issue in some builds)
    const picker = new window.EmojiButton({
        position: 'top-end',
        theme: 'light',
        autoHide: false,
        showSearch: false,
    });

    // When emoji is selected
    picker.on('emoji', emoji => {
        input.value += emoji;
        input.focus();
    });

    // Toggle the picker
    button.addEventListener('click', (e) => {
        e.preventDefault();
        picker.togglePicker(button);
    });
});
</script>



@endsection
