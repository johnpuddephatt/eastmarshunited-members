<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ExchangeController;

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

Route::middleware(['approved'])->group(function () {
    Route::get('/', [ProposalController::class, 'index'])->name('dashboard')->middleware(['auth','profile']);

    Route::get('profile', [UserProfileController::class, 'show'])->name('profile')->middleware(['auth']);
    Route::post('profile', [UserProfileController::class, 'store'])->name('profile.store')->middleware(['auth']);

    Route::get('proposal/create', [ProposalController::class, 'create'])->name('proposal.create')->middleware(['auth','profile']);
    Route::get('proposal/{proposal}', [ProposalController::class, 'show'])->name('proposal.show')->middleware(['auth','profile']);
    Route::post('proposal/{proposal}', [ProposalController::class, 'update'])->name('proposal.update')->middleware(['auth','profile','owner']);
    Route::get('proposal/{proposal}/edit', [ProposalController::class, 'edit'])->name('proposal.edit')->middleware(['auth','profile','owner']);
    
    Route::post('proposal/{proposal}/exchange/create', [ExchangeController::class, 'create'])->name('exchange.create')->middleware(['auth','profile']);
    Route::post('proposal/{proposal}/exchange/{exchange}/approve', [ExchangeController::class, 'approve'])->name('exchange.approve')->middleware(['auth','profile']);
    Route::post('proposal/{proposal}/exchange/{exchange}/complete', [ExchangeController::class, 'complete'])->name('exchange.complete')->middleware(['auth','profile']);

    Route::post('proposal', [ProposalController::class, 'store'])->name('proposal.store')->middleware(['auth']);
});

Route::get('register', function () {
    return view('start');
})->name('register');

require __DIR__.'/auth.php';
