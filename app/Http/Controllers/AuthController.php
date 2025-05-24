<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Movie;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'admin_code' => 'nullable|string',
        ]);

        // admin code должен быть секретным, например 'SECRET_ADMIN_2024'
        $adminCodeFromUser = $request->input('admin_code');
        $adminCode = 'SECRET_ADMIN_2024';
        $isAdmin = ($adminCodeFromUser === $adminCode);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $isAdmin ? 'admin' : 'user',
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $message = $isAdmin
            ? 'Вы зарегистрированы как администратор!'
            : ('Добро пожаловать, ' . $user->name . '!');

        return redirect()->route('cabinet')->with('success', $message);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginValue = $credentials['login'];
        $password = $credentials['password'];
        $fields = ['email', 'name', 'username'];

        foreach ($fields as $field) {
            if ($field === 'email' && filter_var($loginValue, FILTER_VALIDATE_EMAIL)) {
                $attempt = ['email' => $loginValue, 'password' => $password];
            } elseif ($field !== 'email') {
                $attempt = [$field => $loginValue, 'password' => $password];
            } else {
                continue;
            }

            if (Auth::attempt($attempt)) {
                $request->session()->regenerate();
                return redirect()->route('cabinet')->with('success', 'Успешный вход!');
            }
        }

        return back()->withErrors([
            'login' => 'Неверный логин или пароль.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Вы вышли из системы.');
    }

    /** Новый метод — личный кабинет */
    public function showCabinet()
    {
        $user = Auth::user();
        $tickets = $user->isUser() ? $user->tickets()->with('session.movie')->orderByDesc('id')->get() : collect();
        $movies = Movie::all(); // Получаем все фильмы
        return view('cabinet', compact('user', 'tickets', 'movies'));
    }
}
