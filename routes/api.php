<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\artistController;
use App\Http\Controllers\Api\trackController;
use App\Http\Controllers\Api\albumController;
use App\Http\Controllers\Api\playlistController;
use App\Http\Controllers\Api\searchController;

//Ruta busqueda general
Route::get('/search', [SearchController::class, 'search']);

//Rutas de artistas
Route::get('/artist',[artistController::class,'getAll']);

Route::get('/artist/{id}',[artistController::class,'show']);

Route::post('/artist',[artistController::class,'create']);

Route::put('/artist/{id}', [artistController::class,'update']);

Route::delete('/artist/{id}', [artistController::class,'delete']);

// consultas mas avanzadas 

    // Obtener todas las canciones de un artista
Route::get('/artist/{id}/tracks', [artistController::class, 'getTracks']);
    // Obtener todos los albumes de un artista
Route::get('/artist/{id}/albums', [artistController::class, 'getAlbums']);


//Rutas de canciones

Route::get('/track',[trackController::class,'getAll']);

Route::get('/track/{id}',[trackController::class,'show']);

Route::post('/track',[trackController::class,'create']);

Route::put('/track/{id}', [trackController::class,'update']);

Route::delete('/track/{id}', [trackController::class,'delete']);

// Rutas de albumes

Route::get('/album',[albumController::class,'getAll']);

Route::get('/album/{id}',[albumController::class,'show']);

Route::post('/album',[albumController::class,'create']);

Route::put('/album/{id}', [albumController::class,'update']);

Route::delete('/album/{id}', [albumController::class,'delete']);

// consultas mas complejas

    // Obtener todas las canciones de un album
Route::get('/album/{id}/tracks', [albumController::class, 'getTracks']);


//Rutas de playlist

Route::get('/playlist',[playlistController::class,'getAll']);

Route::get('/playlist/{id}',[playlistController::class,'show']);

Route::post('/playlist',[playlistController::class,'create']);

Route::put('/playlist/{id}', [playlistController::class,'update']);

Route::delete('/playlist/{id}', [playlistController::class,'delete']);

// consultas mas complejas

    // Agregar canciones a una playlist
Route::post('/playlist/{id}/track', [playlistController::class, 'addTrack']);
    // Eliminar canciones de una playlist
Route::delete('/playlist/{id}/track/{track_id}', [playlistController::class, 'removeTrack']);
    // Ver todas las canciones de una playlist
Route::get('/playlist/{id}/tracks', [playlistController::class, 'getTracks']);