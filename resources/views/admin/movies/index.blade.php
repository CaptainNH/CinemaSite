@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Список фильмов</h2>
        <a href="{{ route('admin.movies.create') }}">Добавить фильм</a>
        <table>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movies as $movie)
                    <tr>
                        <td>{{ $movie->title }}</td>
                        <td>{{ Str::limit($movie->description, 60) }}</td>
                        <td>
                            <a href="{{ route('admin.movies.edit', $movie) }}">Редактировать</a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Удалить фильм?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
