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
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .logo {
            font-size: 1.8em;
            font-weight: bold;
            color: #b10d0d;
        }

        .auth-buttons a,
        .auth-buttons form button {
            background-color: #b10d0d;
            color: #fff;
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
            background-color: #900a0a;
        }

        .auth-buttons form {
            display: inline;
        }

        .date-panel {
            background-color: #fff;
            color: #222;
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .date-panel label {
            font-weight: 500;
            font-size: 1.1em;
        }

        .date-panel input[type="date"] {
            margin-left: 10px;
            padding: 10px 14px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .poster-section {
            padding: 40px 40px;
            background-color: #f7f7f7;
        }

        .poster-title {
            text-align: center;
            font-size: 2.2em;
            color: #222;
            margin-bottom: 40px;
        }

        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 30px;
        }

        .poster-card {
            background: #fff;
            border-radius: 4px;
            padding: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
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
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888;
            font-size: 0.95em;
        }

        .poster-card h3 {
            font-size: 1.15em;
            margin-bottom: 12px;
            color: #222;
        }

        .session-row {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
            font-size: 0.95em;
            align-items: center;
        }

        .btn-buy,
        .btn[disabled] {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.9em;
            cursor: pointer;
        }

        .btn-buy {
            background-color: #b10d0d;
            color: #fff;
        }

        .btn[disabled] {
            background-color: #ccc;
            color: #555;
            cursor: default;
        }

        .no-sessions-msg {
            text-align: center;
            font-size: 1.3em;
            margin-top: 60px;
            color: #888;
        }

        @media (max-width: 768px) {
            .poster-section {
                padding: 30px 20px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .auth-buttons {
                margin-top: 10px;
            }
        }
    </style>

    <div class="header">
        <div class="logo">Смотрим кино</div>
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

    <div class="date-panel">
        <form method="GET">
            <label>
                Выберите дату:
                <input type="date" name="date" value="{{ $date }}" min="{{ date('Y-m-d') }}"
                    onchange="this.form.submit()">
            </label>
        </form>
    </div>

    <section class="poster-section">
        <div class="poster-title">Афиша</div>
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
@endsection
