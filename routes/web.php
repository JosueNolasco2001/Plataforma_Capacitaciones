<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CursoNoInscritoController;
use App\Http\Controllers\DiplomaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PuppeteerTestController;
use App\Http\Controllers\ExamenController;


use App\Http\Controllers\Auth\CustomEmailVerificationController;

Route::post('/email/custom-verification-notification', [CustomEmailVerificationController::class, 'send'])
    ->middleware('auth')
    ->name('custom.verification.send');
    
Route::get('/', function () {
   return view('welcome');
 });
// Route::get('/cursos', function () {
//     return view('cursos');
// });

// Route::get('/curso/videos', function () {
//     return view('curso-x-videos');
// })->name('curso.videos');

// Route::get('/curso/x/videos/x', function () {
//     return view('curso-x-video-x');
// })->name('curso.videos.x');

// Route::get('/buscar/x/video', function () {
//     return view('buscar-video');
// })->name('buscar.video');




Route::middleware(['auth'])->group(function () {
  Route::get('/diploma/{cursoId}/ver', [DiplomaController::class, 'verDiplomaPorCurso'])
    ->name('diploma.ver.directo');
Route::get('/diploma/{cursoId}/descargar', [DiplomaController::class, 'descargarDiplomaPorCurso'])
    ->name('diploma.descargar.directo');
});



  

//RUTAS ADMIN


 Route::middleware([ 'auth:sanctum',
    config('jetstream.auth_session'),
    'verified', 'admin'])->group(function () {
    Route::get('/agregar-video', [AdminController::class, 'agregarVideo'])->name('agregar.video');
    Route::post('/store-course', [AdminController::class, 'storeCourse'])->name('store.course');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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



//rutas para crear examenes 
// Rutas para exámenes
Route::post('/examenes/{examen}/iniciar', [ExamenController::class, 'iniciar'])->name('examenes.iniciar');
Route::post('/examenes/{examen}/enviar', [ExamenController::class, 'enviar'])->name('examenes.enviar');
Route::get('/examenes/{examen}/resultado', [ExamenController::class, 'resultado'])->name('examenes.resultado');
Route::get('/cursos/{curso}/examenes', [ExamenController::class, 'index'])->name('examenes.index');

// En routes/web.php
Route::get('/test-puppeteer', [PuppeteerTestController::class, 'test']);
// En tu web.php





});
