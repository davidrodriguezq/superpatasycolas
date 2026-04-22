<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas temporales de verificación de layouts (F0-T08).
// Remover cuando existan las vistas reales en Fase 1 y Fase 3.
Route::get('/test-layout', fn () => view('test-public'));
Route::get('/test-admin',  fn () => view('test-admin'));
