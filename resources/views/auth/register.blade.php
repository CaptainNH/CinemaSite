@extends('layouts.app')
@section('content')
    <h2>Регистрация</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="name" placeholder="Ваше имя" value="{{ old('name') }}" required>
        <input type="email" name="email" placeholder="Email (необязательно)" value="{{ old('email') }}">
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="password" name="password_confirmation" placeholder="Повторите пароль" required>
        <input type="text" name="admin_code" placeholder="Код администратора (если есть)" value="{{ old('admin_code') }}">
        <button type="submit">Зарегистрироваться</button>
        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
    </form>
@endsection
