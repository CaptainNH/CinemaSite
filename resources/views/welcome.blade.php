@extends('layouts.app')
@section('content')
    <style>
        :root {
            --primary-color: #174ea6;
            --secondary-color: #59cfff;
            --success-color: #36e295;
            --error-color: #fd7878;
            --text-dark: #153c72;
            --text-light: #555;
            --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        body,
        html {
            background: var(--bg-gradient);
            min-height: 100vh;
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.5;
        }

        /* HEADER STYLES - full width */
        .main-header {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #fff;
            padding: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            min-height: 80px;
            margin-bottom: 2.5rem;
            width: 100%;
        }

        .main-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            height: 80px;
            max-width: 1600px;
            margin: 0 auto;
        }

        .cinema-brand {
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .header-btn {
            padding: 0.6em 1.4em;
            font-weight: 600;
            font-size: 1em;
            border-radius: 8px;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(22, 89, 213, 0.15);
            background: #fff;
            color: var(--primary-color);
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .header-btn.primary {
            background: linear-gradient(90deg, #3ae0ff 0%, #025abe 100%);
            color: #fff;
        }

        .header-btn.cabinet {
            background: linear-gradient(90deg, var(--success-color) 0%, #0b8346 100%);
            color: #fff;
        }

        .header-btn.logout {
            background: linear-gradient(90deg, var(--error-color) 0%, #a50605 100%);
            color: #fff;
        }

        .header-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(8, 80, 174, 0.2);
        }

        .header-btn.primary:hover {
            background: linear-gradient(90deg, #58fffa 0%, #1c60e2 100%);
        }

        .header-btn.cabinet:hover {
            background: linear-gradient(90deg, #74ffc7 0%, #24b45c 100%);
        }

        .header-btn.logout:hover {
            background: linear-gradient(90deg, #ffabab 0%, #f50404 100%);
        }

        /* DATE PICKER - centered */
        .datebar-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 3rem;
        }

        .datebar {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1em;
            background: linear-gradient(90deg, #fffbe8 20%, #e7f6ff 100%);
            border-radius: 12px;
            padding: 1.2em 2.2em;
            box-shadow: 0 2px 12px rgba(137, 205, 252, 0.15);
        }

        .datebar label {
            font-size: 1.15em;
            font-weight: 500;
            color: #3d4450;
            white-space: nowrap;
        }

        .datebar input[type="date"] {
            font-size: 1.1em;
            padding: 0.4em 1em;
            border-radius: 8px;
            border: 1.5px solid #89cdfc;
            background: #fff;
            color: var(--primary-color);
            cursor: pointer;
        }

        /* MESSAGES - centered */
        .messages-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .messages {
            max-width: 800px;
            width: 100%;
            padding: 0 20px;
        }

        .success,
        .error {
            color: #fff;
            border-radius: 8px;
            padding: 1.2em 1.5em;
            margin-bottom: 1rem;
            font-weight: 500;
            font-size: 1.1em;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .success {
            background: linear-gradient(90deg, var(--success-color) 0%, #0b8346 100%);
        }

        .error {
            background: linear-gradient(90deg, var(--error-color) 10%, #b51e03 100%);
        }

        /* MOVIES SECTION - full width */
        .movies-section {
            width: 100%;
            padding: 0 20px 40px;
            box-sizing: border-box;
        }

        .movies-grid {
            display: grid;
            gap: 2.5rem;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            max-width: 1600px;
            margin: 0 auto;
            width: 100%;
        }

        .poster-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(5, 147, 241, 0.1);
            padding: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .poster-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(5, 147, 241, 0.15);
        }

        .movie-poster {
            width: 100%;
            height: 330px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 2px 12px #ccc;
            margin-bottom: 1rem;
        }

        .poster-placeholder {
            height: 330px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eee;
            border-radius: 10px;
            margin-bottom: 1rem;
            color: #666;
            font-weight: 500;
        }

        .poster-card h3 {
            margin: 0 0 1rem 0;
            color: var(--text-dark);
            font-weight: 700;
            font-size: 1.4em;
        }

        .movie-description {
            font-size: 1em;
            color: var(--text-light);
            margin-bottom: 0.8em;
            flex-grow: 1;
        }

        .movie-meta {
            font-size: 0.95em;
            color: #188ac1;
            margin-bottom: 1em;
            font-weight: 500;
        }

        .sessions-list {
            width: 100%;
            margin-top: auto;
        }

        .session-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7em 0;
            border-bottom: 1px solid #e7f2fa;
        }

        .session-row:last-child {
            border-bottom: none;
        }

        .session-info {
            font-size: 1.1em;
            color: var(--text-dark);
            font-weight: 500;
        }

        /* BUTTONS */
        .btn {
            padding: 0.5em 1.2em;
            border-radius: 8px;
            font-weight: 500;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 0.95em;
            transition: all 0.2s ease;
        }

        .btn-buy {
            background: linear-gradient(90deg, var(--success-color) 0%, #0b8346 100%);
        }

        .btn-buy:hover {
            background: linear-gradient(90deg, #6befaa 0%, #37d085 100%);
            transform: translateY(-1px);
        }

        .btn[disabled],
        .btn:disabled {
            background: #e0e0e0;
            color: #999;
            cursor: not-allowed;
            transform: none;
        }

        /* NO SESSIONS MESSAGE */
        .no-sessions-msg {
            color: #4d545c;
            background: #fffbe6;
            border-radius: 12px;
            padding: 2em;
            text-align: center;
            box-shadow: 0 3px 10px rgba(190, 236, 255, 0.1);
            margin: 2em auto;
            font-size: 1.2em;
            font-weight: 500;
            grid-column: 1 / -1;
            max-width: 800px;
            width: 100%;
        }

        /* RESPONSIVE ADJUSTMENTS */
        @media (max-width: 1200px) {
            .movies-grid {
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .main-header-inner {
                padding: 0 20px;
            }

            .cinema-brand {
                font-size: 1.8rem;
            }

            .header-actions {
                gap: 0.8rem;
            }

            .datebar {
                flex-direction: column;
                padding: 1em;
                width: 90%;
            }

            .datebar label {
                margin-bottom: 0.5em;
            }
        }

        @media (max-width: 480px) {
            .main-header-inner {
                flex-direction: column;
                height: auto;
                padding: 15px;
            }

            .cinema-brand {
                margin-bottom: 15px;
            }

            .header-actions {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .header-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    {{-- HEADER --}}
    <header class="main-header">
        <div class="main-header-inner">
            <span class="cinema-brand">СМОТРИМ</span>
            <div class="header-actions">
                @auth
                    <a href="{{ route('cabinet') }}" class="header-btn cabinet">Личный кабинет</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button class="header-btn logout" type="submit">Выйти</button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="header-btn primary">Зарегистрироваться</a>
                    <a href="{{ route('login') }}" class="header-btn"
                        style="background:linear-gradient(90deg,#59cfff 10%,#3ae0ff 100%);color:#065da3;">Войти</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Уведомления --}}
    @if (session('success') || session('error'))
        <div class="messages-container">
            <div class="messages">
                @if (session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="error">{{ session('error') }}</div>
                @endif
            </div>
        </div>
    @endif

    {{-- Панель выбора даты --}}
    <div class="datebar-container">
        <form method="GET" class="datebar">
            <label>
                Выберите дату:
                <input type="date" name="date" value="{{ $date }}" min="{{ date('Y-m-d') }}"
                    onchange="this.form.submit()">
            </label>
        </form>
    </div>

    {{-- Секция фильмов --}}
    <section class="movies-section">
        <div class="movies-grid">
            @forelse ($groupedSessions as $movieId => $sessions)
                @php $movie = $sessions[0]->movie; @endphp
                <article class="poster-card">
                    <a href="{{ route('movies.show', $movie->id) }}" style="display:block;width:100%;">
                        @if ($movie->image)
                            <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}"
                                class="movie-poster">
                        @else
                            <div class="poster-placeholder">Нет изображения</div>
                        @endif
                    </a>
                    <h3>{{ $movie->title }}</h3>
                    <div class="sessions-list">
                        @foreach ($sessions as $session)
                            <div class="session-row">
                                <span class="session-info">
                                    {{ date('H:i', strtotime($session->session_datetime)) }} —
                                    {{ number_format($session->price, 0, '', ' ') }}₽
                                </span>
                                @auth
                                    @if (Auth::user()->isUser())
                                        @php
                                            $hasTicket = Auth::user()->tickets->contains('session_id', $session->id);
                                        @endphp
                                        @if (!$hasTicket)
                                            <form method="POST" action="{{ route('buy', $session->id) }}"
                                                style="display:inline;">
                                                @csrf
                                                <button class="btn btn-buy">Купить</button>
                                            </form>
                                        @else
                                            <button class="btn" disabled>Куплен</button>
                                        @endif
                                    @endif
                                @endauth
                            </div>
                        @endforeach
                    </div>
                </article>
            @empty
                <div class="no-sessions-msg">На выбранную дату сеансов не найдено. Пожалуйста, выберите другую дату.</div>
            @endforelse
        </div>
    </section>
@endsection
