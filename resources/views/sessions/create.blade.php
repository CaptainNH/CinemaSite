@extends('layouts.app') {{-- Используй ваш основной шаблон, например, app.blade.php --}}

@section('content')
    <div class="container">
        <h1>Создать новый сеанс</h1>

        @if (session('success'))
            <div style="color:green;">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sessions.store') }}">
            @csrf

            <div>
                <label for="movie_id">Фильм:</label>
                <select name="movie_id" id="movie_id" required>
                    <option value="">-- выберите фильм --</option>
                    @foreach ($movies as $movie)
                        <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="session_datetime">Дата и время:</label>
                <input type="datetime-local" name="session_datetime" id="session_datetime" required>
            </div>

            <div>
                <label for="price">Цена (руб):</label>
                <input type="number" name="price" id="price" value="300" min="0" required>
            </div>

            <button type="submit">Сохранить сеанс</button>
        </form>
    </div>
@endsection
