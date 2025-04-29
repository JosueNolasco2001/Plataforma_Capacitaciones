<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;

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
    return view('curso-x-video-x');
})->name('curso.videos.x');

Route::get('/buscar/x/video', function () {
    return view('buscar-video');
})->name('buscar.video');


Route::get('/videos/{filename}', [VideoController::class, 'show'])->name('videos.show');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
