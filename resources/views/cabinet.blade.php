@extends('layouts.app')

@section('content')
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f7f7;
            color: #222;
            min-height: 100vh;
        }

        .cabinet-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #121212;
            color: #fff;
            padding: 20px 40px;
            border-bottom: 1px solid #222;
            border-radius: 0 0 8px 8px;
            margin-bottom: 2rem;
        }

        .welcome {
            font-size: 1.5em;
            font-weight: 700;
        }

        .cabinet-actions {
            display: flex;
            gap: 12px;
        }

        .cabinet-actions a,
        .cabinet-actions form button {
            background-color: #ffffff;
            color: #121212;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            user-select: none;
        }

        .cabinet-actions a:hover,
        .cabinet-actions form button:hover {
            background-color: #dddddd;
        }

        .cabinet-actions form {
            display: inline;
        }

        .cabinet-actions form button.logout {
            background-color: #c90d0d;
            color: #fff;
            font-weight: 700;
        }

        .cabinet-actions form button.logout:hover {
            background-color: #a60707;
        }

        .cabinet-section {
            max-width: 750px;
            margin: 0 auto 3rem;
            padding: 0 20px;
        }

        h2 {
            color: #121212;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        /* Список билетов */
        .ticket-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ticket-card {
            background: #1e1e1e;
            color: #fff;
            border-radius: 6px;
            padding: 16px 20px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
        }

        .ticket-movie {
            font-size: 1.2em;
            font-weight: 600;
            color: #f0f0f0;
            margin-bottom: 6px;
        }

        .ticket-info {
            font-size: 0.95em;
            color: #ccc;
            line-height: 1.4;
        }

        .no-tickets-msg {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px 20px;
            border-radius: 6px;
            border: 1px solid #ffeeba;
            font-weight: 600;
        }

        /* Панель администратора */
        .admin-panel {
            background-color: #fafafa;
            border-radius: 8px;
            padding: 24px 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            color: #121212;
        }

        .admin-panel h2 {
            margin-bottom: 1.5rem;
            font-weight: 700;
            color: #121212;
        }

        .admin-panel .cabinet-btn {
            background-color: #121212;
            color: #fff;
            margin-right: 1rem;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .admin-panel .cabinet-btn:hover {
            background-color: #2770d7;
        }

        .admin-panel ul {
            list-style: none;
            padding: 0;
            margin-top: 1.5rem;
        }

        .admin-panel ul li {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
        }

        .admin-panel ul li a {
            background-color: #2770d7;
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .admin-panel ul li a:hover {
            background-color: #1862ea;
        }

        .admin-panel .no-movies-msg {
            margin-top: 1rem;
            color: #666;
            font-style: italic;
        }

        /* Мобильная адаптация */
        @media (max-width: 768px) {
            .cabinet-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 15px 20px;
            }

            .cabinet-actions {
                justify-content: flex-start;
                gap: 8px;
                flex-wrap: wrap;
            }

            .cabinet-section {
                padding: 0 10px;
            }

            .admin-panel .cabinet-btn {
                margin-bottom: 10px;
                margin-right: 0;
                width: 100%;
                text-align: center;
            }

            .admin-panel ul li {
                flex-direction: column;
                align-items: flex-start;
            }

            .admin-panel ul li a {
                margin-top: 6px;
                width: auto;
            }
        }
    </style>

    <div class="cabinet-header">
        <div class="welcome">
            Добро пожаловать, {{ $user->name ?? ($user->email ?? 'пользователь') }}!
        </div>
        <div class="cabinet-actions">
            <a href="{{ route('main') }}">На главную</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">Выйти</button>
            </form>
        </div>
    </div>

    <div class="cabinet-section">
        @if ($user->isUser())
            <h2>Ваши купленные билеты</h2>
            @if (count($tickets) === 0)
                <div class="no-tickets-msg">
                    У вас пока нет купленных билетов.
                </div>
            @else
                <div class="ticket-list">
                    @foreach ($tickets as $ticket)
                        <div class="ticket-card">
                            <div class="ticket-movie">
                                {{ optional($ticket->session)->movie->title ?? 'Сеанс не найден' }}
                            </div>
                            <div class="ticket-info">
                                @if ($ticket->session)
                                    Сеанс: {{ date('d.m.Y H:i', strtotime($ticket->session->session_datetime)) }}<br>
                                @else
                                    <span style="color:#c91a1a;">Сеанс удалён или не найден</span><br>
                                @endif
                                Место: {{ $ticket->seat ?? '—' }}, Цена:
                                {{ number_format(optional($ticket->session)->price ?? 0, 0, '', ' ') }}₽
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @elseif ($user->isAdmin())
            <div class="admin-panel">
                <h2>Панель администратора</h2>
                <a href="{{ route('admin.sessions.create') }}" class="cabinet-btn">Создать сеанс</a>
                <a href="{{ route('admin.movies.create') }}" class="cabinet-btn">Добавить фильм</a>

                <div>
                    <h3 style="margin-top: 2rem; font-weight: 700;">Фильмы:</h3>
                    @if (isset($movies) && count($movies))
                        <ul>
                            @foreach ($movies as $movie)
                                <li>
                                    <span>{{ $movie->title }}</span>
                                    <a href="{{ url('admin/movies/' . $movie->id . '/edit') }}"
                                        class="cabinet-btn">Редактировать</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="no-movies-msg">Фильмы не найдены.</div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
