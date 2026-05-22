<?php

use App\Http\Controllers\Admin\AdoptionRequestController;
use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CessionRequestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FollowupController;
use App\Http\Controllers\Admin\MedicalRecordController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
 * Rutas del panel administrativo.
 * Prefijo: /admin  |  Middleware: auth + role:admin|collaborator  |  Name prefix: admin.
 */

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

// DESACTIVADO: Módulo de cesión deshabilitado por decisión del cliente.
// El albergue no acepta animales por cesión, solo rescata. Código conservado para referencia.
// Route::resource('cession-requests', CessionRequestController::class)
//     ->only(['index', 'show'])
//     ->parameters(['cession-requests' => 'cessionRequest']);
// Route::patch('cession-requests/{cessionRequest}/accept', [CessionRequestController::class, 'accept'])->name('cession-requests.accept');
// Route::patch('cession-requests/{cessionRequest}/reject', [CessionRequestController::class, 'reject'])->name('cession-requests.reject');

// Fase 3: blog — F3-T06
Route::resource('blog-posts', BlogPostController::class)->except(['show']);

// Fase 2: seguimientos — F2-T15 a F2-T19
Route::get('followups', [FollowupController::class, 'index'])->name('followups.index');
Route::get('adoption-requests/{adoptionRequest}/followups/create', [FollowupController::class, 'create'])->name('followups.create');
Route::post('adoption-requests/{adoptionRequest}/followups', [FollowupController::class, 'store'])->name('followups.store');
Route::get('followups/{followup}', [FollowupController::class, 'show'])->name('followups.show');
Route::delete('followups/{followup}', [FollowupController::class, 'destroy'])->name('followups.destroy');

// Fase 4: reportes PDF — F4-T23
Route::get('reports/animal/{animal}/medical', [ReportController::class, 'animalMedicalReport'])->name('reports.animal-medical');
Route::get('reports/statistics', [ReportController::class, 'shelterStatistics'])->name('reports.statistics');
Route::get('reports/animals-list', [ReportController::class, 'animalsList'])->name('reports.animals-list');

// Fase 4: notificaciones internas — F4-T24
Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::patch('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
