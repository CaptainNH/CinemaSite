// === ROUTES ===
// routes/web.php
use App\Http\Controllers\AuthController;

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === CONTROLLER ===
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
public function showRegisterForm()
{
return view('auth.register');
}

public function register(Request $request)
{
$request->validate([
'username' => 'required|string|min:3|max:50|unique:users',
'email' => 'nullable|email|unique:users',
'password' => 'required|string|min:6|confirmed',
]);

$user = User::create([
'username' => $request->username,
'email' => $request->email,
'role' => 'user',
'password' => Hash::make($request->password),
]);

Auth::login($user);

return redirect()->intended('/')->with('success', 'Добро пожаловать, '.$user->username.'!');
}

public function showLoginForm()
{
return view('auth.login');
}

public function login(Request $request)
{
$credentials = $request->validate([
'username' => 'required|string',
'password' => 'required|string',
]);

if (Auth::attempt($credentials)) {
$request->session()->regenerate();
return redirect()->intended('/')->with('success', 'Успешный вход!');
}

return back()->withErrors([
'username' => 'Неверные данные.',
]);
}

public function logout(Request $request)
{
Auth::logout();
$request->session()->invalidate();
$request->session()->regenerateToken();
return redirect('/login')->with('success', 'Вы вышли из системы.');
}
}

// === VIEWS (BLADE TEMPLATES) ===

// resources/views/auth/register.blade.php
/*
@extends('layouts.app')
@section('content')
<h2>Регистрация</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <input type="text" name="username" placeholder="Логин" value="{{ old('username') }}" required>
    <input type="email" name="email" placeholder="Email (необязательно)" value="{{ old('email') }}">
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="password" name="password_confirmation" placeholder="Повторите пароль" required>
    <button type="submit">Зарегистрироваться</button>
    @if($errors->any())
    <div>
        @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
    </div>
    @endif
</form>
@endsection
*/

// resources/views/auth/login.blade.php
/*
@extends('layouts.app')
@section('content')
<h2>Вход</h2>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="text" name="username" placeholder="Логин" value="{{ old('username') }}" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Войти</button>
    @if($errors->any())
    <div>
        @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
    </div>
    @endif
</form>
@endsection
*/

// Для полноценной работы потребуется layout (например, resources/views/layouts/app.blade.php) — его тоже сгенерирую по запросу!
// По готовности не забудьте создать таблицу users, прописать guarded/fillable и убедиться, что model User расширяет Authenticatable.