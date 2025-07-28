<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        <span class="text-white font-semibold">{{ __('Información del Perfil') }}</span>
    </x-slot>

    <x-slot name="description" class="">
        <span class="text-gray-300">{{ __('Actualiza la información de tu cuenta y dirección de correo electrónico.') }}</span>
    </x-slot>

    <x-slot name="form">
        <!-- Foto de Perfil -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Input de Archivo para Foto de Perfil -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Foto') }}" class="text-gray-200 font-medium" />

                <!-- Foto de Perfil Actual -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full size-20 object-cover border-2 border-gray-600">
                </div>

                <!-- Vista Previa de Nueva Foto de Perfil -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center border-2 border-gray-600"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2 bg-gray-700 text-white hover:bg-gray-600 border-gray-600" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Seleccionar Nueva Foto') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2 bg-gray-700 text-white hover:bg-gray-600 border-gray-600" wire:click="deleteProfilePhoto">
                        {{ __('Eliminar Foto') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2 text-red-400" />
            </div>
        @endif

        <!-- Nombre -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nombre') }}" class="!text-black font-medium" />
            <x-input id="name" type="text" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-blue-400" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2 text-red-400" />
        </div>

        <!-- Correo Electrónico -->
        <div class="col-span-6 sm:col-span-4 text-black">
            <x-label for="email" value="{{ __('Correo Electrónico') }}" class="!text-black font-medium" />
            <x-input id="email" type="email" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-blue-400" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2 text-red-400" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 text-gray-300">
                    {{ __('Tu dirección de correo electrónico no está verificada.') }}

                    <button type="button" class="underline text-sm text-blue-400 hover:text-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-400">
                        {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3 text-green-400" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo" class="bg-blue-600 hover:bg-blue-700 text-white font-medium">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-form-section>