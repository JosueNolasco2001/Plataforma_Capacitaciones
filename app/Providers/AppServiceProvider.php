<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Devrabiul\LivewireDoctor\LivewireDoctor;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
          LivewireDoctor::initCustomAsset();

              ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Solicitud de Restablecimiento de Contraseña')
                ->greeting('¡Hola!')
                ->line('Estás recibiendo este correo porque recibimos una solicitud de restablecimiento de contraseña para tu cuenta.')
                ->action('Restablecer Contraseña', $url)
                ->line('Este enlace de restablecimiento expirará en ' . config('auth.passwords.users.expire') . ' minutos.')
                ->line('Si no solicitaste un restablecimiento de contraseña, no se requiere ninguna acción adicional.')
                ->salutation('Saludos' . config('app.name'));
        });

         // Verify Email personalizado (NUEVO)
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verificar Dirección de Correo Electrónico')
                ->greeting('¡Hola!')
                ->line('Por favor, haz clic en el botón de abajo para verificar tu dirección de correo electrónico.')
                ->action('Verificar Correo Electrónico', $url)
                ->line('Si no creaste una cuenta, no se requiere ninguna acción adicional.')
                ->salutation('Saludos');
        });
    }
}
