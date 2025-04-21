<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
    <!-- Fondo con efectos especiales -->
    <div class="fixed inset-0 -z-10 bg-[#0A0A0A]">
        <!-- Gradient Mesh -->
        <div class="absolute inset-0 bg-gradient-to-br from-violet-600/20 via-transparent to-cyan-600/20 opacity-50"></div>
        
        <!-- Animated Shapes -->
        <div class="absolute top-1/4 -left-20 w-[20rem] sm:w-[30rem] lg:w-[40rem] h-[20rem] sm:h-[30rem] lg:h-[40rem] bg-gradient-to-br from-violet-600/30 to-fuchsia-600/30 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 -right-20 w-[20rem] sm:w-[30rem] lg:w-[40rem] h-[20rem] sm:h-[30rem] lg:h-[40rem] bg-gradient-to-br from-cyan-600/30 to-blue-600/30 rounded-full blur-3xl animate-float [animation-delay:-6s]"></div>
        
        <!-- Glass Layer (ajustado para mejor legibilidad) -->
        <div class="absolute inset-0 backdrop-blur-[20px] sm:backdrop-blur-[30px]"></div>
    </div>

    <!-- Contenido principal (igual que tu estructura original pero con ajustes de color) -->
    <div class="z-10">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4  backdrop-blur-sm shadow-md overflow-hidden sm:rounded-lg border border-white/20">
        {{ $slot }}
    </div>
</div>