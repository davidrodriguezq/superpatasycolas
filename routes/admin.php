<?php

use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Admin\MedicalRecordController;
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

// Fase 1: animales — F1-T09 a F1-T14 (admin y collaborator)
Route::resource('animals', AnimalController::class);
Route::delete('animals/{animal}/photos/{photo}', [AnimalController::class, 'destroyPhoto'])->name('animals.destroy-photo');
Route::patch('animals/{animal}/photos/{photo}/set-primary', [AnimalController::class, 'setPrimaryPhoto'])->name('animals.set-primary-photo');

// Fase 1: historial clínico — F1-T12
Route::post('animals/{animal}/medical-records', [MedicalRecordController::class, 'store'])->name('animals.medical-records.store');
Route::delete('animals/{animal}/medical-records/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('animals.medical-records.destroy');

// Fase 2: adopciones — F2-T05
// Route::resource('/adopciones', Admin\AdoptionRequestController::class)->names('adoptions');

// Fase 2: cesiones — F2-T12
// Route::resource('/cesiones', Admin\CessionRequestController::class)->names('cessions');

// Fase 2: seguimientos — F2-T16
// Route::resource('/seguimiento', Admin\PostAdoptionFollowupController::class)->names('followups');
