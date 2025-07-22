<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CursoNoInscritoController;
use App\Http\Controllers\DiplomaController;
use App\Http\Controllers\Auth\CustomEmailVerificationController;

Route::post('/email/custom-verification-notification', [CustomEmailVerificationController::class, 'send'])
    ->middleware('auth')
    ->name('custom.verification.send');
    
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

Route::get('/mis-cursos', [CursoNoInscritoController::class, 'misCursos'])->name('cursos.mis-cursos');
Route::get('/cursos-completados', [CursoNoInscritoController::class, 'cursosCompletados'])->name('cursos.completados');
Route::get('/buscar-cursos', [CursoNoInscritoController::class, 'buscarCursos'])->name('cursos.buscar');

Route::middleware(['auth'])->group(function () {
    // Ruta para descargar el diploma en PDF
    Route::post('/diploma/descargar', [DiplomaController::class, 'generarDiploma'])
        ->name('diploma.descargar');
    
    // Ruta para ver el diploma en el navegador
    Route::post('/diploma/ver', [DiplomaController::class, 'mostrarDiploma'])
        ->name('diploma.ver');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
