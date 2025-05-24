<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\MovieSession;
use App\Models\Ticket;

class PosterController extends Controller
{
    // Показ афиши на главной
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        // Получаем все фильмы, у которых есть сеансы на эту дату
        $sessions = MovieSession::with('movie')
            ->whereDate('session_datetime', $date)
            ->orderBy('session_datetime')
            ->get();

        // Группируем сеансы по фильмам
        $grouped = $sessions->groupBy('movie_id');

        return view('welcome', [
            'groupedSessions' => $grouped,
            'sessions' => $sessions,
            'date' => $date,
        ]);
    }

    // Купить билет
    public function buy(Request $request, $sessionId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Требуется авторизация');
        }

        $session = MovieSession::findOrFail($sessionId);
        $user = Auth::user();

        // Проверка: не куплен ли уже билет на этот сеанс
        if ($user->tickets()->where('movie_session_id', $sessionId)->exists()) {
            return redirect()->back()->with('error', 'Билет уже куплен');
        }

        Ticket::create([
            'user_id' => $user->id,
            'movie_session_id' => $session->id,
            'movie_id' => $session->movie_id,
            'price' => $session->price,
            'session_datetime' => $session->session_datetime,
        ]);

        return redirect()->back()->with('success', 'Билет куплен!');
    }
}
