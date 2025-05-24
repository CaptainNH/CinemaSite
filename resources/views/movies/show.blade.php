@extends('layouts.app')

@section('content')
    <style>
        .movie-detail-wrapper {
            background-color: #121212;
            color: #fff;
            padding: 40px 20px;
            min-height: calc(100vh - 60px);
        }

        .movie-content {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .movie-poster {
            width: 260px;
            border-radius: 13px;
            box-shadow: 0 4px 18px rgba(162, 200, 250, 0.5);
        }

        .movie-info {
            flex: 1;
            min-width: 280px;
        }

        .movie-title {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .movie-description {
            font-size: 1.1rem;
            color: #ccc;
            margin-bottom: 1rem;
        }

        .movie-meta {
            font-size: 1rem;
            color: #aaa;
        }

        .sessions-section {
            margin-top: 3rem;
        }

        .sessions-section h3 {
            margin-bottom: 1.5rem;
        }

        .session-card {
            background-color: #1e1e1e;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(225, 236, 250, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-buy {
            background-color: #b10d0d;
            color: #fff;
        }

        .btn-buy:hover {
            background-color: #900a0a;
        }

        .btn[disabled] {
            background-color: #555;
            cursor: default;
        }

        .no-sessions {
            background-color: #2a2a2a;
            padding: 2rem;
            border-radius: 11px;
            text-align: center;
            color: #ccc;
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

    <div class="movie-detail-wrapper">
        <div class="movie-content">
            @if ($movie->image)
                <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}" class="movie-poster">
            @endif
            <div class="movie-info">
                <div class="movie-title">{{ $movie->title }}</div>
                @if ($movie->description)
                    <div class="movie-description">{{ $movie->description }}</div>
                @endif
                <div class="movie-meta">
                    <b>Режиссёр:</b> {{ $movie->director ?? '-' }}<br>
                    <b>Длительность:</b> {{ $movie->duration_minutes ?? '?' }} мин
                </div>
            </div>
        </div>

        <div class="sessions-section">
            <h3>Ближайшие сеансы</h3>
            @php
                $futureSessions = $sessions->filter(
                    fn($session) => \Carbon\Carbon::parse($session->session_datetime)->isFuture(),
                );
            @endphp

            @if ($futureSessions->count())
                @foreach ($futureSessions as $session)
                    <div class="session-card">
                        <span>
                            {{ \Carbon\Carbon::parse($session->session_datetime)->format('d.m.Y H:i') }}
                            — <b>{{ number_format($session->price, 0, '', ' ') }} ₽</b>
                        </span>
                        @auth
                            @if (Auth::user()->isUser())
                                @php
                                    $hasTicket = Auth::user()->tickets->where('session_id', $session->id)->count() > 0;
                                @endphp
                                @if (!$hasTicket)
                                    <form method="POST" action="{{ route('buy', $session->id) }}">
                                        @csrf
                                        <button class="btn btn-buy">Купить</button>
                                    </form>
                                @else
                                    <button class="btn" disabled>Куплен</button>
                                @endif
                            @endif
                        @else
                            <a class="btn btn-buy" href="{{ route('login') }}">Войти для покупки</a>
                        @endauth
                    </div>
                @endforeach
            @else
                <div class="no-sessions">Нет сеансов для этого фильма</div>
            @endif
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Смотрим кино. Все права защищены.
        </div>
    @endsection
