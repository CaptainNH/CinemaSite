@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Редактировать фильм</h2>
        <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="title">Название:</label>
                <input type="text" name="title" value="{{ old('title', $movie->title) }}" required>
            </div>

            <div>
                <label for="description">Описание:</label>
                <textarea name="description">{{ old('description', $movie->description) }}</textarea>
            </div>

            <div>
                <label for="poster">Постер:</label>
                @if ($movie->poster_path)
                    <br>
                    <img src="{{ asset('storage/' . $movie->poster_path) }}" alt="Постер" style="max-height:150px;">
                    <br>
                @endif
                <input type="file" name="poster">
            </div>

            <button type="submit">Сохранить</button>
            <a href="{{ route('admin.movies.create') }}">Отмена</a>
        </form>

        <hr>
        <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST"
            onsubmit="return confirm('Уверены, что хотите удалить фильм?');">
            @csrf
            @method('DELETE')
            <button type="submit" style="color:red;">Удалить фильм</button>
        </form>
    </div>
@endsection
