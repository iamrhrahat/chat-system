@extends('layout')
@section('content')
<div class="white_card card_height_100 mb_30 ">
<div class="white_card_header">
<div class="box_header m-0">
<div class="main-title">
<h3 class="m-0">Community</h3>
</div>
<div class="header_more_tool">
<div class="dropdown">


</div>
</div>
</div>
</div>
<div class="white_card_body QA_section">
<div class="QA_table ">

<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><table class="table lms_table_active2 p-0 dataTable no-footer dtr-inline" id="DataTables_Table_0" role="grid" style="width: 722px;">
<thead>
<tr role="row">
    <th scope="col" class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 175px;" aria-sort="ascending" aria-label="Customer: activate to sort column descending">Users</th>
    <th style="text-align: right" scope="col" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 137px;" aria-label="Status: activate to sort column ascending">Intro</th>
        <th style="text-align: right" scope="col" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 137px;" aria-label="Status: activate to sort column ascending">Gender</th>
    <th style="text-align: right" scope="col" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 137px;" aria-label="Status: activate to sort column ascending">Message</th>
</tr>
</thead>
@php
    $users = \App\Models\User::all();
@endphp

@foreach ($users as $user)
<tr role="row" class="odd">
    <td tabindex="0" class="sorting_1">
        <div class="customer d-flex align-items-center">
            <div class="thumb_34 mr_15 mt-0">
                <img class="img-fluid radius_50" src="{{ asset('asset/dashboard/img/customers/1.png') }}" alt="">
            </div>
            <span class="f_s_14 f_w_400 color_text_1">{{ $user->name }}</span>
        </div>
    </td>
    <td class="f_s_14 f_w_400 text-end">Intro</td>
    <td class="f_s_14 f_w_400 text-end">Male</td>
    <td class="f_s_14 f_w_400 text-end">
    @if(auth()->id() == $user->id)
        <button class="badge_btn_3" disabled style="cursor: not-allowed; opacity: 0.6;">Message</button>
    @else
        <a href="{{ route('dashboard.chats', $user->id) }}" class="badge_btn_3">Message</a>
    @endif
</td>

</tr>
@endforeach


</tbody>
</table></div>
</div>
</div>
</div>
@endsection
