<?php

use Illuminate\Support\Facades\Route;

/*
 * Rutas del panel administrativo.
 * Prefijo: /admin  |  Middleware: auth + role:admin|collaborator  |  Name prefix: admin.
 * Las rutas de módulos específicos se agregan en sus respectivas fases.
 */

Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

// Fase 1: usuarios — F1-T05
// Route::resource('/usuarios', Admin\UserController::class)->names('users');

// Fase 1: animales — F1-T09
// Route::resource('/animales', Admin\AnimalController::class)->names('animals');

// Fase 2: adopciones — F2-T05
// Route::resource('/adopciones', Admin\AdoptionRequestController::class)->names('adoptions');

// Fase 2: cesiones — F2-T12
// Route::resource('/cesiones', Admin\CessionRequestController::class)->names('cessions');

// Fase 2: seguimientos — F2-T16
// Route::resource('/seguimiento', Admin\PostAdoptionFollowupController::class)->names('followups');
