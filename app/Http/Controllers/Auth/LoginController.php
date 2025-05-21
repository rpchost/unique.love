<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Unilo\Keys\CacheKeys;
use App\Services\CacheKeyFormatter;

class LoginController extends Controller
{
    private readonly CacheKeyFormatter $keyFormatter;

    public function __construct(CacheKeyFormatter $keyFormatter)
    {
        $this->keyFormatter = $keyFormatter;
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        file_put_contents(storage_path('logs/auth_debug.log'), 'showLoginForm called: ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
        }
        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();
        if ($userId) {
            $cacheKeys = [
                $this->keyFormatter->format(CacheKeys::USER_TOKEN, [
                'guard' => $this->getGuard(),
                'id' => (string) $userId]),
                $this->keyFormatter->format(CacheKeys::USER_DATA, [
                'guard' => $this->getGuard(),
                'id' => (string) $userId]),
            ];

            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    protected function getGuard(): string
    {
        return request()->route()->getAction('guard') ?? 'web';
    }
}
