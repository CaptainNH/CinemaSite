@extends('layouts.app')
@section('content')
    <h2>Вход</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="text" name="login" placeholder="E-mail или Логин" value="{{ old('login') }}" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
    </form>
@endsection
