<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
 * Rutas del panel administrativo.
 * Prefijo: /admin  |  Middleware: auth + role:admin|collaborator  |  Name prefix: admin.
 */

Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

// Fase 1: usuarios — F1-T05 (solo admin, no collaborator)
Route::middleware('role:admin')->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'store', 'destroy']);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
});

// Fase 1: animales — F1-T09
// Route::resource('/animales', Admin\AnimalController::class)->names('animals');

// Fase 2: adopciones — F2-T05
// Route::resource('/adopciones', Admin\AdoptionRequestController::class)->names('adoptions');

// Fase 2: cesiones — F2-T12
// Route::resource('/cesiones', Admin\CessionRequestController::class)->names('cessions');

// Fase 2: seguimientos — F2-T16
// Route::resource('/seguimiento', Admin\PostAdoptionFollowupController::class)->names('followups');
