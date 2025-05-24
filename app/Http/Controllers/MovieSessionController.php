<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieSession;
use Illuminate\Http\Request;

class MovieSessionController extends Controller
{
    /**
     * Показать форму создания нового сеанса
     */
    public function create()
    {
        $movies = Movie::all();
        return view('sessions.create', compact('movies'));
    }

    /**
     * Сохранить новый сеанс
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'session_datetime' => 'required|date',
            'price' => 'required|integer|min:0',
        ]);

        MovieSession::create($validated);

        return redirect()->back()->with('success', 'Сеанс успешно создан!');
    }
}
