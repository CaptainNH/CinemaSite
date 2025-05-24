@extends('layouts.app')

@section('content')
    <style>
        /* Используем тот же CSS, что и для формы фильма — можно вынести в layout для повторного использования */
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
            background-color: #fafafa;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #121212;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        form label {
            font-weight: 700;
            color: #121212;
        }

        form select,
        form input[type="text"],
        form input[type="datetime-local"],
        form input[type="number"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
            font-family: 'Segoe UI', sans-serif;
            transition: border-color 0.3s ease;
        }

        form select:focus,
        form input:focus {
            border-color: #2770d7;
            outline: none;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 6px;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .invalid-feedback {
            color: #c91a1a;
            margin-top: 4px;
            font-size: 0.9em;
        }

        .d-grid,
        .d-md-flex {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-family: 'Segoe UI', sans-serif;
            transition: background-color 0.3s ease;
            user-select: none;
        }

        .btn-primary {
            background-color: #c91a1a;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #a60707;
        }

        .btn-outline-secondary {
            background-color: transparent;
            border: 2px solid #c91a1a;
            color: #c91a1a;
        }

        .btn-outline-secondary:hover {
            background-color: #a60707;
            color: #fff;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }

        form .form-group {
            margin-bottom: 2.5rem;
            /* Было mb-3 (~1rem), стало 1.5rem */
        }

        form .form-group:last-of-type {
            margin-bottom: 2.5rem;
            /* Больше отступ перед кнопками */
        }

        form .btn {
            margin-top: 0.5rem;
            /* Можно добавить немного сверху, если хочется ещё воздуха */
        }
    </style>

    <div class="cabinet-header">
        <div class="welcome">Создание сеанса</div>
        <div class="cabinet-actions">
            <a href="{{ route('cabinet') }}">Личный кабинет</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">Выйти</button>
            </form>
        </div>
    </div>

    <div class="cabinet-section">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.sessions.store') }}">
            @csrf

            <div class="mb-3">
                <label for="movie_id">Фильм:</label>
                <select name="movie_id" id="movie_id" required class="@error('movie_id') is-invalid @enderror">
                    <option value="">-- Выберите фильм --</option>
                    @foreach (\App\Models\Movie::orderBy('title')->get() as $movie)
                        <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                            {{ $movie->title }} ({{ $movie->duration }} мин.)
                        </option>
                    @endforeach
                </select>
                @error('movie_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="session_datetime">Дата и время:</label>
                <input type="datetime-local" name="session_datetime" id="session_datetime"
                    value="{{ old('session_datetime') }}" required class="@error('session_datetime') is-invalid @enderror">
                @error('session_datetime')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price">Цена (₽):</label>
                <input type="number" name="price" id="price" value="{{ old('price', 300) }}" min="0"
                    step="1" required class="@error('price') is-invalid @enderror">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid d-md-flex justify-content-md-end">
                <a href="{{ route('cabinet') }}" class="btn btn-outline-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary">Создать сеанс</button>
            </div>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger mt-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
