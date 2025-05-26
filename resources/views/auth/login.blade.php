@extends('layouts.app')

@section('content')
    <style>
        .login-wrapper {
            min-height: calc(100vh - 60px);
            /* вычитаем высоту хедера */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            background-color: #121212;
        }

        .login-box {
            background-color: #1e1e1e;
            padding: 32px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .login-box h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 24px;
        }

        .login-box form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .login-box input {
            padding: 12px;
            border: none;
            border-radius: 6px;
            background-color: #2a2a2a;
            color: #fff;
        }

        .login-box input::placeholder {
            color: #bbb;
        }

        .login-box button {
            padding: 12px;
            border: none;
            border-radius: 6px;
            background-color: #ffffff;
            color: #000000;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-box button:hover {
            background-color: #545454;
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

    <div class="login-wrapper">
        <div class="login-box">
            <h2>Вход</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="text" name="login" placeholder="E-mail или Логин" value="{{ old('login') }}" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit">Войти</button>

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
