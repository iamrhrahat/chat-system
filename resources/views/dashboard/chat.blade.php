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
<p><a href="index-2.html">Dashboard</a> <i class="fas fa-caret-right"></i> Chat</p>
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
<ul>

<li>
    <a href="#">
        <div class="message_pre_left">
            <div class="message_preview_thumb">
                <img src="{{ asset('asset/dashboard/img/messages/1.png')}}" alt>
            </div>
            <div class="messges_info">
                <h4>{{ $otherUser->name }}</h4>

                @if($conversation->lastMessage)
                    <p class="text-gray-600 text-sm truncate w-60">
                        {{ $conversation->lastMessage->body }}
                    </p>
                @else
                    <p class="text-gray-400 text-sm italic">No messages yet</p>
                @endif
</div>

</div>

<div class="messge_time">
      @if($conversation->lastMessage)
                 <span></span>   {{ $conversation->lastMessage->created_at }} </span>
                @endif

</div>

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
                <p style="text-align: right">{{ $message->created_at  }}</p>
            </div>
            @else
            <div class="single_message_chat">


            <div style="padding: 8px 12px;
                            border-radius: 10px;
                            word-wrap: break-word;" class="message_content_view">
                <p>{{ $message->body }}</p>
            </div>
            <p style="text-align: right">{{ $message->created_at  }}</p>
        </div>
    @endif
    @empty
    <p class="text-gray-500">No messages yet.</p>
    @endforelse
</div>

        <div class="message_send_field">
        <input type="text" placeholder="Write your message" value>
        <button class="btn_1" type="submit">Send</button>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
