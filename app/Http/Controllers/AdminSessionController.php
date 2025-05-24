<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovieSession;

class AdminSessionController extends Controller
{
    public function create()
    {
        // возвращает форму создания сеанса
        return view('admin.sessions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'session_datetime' => 'required|date_format:Y-m-d\TH:i',
            'price' => 'required|numeric|min:0|max:10000',
        ]);

        MovieSession::create($data);

        return redirect()->route('admin.sessions.create')->with('success', 'Сеанс успешно создан!');
    }
}
