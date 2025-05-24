<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    // Показать форму добавления фильма
    public function create()
    {
        return view('admin.movies.create');
    }

    // Сохранить новый фильм
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster' => 'nullable|image|max:2048',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            // Сохраняем файл в "storage/app/public/posters"
            // В posterPath будет лежать строка типа "posters/имяфайла.jpg"
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        $movie = Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'poster_path' => $posterPath,
        ]);

        return redirect()->back()->with('success', 'Фильм успешно добавлен!');
    }

    // Показать детальную страницу фильма
    public function show(Movie $movie)
    {
        // Загрузить сеансы для этого фильма (предстоящие)
        $sessions = $movie->sessions()
            ->where('session_datetime', '>=', now())
            ->orderBy('session_datetime')
            ->get();

        return view('movies.show', [
            'movie' => $movie,
            'sessions' => $sessions
        ]);
    }

    // Показать форму редактирования фильма
    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    // Обновить существующий фильм
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
            $validated['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $movie->update($validated);

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно обновлен!');
    }

    // Удалить фильм
    public function destroy(Movie $movie)
    {
        // Удаляем постер, если он существует
        if ($movie->poster_path) {
            Storage::disk('public')->delete($movie->poster_path);
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно удален!');
    }
}
