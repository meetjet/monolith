<?php

use App\Http\Controllers\PlatformUserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Platform users
    Route::group([
        'prefix' => 'users',
        'as' => 'users.',
    ], function () {
        Route::get('/', [PlatformUserController::class, 'index'])->name('index');
        Route::get('/create', [PlatformUserController::class, 'create'])->name('create');
        Route::post('/', [PlatformUserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [PlatformUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [PlatformUserController::class, 'update'])->name('update');
        Route::put('/{user}/change-password', [PlatformUserController::class, 'changePassword'])
            ->name('change-password');
        Route::delete('/{user}', [PlatformUserController::class, 'destroy'])->name('destroy');
    });
});
