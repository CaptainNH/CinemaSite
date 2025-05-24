@extends('layouts.app')

@section('content')
    <style>
        .register-wrapper {
            min-height: calc(100vh - 60px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            background-color: #121212;
        }

        .register-box {
            background-color: #1e1e1e;
            padding: 32px;
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .register-box h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 24px;
        }

        .register-box form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .register-box input {
            padding: 12px;
            border: none;
            border-radius: 6px;
            background-color: #2a2a2a;
            color: #fff;
        }

        .register-box input::placeholder {
            color: #bbb;
        }

        .register-box button {
            padding: 12px;
            border: none;
            border-radius: 6px;
            background-color: #b10d0d;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .register-box button:hover {
            background-color: #900a0a;
        }

        .error-messages {
            margin-top: 10px;
            background-color: #3a0000;
            color: #ffbbbb;
            padding: 10px;
            border-radius: 6px;
            font-size: 0.9em;
        }

        .footer {
            background-color: #121212;
            color: #aaa;
            text-align: center;
            padding: 20px;
            font-size: 0.9em;
            border-top: 1px solid #222;
        }
    </style>

    <div class="register-wrapper">
        <div class="register-box">
            <h2>Регистрация</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" name="name" placeholder="Ваше имя" value="{{ old('name') }}" required>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                <input type="password" name="password" placeholder="Пароль" required>
                <input type="password" name="password_confirmation" placeholder="Повторите пароль" required>
                <input type="text" name="admin_code" placeholder="Код администратора (если есть)"
                    value="{{ old('admin_code') }}">
                <button type="submit">Зарегистрироваться</button>

                @if ($errors->any())
                    <div class="error-messages">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Смотрим кино. Все права защищены.
    </div>
@endsection
