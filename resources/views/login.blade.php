@extends('layouts.master')
@section('title', 'Login')
@section('scripts')
@parent
<link href="/css/login.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

@if (isset($error_msg))
    <div class="error">{{$error_msg}}</div>
@endif
    <h2>Login</h1>
    <form method="post">
        <div class="formitem"><label><span>Email</span><input name="email" type="email" class="right"></label></div>
        <div class="formitem"><label><span>Password</span><input name="password" type="password" class="right"></label></div>
        <div class="formitem"><input type="submit" value="Submit"></div>
    </form>
@endsection