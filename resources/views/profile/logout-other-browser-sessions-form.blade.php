
<div>
<x-action-section class="">
    <x-slot name="title">
        <span class="text-white font-semibold">{{ __('Sesiones del Navegador') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-white">{{ __('Administra y cierra tus sesiones activas en otros navegadores y dispositivos.') }}</span>
    </x-slot>

    <x-slot name="content" >
        <div class="max-w-xl text-sm text-white">
            {{ __('Si es necesario, puedes cerrar sesión en todos tus otros navegadores en todos tus dispositivos. Algunas de tus sesiones recientes se muestran a continuación; sin embargo, esta lista puede no ser exhaustiva. Si sientes que tu cuenta ha sido comprometida, también deberías actualizar tu contraseña.') }}
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-6">
                <!-- Otras Sesiones del Navegador -->
                @foreach ($this->sessions as $session)
                    <div class="flex items-center">
                        <div>
                            @if ($session->agent->isDesktop())
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            @endif
                        </div>

                        <div class="ms-3">
                            <div class="text-sm text-gray-300">
                                {{ $session->agent->platform() ? $session->agent->platform() : __('Desconocido') }} - {{ $session->agent->browser() ? $session->agent->browser() : __('Desconocido') }}
                            </div>

                            <div>
                                <div class="text-xs text-gray-400">
                                    {{ $session->ip_address }},

                                    @if ($session->is_current_device)
                                        <span class="text-green-400 font-semibold">{{ __('Este dispositivo') }}</span>
                                    @else
                                        {{ __('Último activo') }} {{ $session->last_active }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex items-center mt-5">
            <x-button wire:click="confirmLogout" wire:loading.attr="disabled"
                class="bg-red-600 hover:bg-red-700 text-white font-medium">
                {{ __('Cerrar Otras Sesiones del Navegador') }}
            </x-button>

            <x-action-message class="ms-3 text-green-400" on="loggedOut">
                {{ __('Listo.') }}
            </x-action-message>
        </div>


    </x-slot>
</x-action-section>
        <!-- Modal de Confirmación para Cerrar Otras Sesiones -->
        <x-dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">
                <span class="text-white font-semibold">{{ __('Cerrar Otras Sesiones del Navegador') }}</span>
            </x-slot>

            <x-slot name="content">
                <span class="text-white">{{ __('Por favor, ingresa tu contraseña para confirmar que deseas cerrar sesión en tus otros navegadores en todos tus dispositivos.') }}</span>

                <div class="mt-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" 
                        class="mt-1 block w-3/4 bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-blue-400"
                        autocomplete="current-password"
                        placeholder="{{ __('Contraseña') }}"
                        x-ref="password"
                        wire:model="password"
                        wire:keydown.enter="logoutOtherBrowserSessions" />

                    <x-input-error for="password" class="mt-2 text-red-400" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled"
                    class="!bg-gray-700 text-white hover:bg-gray-600 border-gray-600">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-button class="ms-3 bg-red-600 hover:bg-red-700 text-white font-medium"
                            wire:click="logoutOtherBrowserSessions"
                            wire:loading.attr="disabled">
                    {{ __('Cerrar Otras Sesiones del Navegador') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>
</div>