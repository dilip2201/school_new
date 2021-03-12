@extends('admin.layouts.app')
@section('content')
@section('pageTitle', 'Unauthorized access')
<div class="row">
<div style="margin-top: 100px; width: 100%;" >
    <div class="content" style="text-align: center;">



        <div class="title" style="font-size: 72px; margin-bottom: 40px; color: #444; margin-left: 165px;">
            <i class="fa fa-ban" style="font-size:120px;color:#FF5959;margin-bottom:30px;"></i> Unauthorized access</div>
        <a href="{{ route('admin.dashboard') }}">Dashboard.</a> |
        <a href="javascript:history.back()">Go Back</a>


    </div>
</div>
</div>
@endsection
