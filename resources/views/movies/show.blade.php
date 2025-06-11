@extends('layouts.app')

@section('content')
    <style>
        .movie-detail-wrapper {
            background-color: #121212;
            color: #fff;
            padding: 40px 20px;
            min-height: calc(100vh - 60px);
            padding-bottom: 120px;
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
            height: 380px;
            object-fit: cover;
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
            font-size: 0.95em;
            line-height: 1.6;
            margin-top: 15px;
        }

        .meta-row {
            display: flex;
            margin-bottom: 5px;
        }

        .meta-label {
            font-weight: bold;
            min-width: 120px;
            color: #aaa;
        }

        .meta-value {
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
            background-color: #777777;
            color: #fff;
        }

        .btn-buy:hover {
            background-color: #4b4b4b;
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
                    <div class="meta-row">
                        <span class="meta-label">Режиссёр:</span>
                        <span class="meta-value">{{ $movie->director ?? '-' }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Длительность:</span>
                        <span class="meta-value">{{ $movie->duration_minutes ?? '?' }} мин</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Дата выхода:</span>
                        <span
                            class="meta-value">{{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('d.m.Y') : '-' }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Жанр:</span>
                        <span class="meta-value">{{ $movie->genre ?? '?' }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Страна:</span>
                        <span class="meta-value">{{ $movie->country ?? '?' }}</span>
                    </div>
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
