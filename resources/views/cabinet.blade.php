@extends('layouts.app')
@section('content')
    <style>
        .cabinet-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(90deg, #2463eb 0%, #10b2f8 100%);
            color: #fff;
            padding: 1.2rem 2.5vw 1.1rem 2vw;
            border-radius: 0 0 14px 14px;
            margin-bottom: 1.7rem;
        }

        .welcome {
            font-size: 1.35em;
            font-weight: 700;
        }

        .cabinet-actions {
            display: flex;
            gap: 1.2em;
        }

        .cabinet-actions form,
        .cabinet-actions a {
            display: inline;
        }

        .cabinet-btn {
            padding: .5em 1.3em;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            background: #fff;
            color: #2770d7;
            margin-left: 0.7em;
            transition: background 0.15s, color 0.15s;
            cursor: pointer;
            text-decoration: none;
        }

        .cabinet-btn:hover,
        .cabinet-btn:focus-visible {
            background: #1862ea;
            color: #fff;
        }

        .cabinet-btn.logout {
            color: #c90d0d;
        }

        .cabinet-btn.logout:hover {
            background: #f8b9b9;
            color: #a60707;
        }

        .cabinet-section {
            margin: 0 auto;
            max-width: 750px;
        }

        /* Список билетов */
        .ticket-list {
            margin-top: 1.5em;
        }

        .ticket-card {
            background: #f9fbff;
            border-radius: 10px;
            box-shadow: 0 2px 10px #10b2f831;
            padding: 1.2em 1.7em;
            margin-bottom: 1.15em;
            display: flex;
            flex-direction: column;
            gap: .5em;
        }

        .ticket-movie {
            font-size: 1.10em;
            font-weight: 500;
            color: #1a4b9a;
            margin-bottom: .2em;
        }

        .ticket-info {
            color: #0a4169;
        }

        .admin-panel {
            background: #fffbe7;
            border-radius: 10px;
            padding: 2.2em 2em;
            text-align: center;
            margin-top: 2.6em;
            box-shadow: 0 2px 10px #efbb0a15;
        }

        .admin-panel h2 {
            color: #b89e1c;
        }
    </style>
    <div class="cabinet-header">
        <div class="welcome">
            Добро пожаловать, {{ $user->name ?? ($user->email ?? 'пользователь') }}!
        </div>
        <div class="cabinet-actions">
            <a href="{{ route('main') }}" class="cabinet-btn">На главную</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="cabinet-btn logout" type="submit">Выйти</button>
            </form>
        </div>
    </div>
    <div class="cabinet-section">
        @if ($user->isUser())
            <h2>Ваши купленные билеты</h2>
            @if (count($tickets) === 0)
                <div style="margin:2em 0; color:#d45511; background:#ffe3cc; padding:1em 1.5em; border-radius: 8px;">
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
                                {{ number_format($ticket->session->price, 0, '', ' ') }}₽
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @elseif ($user->isAdmin())
            <div class="admin-panel">
                <h2>Панель администратора</h2>
                <a href="{{ route('admin.sessions.create') }}" class="cabinet-btn"
                    style="background: #ffe36c; color: #5b4331;">
                    Создать сеанс
                </a>
                <a href="{{ route('admin.movies.create') }}" class="cabinet-btn"
                    style="background: #b0eaf1; color: #1b3840; margin-left:1.1em;">
                    Добавить фильм
                </a>

                {{-- Спиcок фильмов с кнопками для перехода на редактирование --}}
                <div style="margin-top: 2em;">
                    <h4>Фильмы:</h4>
                    @if (isset($movies) && count($movies))
                        <ul style="list-style:none; padding:0;">
                            @foreach ($movies as $movie)
                                <li style="margin-bottom: 0.7em;">
                                    <span style="font-weight:500;">{{ $movie->title }}</span>
                                    <a href="{{ url('admin/movies/' . $movie->id . '/edit') }}" class="cabinet-btn"
                                        style="margin-left:1.5em;">
                                        Редактировать
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div style="color: #a86a10; margin-top:1em;">Фильмы не найдены.</div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
