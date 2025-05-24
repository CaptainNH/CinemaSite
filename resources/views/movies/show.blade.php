@extends('layouts.app')

@section('content')
    <div style="max-width:900px;margin:2rem auto;">
        <div style="display:flex;gap:2rem;flex-wrap:wrap;">
            @if ($movie->poster_path)
                <img src="{{ asset('storage/' . $movie->poster_path) }}" alt="{{ $movie->title }}"
                    style="width:260px;height:auto;border-radius:13px;box-shadow:0 4px 18px #a2c8fa88;">
            @endif
            <div style="flex:1;min-width:280px;">
                <h1>{{ $movie->title }}</h1>
                @if ($movie->description)
                    <div style="font-size:1.12em;color:#433;">{{ $movie->description }}</div>
                @endif
                <div style="font-size:1em;color:#555;margin:1em 0;">
                    <b>Режиссёр:</b> {{ $movie->director ?? '-' }}, <b>Длительность:</b>
                    {{ $movie->duration_minutes ?? '?' }} мин
                </div>
            </div>
        </div>

        <h3 style="margin:2.5rem 0 1rem;">Ближайшие сеансы</h3>
        @if ($sessions->count())
            <div style="border-radius:11px;background:#f8fafc;box-shadow:0 2px 10px #e1ecfa54;padding:1.4rem;">
                @foreach ($sessions as $session)
                    <div
                        style="display:flex;justify-content:space-between;align-items:center;padding:1em 0;border-bottom:1px solid #e6e8ee;">
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
                                    <form method="POST" action="{{ route('buy', $session->id) }}" style="display:inline;">
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
            </div>
        @else
            <div style="background:#fffbe6;padding:2em;border-radius:11px;text-align:center;">Нет сеансов для этого фильма
            </div>
        @endif
    </div>
@endsection
