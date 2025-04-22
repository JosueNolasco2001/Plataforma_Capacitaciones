<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">

    <!-- Contenido principal (igual que tu estructura original pero con ajustes de color) -->
    <div class="z-10">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4  backdrop-blur-sm shadow-md overflow-hidden sm:rounded-lg border border-white/20">
        {{ $slot }}
    </div>
</div>