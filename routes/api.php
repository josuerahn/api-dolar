<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CotizacionController;
use App\Http\Controllers\Api\PromedioController;

Route::get('/cotizaciones/latest',  [CotizacionController::class, 'latest']);
Route::get('/cotizaciones/history', [CotizacionController::class, 'history']);
Route::get('/promedios/mensual',    [PromedioController::class, 'mensual']);
