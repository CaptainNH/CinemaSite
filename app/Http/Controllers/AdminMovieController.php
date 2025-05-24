<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class AdminMovieController extends Controller
{
    public function index()
    {
        // Вывести список фильмов для админки
        $movies = Movie::orderBy('created_at', 'desc')->get();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        // Форма создания фильма
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        // Сохранить фильм
        $data = $request->validate([
            'title' => 'required|string|max:140',
            'description' => 'nullable|string',
            // Добавьте другие поля по необходимости
        ]);

        Movie::create($data);

        return redirect()->route('cabinet')
            ->with('success', 'Фильм успешно добавлен!');
    }

    public function show($id)
    {
        // Показать детали фильма
        $movie = Movie::findOrFail($id);
        return view('admin.movies.show', compact('movie'));
    }

    public function edit($id)
    {
        // Загрузить форму редактирования фильма
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        // Обновить данные фильма
        $movie = Movie::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:140',
            'description' => 'nullable|string',
            // Добавьте другие поля по необходимости
        ]);

        $movie->update($data);

        return redirect()->route('cabinet')
            ->with('success', 'Фильм успешно обновлен!');
    }

    public function destroy($id)
    {
        // Удалить фильм
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('cabinet')
            ->with('success', 'Фильм успешно удалён!');
    }
}
