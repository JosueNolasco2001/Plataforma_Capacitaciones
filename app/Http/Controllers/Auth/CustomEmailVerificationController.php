<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class CustomEmailVerificationController extends Controller
{
    public function send(Request $request)
    {
        // Si ya está verificado
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Tu email ya está verificado.',
                'verified' => true
            ], 400);
        }

        // Clave única por usuario para el rate limiting
        $key = 'email-verification:' . $request->user()->id;
        
        // Verificar si ha excedido el límite (1 intento por minuto según tu código original)
        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Debes esperar {$seconds} segundos antes de poder enviar otro correo de verificación.",
                'retry_after' => $seconds,
                'too_many_attempts' => true
            ], 429);
        }

        // Incrementar el contador (1 intento por 60 segundos)
        RateLimiter::hit($key, 60);
        
        // Calcular cuántos intentos quedan
        $attempts = RateLimiter::attempts($key);
        $remaining = 1 - $attempts; // Cambiado a 1 porque tu límite es 1
        
        // Enviar el email
        $request->user()->sendEmailVerificationNotification();
        
        $message = 'Correo de verificación enviado exitosamente.';
        if ($remaining <= 0) {
            $message .= " Debes esperar 1 minuto antes de poder enviar otro correo.";
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'retry_after' => 60, // 60 segundos de espera
            'remaining_attempts' => $remaining
        ]);
    }
}