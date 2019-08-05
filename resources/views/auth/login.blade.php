@extends('layouts.main')

@section('content_head')
    <ul class="nav">
        <li class="active"><a href="#">Авторизация</a></li>
        <li><a href="{{ route('register') }}">Регистрация</a></li>
    </ul>
@endsection

@section('content')
<div class="row-fluid">
    <div class="span4"></div>
    <div class="span3">

        <form method="POST" action="{{ route('login') }}" class="form-horizontal">
            @csrf

            <div class="control-group">
                <b>Авторизация</b>
            </div>

            <div class="control-group">
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="E-Mail" required autocomplete="email" autofocus>
                @error('email')
                    <span class="help-inline">{{ $message }}</span>
                @enderror
            </div>

            <div class="control-group">
                <input id="password" type="password" name="password" placeholder="Пароль" required autocomplete="current-password">
                @error('password')
                    <span class="help-inline">{{ $message }}</span>
                @enderror
            </div>

            <div class="control-group">
                <label class="checkbox">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}> Запомнить меня
                </label>

                <button type="submit" class="btn btn-primary">Вход</button>
            </div>
        </form>
    </div>
</div>

@endsection
