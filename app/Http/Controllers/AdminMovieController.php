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
            'director' => 'nullable|string|max:100',
            'duration_minutes' => 'nullable|integer|min:0',
            'release_date' => 'nullable|date',
            'genre' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
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
            'director' => $request->director,
            'duration_minutes' => $request->duration_minutes,
            'release_date' => $request->release_date,
            'genre' => $request->genre,
            'country' => $request->country
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
            if ($movie->image) {
                Storage::disk('public')->delete($movie->image);
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
        if ($movie->image) {
            Storage::disk('public')->delete($movie->image);
        }

        $movie->delete();

        return redirect()->route('cabinet')->with('success', 'Фильм успешно удален!');
    }
}
