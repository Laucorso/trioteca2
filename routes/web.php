<?php

use App\Http\Controllers\AppraisalsController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/appraisals/{id}/logs', [AppraisalsController::class, 'showHistoryLog'])->name('appraisals.logs');
    Route::get('/appraisals', [AppraisalsController::class, 'getAll']);
    Route::post('/appraisals', [AppraisalsController::class, 'store'])->name('appraisals.store');
    Route::put('/appraisals/{appraisalId}/update', [AppraisalsController::class, 'updateStatus'])->name('appraisals.update');
});

require __DIR__.'/auth.php';
