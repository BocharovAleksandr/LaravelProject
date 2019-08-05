@extends('layouts.main')

@section('content_head')
    <ul class="nav">
        <li><a href="{{ route('login') }}">Авторизация</a></li>
        <li class="active"><a href="#">Регистрация</a></li>
    </ul>
@endsection

@section('content')
<div class="row-fluid">
    <div class="span4"></div>
    <div class="span8">

        <form method="POST" action="{{ route('register') }}" class="form-horizontal">
            @csrf

            <div class="control-group">
                <b>Регистрация</b>
            </div>

            <div class="control-group">
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Имя" autocomplete="name" required autofocus>
                @error('name')
                    <span class="help-inline">{{ $message }}</span>
                @enderror
            </div>

            <div class="control-group">
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="E-Mail" autocomplete="email" required>
                @error('email')
                    <span class="help-inline">{{ $message }}</span>
                @enderror
            </div>

            <div class="control-group">
                <input id="password" type="password" name="password" placeholder="Пароль" autocomplete="new-password" required>
                @error('password')
                    <span class="help-inline">{{ $message }}</span>
                @enderror
            </div>

            <div class="control-group">
                <input id="password-confirm" type="password" name="password_confirmation"
                       placeholder="Повторите пароль" autocomplete="new-password" required>
                @error('password_confirmation')
                    <span class="help-inline">{{ $message }}</span>
                @enderror
            </div>

            <div class="control-group">
                <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
        </form>
    </div>
</div>
@endsection
