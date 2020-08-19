@extends('auth.app')


@section('content')
<div class="flex-center position-ref full-height">
    <div class="code">
        403            
    </div>
    <div class="message" style="padding: 10px;">
        {{ $exception->getMessage() }} 
        <br />
        <a class='small float-left'  href='#' onclick='history.back()'>Return to previous page</a>
    </div>
</div>
@endsection

@section('styles')
<style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 100;
        height: 80vh;
        margin: 0;
    }

    .full-height {
        height: 80vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .code {
        border-right: 2px solid;
        font-size: 26px;
        padding: 0 15px 0 15px;
        text-align: center;
    }

    .message {
        font-size: 18px;
        text-align: center;
    }
</style>
@endsection