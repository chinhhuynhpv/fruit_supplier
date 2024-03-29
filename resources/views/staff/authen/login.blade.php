@extends('master')

@section('body_class', 'admin-page')

@section('header')
    <div class="header-logo-box">
        <img src="/image/logo_black.png" class="header-logo" alt="{{__('STR WAC Service')}}" />
    <div>
@stop

@section('content')
    <main>
@include('alert.error')
@include('alert.success')

    <div class="formLogin mt-5">
        <h2>{{__("Login")}}</h2>
            <form method="post" action="{{route('staff.handleLogin')}}">
                @csrf
                <div class="form-group">
                    <label for="email">{{__("Email")}}</label>
                    <input type="email" name="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="password">{{__("Password")}}</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-login">{{__("Login")}}</button>
            </form>
        </div>
    </main>
@stop
