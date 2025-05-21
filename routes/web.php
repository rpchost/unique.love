<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Unilo\Keys\CacheKeys;
use App\Http\Controllers\LogController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/log', [LogController::class, 'index']);

Route::get('/matches', [MatchController::class, 'index']);

Route::middleware(['auth:web', 'role:admin'])->group(function () {
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
});

// Route::middleware(['auth:web', 'role:admin'])->get('/clear-user-cache/{id}', function ($id) {
//     $cacheKeys = [
//         CacheKeys::format(CacheKeys::USER_DATA, ['guard' => 'web', 'id' => $id]),
//         CacheKeys::format(CacheKeys::USER_TOKEN, ['guard' => 'web', 'id' => $id]),
//     ];
//     foreach ($cacheKeys as $key) {
//         Cache::forget($key);
//     }
//     return 'User cache cleared';
// })->name('clear-user-cache');

Route::resource('users', \App\Http\Controllers\UserController::class);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/test-redis', function () {
    try {
        Redis::set('test_key', 'Redis is working!');
        return Redis::get('test_key');
    } catch (\Exception $e) {
        return 'Redis error: ' . $e->getMessage();
    }
})->middleware('role:admin');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test-simple', function () {
    return 'Simple route works!';
});
