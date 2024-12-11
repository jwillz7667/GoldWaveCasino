<?php

use App\Http\Controllers\ProfileController;
use App\Models\Game;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $slotGames = Game::where('type', 'slot')->where('is_active', true)->get();
    $arcadeGames = Game::where('type', 'arcade')->where('is_active', true)->get();
    
    return view('welcome', [
        'slotGames' => $slotGames,
        'arcadeGames' => $arcadeGames
    ]);
});

Route::get('/dashboard', function () {
    $slotGames = Game::where('type', 'slot')->where('is_active', true)->get();
    $arcadeGames = Game::where('type', 'arcade')->where('is_active', true)->get();
    
    return view('dashboard', [
        'slotGames' => $slotGames,
        'arcadeGames' => $arcadeGames
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
