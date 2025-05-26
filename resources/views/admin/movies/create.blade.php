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
            /* border-radius: 0 0 8px 8px; */
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

        form input[type="text"],
        form input[type="number"],
        form input[type="date"],
        form input[type="file"],
        form textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
            font-family: 'Segoe UI', sans-serif;
            transition: border-color 0.3s ease;
        }

        form input[type="text"]:focus,
        form input[type="number"]:focus,
        form input[type="date"]:focus,
        form input[type="file"]:focus,
        form textarea:focus {
            border-color: #2770d7;
            outline: none;
        }

        .invalid-feedback {
            color: #c91a1a;
            margin-top: 4px;
            font-size: 0.9em;
        }

        .row {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .col-md-4,
        .col-md-6 {
            flex: 1;
            min-width: 200px;
        }

        .mb-3 {
            margin-bottom: 1rem;
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
            background-color: #707070;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #585858;
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

        ul {
            margin: 0;
            padding-left: 20px;
        }

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
                padding: 1rem;
                max-width: 100%;
                margin-bottom: 2rem;
            }

            .row {
                flex-direction: column;
            }
        }
    </style>

    <div class="cabinet-header">
        <div class="welcome">
            Добавить фильм
        </div>
        <div class="cabinet-actions">
            {{-- <a href="{{ route('admin.movies.index') }}">К списку фильмов</a> --}}
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

        <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="mb-3">
                <label for="title">Название фильма:</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required maxlength="140"
                    class="@error('title') is-invalid @enderror">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image">Постер: <span class="text-muted">(jpg/png, макс 4MB)</span></label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png"
                    class="@error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description">Описание:</label>
                <textarea id="description" name="description" rows="4" maxlength="8000"
                    class="@error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="director">Режиссёр:</label>
                    <input type="text" id="director" name="director" maxlength="128" value="{{ old('director') }}"
                        class="@error('director') is-invalid @enderror">
                    @error('director')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="duration_minutes">Длительность (мин.):</label>
                    <input type="number" id="duration_minutes" name="duration_minutes" min="1" max="999"
                        value="{{ old('duration_minutes') }}" class="@error('duration_minutes') is-invalid @enderror">
                    @error('duration_minutes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="release_date">Дата выхода:</label>
                    <input type="date" id="release_date" name="release_date" value="{{ old('release_date') }}"
                        class="@error('release_date') is-invalid @enderror">
                    @error('release_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="genre">Жанр:</label>
                    <input type="text" id="genre" name="genre" maxlength="100" value="{{ old('genre') }}"
                        class="@error('genre') is-invalid @enderror">
                    @error('genre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="country">Страна:</label>
                    <input type="text" id="country" name="country" maxlength="100" value="{{ old('country') }}"
                        class="@error('country') is-invalid @enderror">
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid d-md-flex justify-content-md-end">
                <a href="{{ route('cabinet') }}" class="btn btn-outline-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary">Добавить фильм</button>
            </div>
        </form>

        @if ($errors->any() && $errors->count() > 0)
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
