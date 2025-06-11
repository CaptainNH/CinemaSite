@extends('layouts.app')

@section('content')
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f7f7;
            color: #222;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #121212;
            color: #fff;
            border-bottom: 1px solid #222;
        }

        .logo {
            font-size: 1.8em;
            font-weight: bold;
            color: #ffffff;
        }

        .auth-buttons a,
        .auth-buttons form button {
            background-color: #ffffff;
            color: #121212;
            padding: 8px 16px;
            margin-left: 10px;
            border: none;
            border-radius: 3px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .auth-buttons a:hover,
        .auth-buttons form button:hover {
            background-color: #dddddd;
        }

        .auth-buttons form {
            display: inline;
        }

        .poster-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 40px 20px;
            margin-top: 70px;
            background-color: #121212;
            color: #fff;
            text-align: center;
        }

        .poster-title {
            font-size: 2.2em;
            margin: 0 0 20px 0;
        }

        .date-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #1e1e1e;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .date-selector label {
            font-weight: 500;
            font-size: 1.1em;
            color: #fff;
        }

        .date-selector input[type="date"] {
            padding: 10px 14px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
        }

        .poster-section {
            min-height: 100vh;
            padding: 0 40px 120px;
            background-color: #121212;
        }

        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .poster-card {
            background: #1e1e1e;
            border-radius: 4px;
            padding: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
            text-align: center;
            transition: transform 0.3s ease;
            color: #fff;
        }

        .poster-card:hover {
            transform: translateY(-5px);
        }

        .movie-poster,
        .poster-placeholder {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 12px;
        }

        .poster-placeholder {
            background-color: #2c2c2c;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 0.95em;
        }

        .poster-card h3 {
            font-size: 1.15em;
            margin-bottom: 12px;
            color: #fff;
        }

        .session-row {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
            font-size: 0.95em;
            align-items: center;
        }

        .btn-buy {
            background-color: #ffffff;
            color: #121212;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.9em;
            cursor: pointer;
        }

        .btn-buy:hover {
            background-color: #e0e0e0;
        }

        .btn[disabled] {
            background-color: #777;
            color: #ccc;
            cursor: default;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .no-sessions-msg {
            text-align: center;
            font-size: 1.3em;
            margin-top: 60px;
            color: #888;
            grid-column: 1 / -1;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #121212;
            color: #aaa;
            text-align: center;
            padding: 20px;
            font-size: 0.9em;
            border-top: 1px solid #222;
            z-index: 1000;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .auth-buttons {
                margin-top: 10px;
            }

            .poster-header {
                padding: 20px;
            }

            .poster-section {
                padding: 0 20px 120px;
            }

            .date-selector {
                flex-direction: column;
                gap: 8px;
                padding: 12px;
            }
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-image {
            height: 40px;
            width: auto;
        }

        .brand-info {
            display: flex;
            flex-direction: column;
        }

        .brand-name {
            font-size: 1.8em;
            font-weight: bold;
            color: #ffffff;
            line-height: 1;
        }

        .brand-address {
            font-size: 0.9em;
            color: #aaa;
            margin-top: 4px;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .logo-container {
                gap: 10px;
            }

            .logo-image {
                height: 30px;
            }

            .brand-name {
                font-size: 1.5em;
            }

            .brand-address {
                font-size: 0.8em;
                display: none;
                /* Скрываем адрес на мобильных */
            }
        }
    </style>

    <div class="header">
        {{-- <div class="logo">Смотрим кино</div> --}}
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Логотип" class="logo-image">
            <div class="brand-info">
                <div class="brand-name">Смотрим кино</div>
                <div class="brand-address">Владикавказ, Проспект Доватора, 15Б</div>
            </div>
        </div>
        <div class="auth-buttons">
            @auth
                <a href="{{ route('cabinet') }}">Личный кабинет</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Выйти</button>
                </form>
            @else
                <a href="{{ route('register') }}">Зарегистрироваться</a>
                <a href="{{ route('login') }}">Войти</a>
            @endauth
        </div>
    </div>

    <div class="poster-header">
        <h1 class="poster-title">Афиша</h1>
        <div class="date-selector">
            <form method="GET">
                <label for="date-picker">Дата:</label>
                <input type="date" id="date-picker" name="date" value="{{ $date }}" min="{{ date('Y-m-d') }}"
                    onchange="this.form.submit()">
            </form>
        </div>
    </div>

    <section class="poster-section">
        <div class="movies-grid">
            @forelse ($groupedSessions as $movieId => $sessions)
                @php $movie = $sessions[0]->movie; @endphp
                <div class="poster-card">
                    <a href="{{ route('movies.show', $movie->id) }}">
                        @if ($movie->image)
                            <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}"
                                class="movie-poster">
                        @else
                            <div class="poster-placeholder">Нет изображения</div>
                        @endif
                    </a>
                    <h3>{{ $movie->title }}</h3>
                    @foreach ($sessions as $session)
                        <div class="session-row">
                            <span>{{ date('H:i', strtotime($session->session_datetime)) }} —
                                {{ number_format($session->price, 0, '', ' ') }}₽</span>
                            @auth
                                @if (Auth::user()->isUser())
                                    @php
                                        $hasTicket = Auth::user()->tickets->contains('session_id', $session->id);
                                    @endphp
                                    @if (!$hasTicket)
                                        <form method="POST" action="{{ route('buy', $session->id) }}">
                                            @csrf
                                            <button class="btn-buy">Купить</button>
                                        </form>
                                    @else
                                        <button class="btn" disabled>Куплен</button>
                                    @endif
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="no-sessions-msg">На выбранную дату сеансов не найдено. Пожалуйста, выберите другую дату.</div>
            @endforelse
        </div>
    </section>

    <div class="footer">
        &copy; {{ date('Y') }} Смотрим кино. Все права защищены.
    </div>
@endsection
