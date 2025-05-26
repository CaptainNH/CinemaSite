<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $posterPath = null;
        if ($request->hasFile('image')) {
            // Сохраняем файл в "storage/app/public/posters"
            // В posterPath будет лежать строка типа "posters/имяфайла.jpg"
            $posterPath = $request->file('image')->store('posters', 'public');
        }

        $movie = Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $posterPath,
        ]);

        return redirect()->back()->with('success', 'Фильм успешно добавлен!');
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

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            // Удаляем старый постер, если он существует
            if ($movie->poster_path) {
                Storage::disk('public')->delete($movie->poster_path);
            }

            // Сохраняем новый постер
            $validated['image'] = $request->file('poster')->store('posters', 'public');
        }

        $movie->update($validated);

        return redirect()->route('cabinet')->with('success', 'Фильм успешно обновлен!');
    }

    public function destroy(Movie $movie)
    {
        // Удаляем постер, если он существует
        if ($movie->poster_path) {
            Storage::disk('public')->delete($movie->poster_path);
        }

        $movie->delete();

        return redirect()->route('cabinet')->with('success', 'Фильм успешно удален!');
    }
}
