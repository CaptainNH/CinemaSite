@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Создание сеанса</h1>

    @if (session('success'))
        <div class="alert alert-success" style="padding:.7em 1em; background:#deffe7; border-radius:7px; margin-bottom:1.2em; color:#10852e;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.sessions.store') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="movie_id"><b>Фильм:</b></label>
                    <select name="movie_id" id="movie_id" class="form-control" required>
                        <option value="">-- Выберите фильм --</option>
                        @foreach (\App\Models\Movie::orderBy('title')->get() as $movie)
                            <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }} ({{ $movie->duration }} мин.)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="session_datetime"><b>Дата и время:</b></label>
                    <input type="datetime-local" name="session_datetime" id="session_datetime" class="form-control" 
                        value="{{ old('session_datetime') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="price"><b>Цена (₽):</b></label>
                    <input type="number" name="price" id="price" class="form-control" 
                        value="{{ old('price', 300) }}" min="0" step="1" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Создать сеанс</button>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('cabinet') }}" class="text-primary">← Вернуться в личный кабинет</a>
    </div>
</div>
@endsection
