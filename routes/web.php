<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CursoNoInscritoController;

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
    Route::get('/cursos/disponibles', [CursoNoInscritoController::class, 'index']);
    Route::get('/cursos/disponibles/{id}', [CursoNoInscritoController::class, 'show']);


    Route::get('/homepage', [CursoNoInscritoController::class, 'mostrarCursosDisponibles'])->name('cursos.disponibles');
    Route::get('/curso/{id}/videos', [CursoNoInscritoController::class, 'mostrarVideos'])->name('curso.videos');
    Route::get('/curso/videos/{id}', [VideoController::class, 'mostrar'])->name('video.mostrar');
  Route::post('/video/{id}/comentario', [VideoController::class, 'agregarComentario'])->name('video.comentario');
Route::post('/comentario/{id}/respuesta', [VideoController::class, 'agregarRespuesta'])->name('comentario.respuesta');

Route::post('/curso/{id}/suscribirse', [CursoNoInscritoController::class, 'suscribirse'])->name('curso.suscribirse');

    Route::post('/video/{id}/marcar-visto', [VideoController::class, 'marcarComoVisto'])->name('video.marcar-visto');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
