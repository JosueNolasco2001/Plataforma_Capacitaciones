<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/cursos', function () {
    return view('cursos');
});

Route::get('/curso/videos', function () {
    return view('curso-x-videos');
})->name('curso.videos');
Route::get('/curso/x/videos/x', function () {
    return view('curso-x-videos-x');
})->name('curso.videos.x');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
