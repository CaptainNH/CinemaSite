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

        /* .header {
                                            display: flex;
                                            justify-content: space-between;
                                            align-items: center;
                                            padding: 20px 40px;
                                            background-color: #121212;
                                            color: #fff;
                                            border-bottom: 1px solid #222;
                                        } */

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

        .date-panel {
            background-color: #fafafa;
            color: #222;
            padding: 30px 20px;
            text-align: center;
            margin-top: 80px;
            border-bottom: 1px solid #ccc;
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
            min-height: 100vh;
            padding: 40px 40px;
            padding-bottom: 120px;
            background-color: #121212;
        }

        .poster-title {
            text-align: center;
            font-size: 2.2em;
            color: #fff;
            margin-bottom: 40px;
        }

        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 30px;
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

    <div class="footer">
        &copy; {{ date('Y') }} Смотрим кино. Все права защищены.
    </div>
@endsection
