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
<div class="white_box ">
    <h4 style="text-align: center">Open Conversation to Chat</h4>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
