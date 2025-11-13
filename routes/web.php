<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CursoNoInscritoController;
use App\Http\Controllers\DiplomaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PuppeteerTestController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\Auth\CustomEmailVerificationController;

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

// Rutas de verificación de email
Route::post('/email/custom-verification-notification', [CustomEmailVerificationController::class, 'send'])
    ->middleware('auth')
    ->name('custom.verification.send');

// Rutas para usuarios autenticados (sin verificación de admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/diploma/{cursoId}/ver', [DiplomaController::class, 'verDiplomaPorCurso'])
        ->name('diploma.ver.directo');
    Route::get('/diploma/{cursoId}/descargar', [DiplomaController::class, 'descargarDiplomaPorCurso'])
        ->name('diploma.descargar.directo');
});

// Rutas con autenticación completa (Sanctum + Jetstream + Verified)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestión de cursos
    Route::get('/homepage', [CursoNoInscritoController::class, 'mostrarCursosDisponibles'])->name('cursos.disponibles');
    Route::get('/cursos/disponibles/{id}', [CursoNoInscritoController::class, 'show']);
    Route::get('/mis-cursos', [CursoNoInscritoController::class, 'misCursos'])->name('cursos.mis-cursos');
    Route::get('/cursos-completados', [CursoNoInscritoController::class, 'cursosCompletados'])->name('cursos.completados');
    Route::get('/buscar-cursos', [CursoNoInscritoController::class, 'buscarCursos'])->name('cursos.buscar');
    Route::post('/curso/{id}/suscribirse', [CursoNoInscritoController::class, 'suscribirse'])->name('curso.suscribirse');

    // Gestión de videos
    Route::get('/curso/{id}/videos', [CursoNoInscritoController::class, 'mostrarVideos'])->name('curso.videos');
    Route::get('/curso/videos/{id}', [VideoController::class, 'mostrar'])->name('video.mostrar');
    Route::post('/video/{id}/marcar-visto', [VideoController::class, 'marcarComoVisto'])->name('video.marcar-visto');

    // Comentarios y respuestas
    Route::post('/video/{id}/comentario', [VideoController::class, 'agregarComentario'])->name('video.comentario');
    Route::post('/comentario/{id}/respuesta', [VideoController::class, 'agregarRespuesta'])->name('comentario.respuesta');

    // Exámenes
    Route::get('/examenes/{id}/tomar', [ExamenController::class, 'tomarExamen'])->name('examenes.tomar');
    Route::post('/examenes/{id}/guardar', [ExamenController::class, 'guardarExamen'])->name('examenes.guardar');
    Route::get('/examenes/{id}/continuar', [ExamenController::class, 'continuarExamen'])->name('examenes.continuar');
    Route::get('/examenes/{id}/resultado', [ExamenController::class, 'verResultado'])->name('examenes.resultado');

    // Testing
    Route::get('/test-puppeteer', [PuppeteerTestController::class, 'test']);

    // Rutas de administrador (subgrupo con middleware adicional)
    Route::middleware(['admin'])->group(function () {
        Route::get('/agregar-video', [AdminController::class, 'agregarVideo'])->name('agregar.video');
        Route::post('/store-course', [AdminController::class, 'storeCourse'])->name('store.course');
    });
});