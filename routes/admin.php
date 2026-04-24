<?php

use App\Http\Controllers\Admin\AdoptionRequestController;
use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Admin\CessionRequestController;
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

// Fase 2: adopciones — F2-T05, F2-T06
Route::resource('adoption-requests', AdoptionRequestController::class)
    ->only(['index', 'show'])
    ->parameters(['adoption-requests' => 'adoptionRequest']);
Route::patch('adoption-requests/{adoptionRequest}/approve', [AdoptionRequestController::class, 'approve'])->name('adoption-requests.approve');
Route::patch('adoption-requests/{adoptionRequest}/reject', [AdoptionRequestController::class, 'reject'])->name('adoption-requests.reject');

// Fase 2: cesiones — F2-T12, F2-T13
Route::resource('cession-requests', CessionRequestController::class)
    ->only(['index', 'show'])
    ->parameters(['cession-requests' => 'cessionRequest']);
Route::patch('cession-requests/{cessionRequest}/accept', [CessionRequestController::class, 'accept'])->name('cession-requests.accept');
Route::patch('cession-requests/{cessionRequest}/reject', [CessionRequestController::class, 'reject'])->name('cession-requests.reject');

// Fase 2: seguimientos — F2-T16
// Route::resource('/seguimiento', Admin\PostAdoptionFollowupController::class)->names('followups');
