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

        h2 {
            color: #121212;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        form label {
            font-weight: 700;
            color: #121212;
            display: block;
            margin-bottom: 0.3rem;
        }

        form input[type="text"],
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
            font-family: 'Segoe UI', sans-serif;
            transition: border-color 0.3s ease;
            color: #222;
            box-sizing: border-box;
        }

        form input[type="text"]:focus,
        form textarea:focus,
        form input[type="file"]:focus {
            border-color: #2770d7;
            outline: none;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        img.poster-preview {
            max-height: 150px;
            border-radius: 6px;
            margin-bottom: 0.75rem;
            display: block;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1rem;
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
            display: inline-block;
            text-align: center;
            text-decoration: none;
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
            text-decoration: none;
        }

        .btn-danger {
            background-color: #c90d0d;
            color: #fff;
            margin-top: 1rem;
        }

        .btn-danger:hover {
            background-color: #a60707;
        }

        hr {
            margin: 2rem 0;
            border-color: #ddd;
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

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="cabinet-header">
        <div class="welcome">Редактировать фильм</div>
        <div class="cabinet-actions">
            <a href="{{ route('cabinet') }}">Личный кабинет</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">Выйти</button>
            </form>
        </div>
    </div>

    <div class="cabinet-section">
        <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title">Название:</label>
                <input type="text" name="title" id="title" value="{{ old('title', $movie->title) }}" required
                    maxlength="140" class="@error('title') is-invalid @enderror">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description">Описание:</label>
                <textarea name="description" id="description" maxlength="8000" rows="4"
                    class="@error('description') is-invalid @enderror">{{ old('description', $movie->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="poster">Постер:</label>
                @if ($movie->image)
                    <img src="{{ asset('storage/' . $movie->image) }}" alt="Постер" class="poster-preview">
                @endif
                <input type="file" name="poster" id="poster" accept="image/jpeg,image/png"
                    class="@error('poster') is-invalid @enderror">
                @error('poster')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('cabinet') }}" class="btn btn-outline-secondary">Отмена</a>
            </div>
        </form>

        <hr>

        <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST"
            onsubmit="return confirm('Уверены, что хотите удалить фильм?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Удалить фильм</button>
        </form>
    </div>
@endsection
