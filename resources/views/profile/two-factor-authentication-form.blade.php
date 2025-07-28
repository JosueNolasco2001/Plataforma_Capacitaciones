<x-action-section>
    <x-slot name="title">
        <span class="text-white font-semibold">{{ __('Autenticación de Dos Factores') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-gray-300">{{ __('Agrega seguridad adicional a tu cuenta usando autenticación de dos factores.') }}</span>
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-white">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Termina de habilitar la autenticación de dos factores.') }}
                @else
                    {{ __('Has habilitado la autenticación de dos factores.') }}
                @endif
            @else
                {{ __('No has habilitado la autenticación de dos factores.') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-white">
            <p>
                {{ __('Cuando la autenticación de dos factores esté habilitada, se te pedirá un token seguro y aleatorio durante la autenticación. Puedes obtener este token desde la aplicación Google Authenticator de tu teléfono.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-gray-300">
                    <p class="font-semibold">
                        @if ($showingConfirmation)
                            {{ __('Para terminar de habilitar la autenticación de dos factores, escanea el siguiente código QR usando la aplicación de autenticación de tu teléfono o ingresa la clave de configuración y proporciona el código OTP generado.') }}
                        @else
                            {{ __('La autenticación de dos factores ya está habilitada. Escanea el siguiente código QR usando la aplicación de autenticación de tu teléfono o ingresa la clave de configuración.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 p-2 inline-block bg-white rounded-lg">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm">
                    <p class="font-semibold text-gray-800">
                        {{ __('Clave de Configuración') }}: 
                        <span class="font-mono text-blue-400 bg-gray-800 px-2 py-1 rounded">{{ decrypt($this->user->two_factor_secret) }}</span>
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <x-label for="code" value="{{ __('Código') }}" class="!text-black font-medium" />

                        <x-input id="code" type="text" name="code" 
                            class="block mt-1 w-1/2 bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-blue-400" 
                            inputmode="numeric" autofocus autocomplete="one-time-code"
                            wire:model="code"
                            wire:keydown.enter="confirmTwoFactorAuthentication" />

                        <x-input-error for="code" class="mt-2 text-red-400" />
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-gray-300">
                    <p class="font-semibold">
                        {{ __('Guarda estos códigos de recuperación en un administrador de contraseñas seguro. Pueden usarse para recuperar el acceso a tu cuenta si tu dispositivo de autenticación de dos factores se pierde.') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-800 rounded-lg border border-gray-600">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div class="text-green-400">{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-button type="button" wire:loading.attr="disabled" 
                        class="bg-green-600 hover:bg-green-700 text-white font-medium">
                        {{ __('Habilitar') }}
                    </x-button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-secondary-button class="me-3 bg-gray-700 text-white hover:bg-gray-600 border-gray-600">
                            {{ __('Regenerar Códigos de Recuperación') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <x-button type="button" class="me-3 bg-blue-600 hover:bg-blue-700 text-white font-medium" wire:loading.attr="disabled">
                            {{ __('Confirmar') }}
                        </x-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <x-secondary-button class="me-3 bg-gray-700 text-white hover:bg-gray-600 border-gray-600">
                            {{ __('Mostrar Códigos de Recuperación') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-secondary-button wire:loading.attr="disabled" 
                            class=" !text-black  border-gray-600">
                            {{ __('Cancelar') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-danger-button wire:loading.attr="disabled" 
                            class="bg-red-600 hover:bg-red-700 text-white font-medium">
                            {{ __('Deshabilitar') }}
                        </x-danger-button>
                    </x-confirms-password>
                @endif

            @endif
        </div>
    </x-slot>
</x-action-section>