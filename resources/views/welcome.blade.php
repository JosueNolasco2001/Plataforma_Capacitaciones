<script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'morph': 'morph 8s ease-in-out infinite',
                        'float': 'float 12s ease-in-out infinite',
                        'gradient': 'gradient 8s linear infinite',
                        'reveal': 'reveal 1.5s cubic-bezier(0.2, 1, 0.3, 1)',
                        'slide': 'slide 1s cubic-bezier(0.2, 1, 0.3, 1)',
                        'scale': 'scale 1s cubic-bezier(0.2, 1, 0.3, 1)',
                    },
                    keyframes: {
                        morph: {
                            '0%, 100%': { borderRadius: '60% 40% 30% 70%/60% 30% 70% 40%' },
                            '50%': { borderRadius: '30% 60% 70% 40%/50% 60% 30% 60%' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0) scale(1)' },
                            '50%': { transform: 'translateY(-20px) scale(1.05)' }
                        },
                        gradient: {
                            '0%': { backgroundPosition: '0% 50%' },
                            '100%': { backgroundPosition: '100% 50%' }
                        },
                        reveal: {
                            '0%': { transform: 'translateY(20px)', opacity: 0 },
                            '100%': { transform: 'translateY(0)', opacity: 1 }
                        },
                        slide: {
                            '0%': { transform: 'translateX(-20px)', opacity: 0 },
                            '100%': { transform: 'translateX(0)', opacity: 1 }
                        },
                        scale: {
                            '0%': { transform: 'scale(0.95)', opacity: 0 },
                            '100%': { transform: 'scale(1)', opacity: 1 }
                        }
                    }
                }
            }
        }
    </script>

<body class="bg-[#0A0A0A] overflow-x-hidden">
 
    <!-- Modern Hero Section -->
    <div class="relative min-h-[100dvh] overflow-hidden flex items-center justify-center">
        <!-- Background Elements -->
        <div class="fixed inset-0">
            <!-- Gradient Mesh -->
            <div class="absolute inset-0 bg-gradient-to-br from-violet-600/20 via-transparent to-cyan-600/20 opacity-50"></div>
            
            <!-- Animated Shapes - Responsive sizes -->
            <div class="absolute top-1/4 -left-20 w-[20rem] sm:w-[30rem] lg:w-[40rem] h-[20rem] sm:h-[30rem] lg:h-[40rem] bg-gradient-to-br from-violet-600/30 to-fuchsia-600/30 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-1/4 -right-20 w-[20rem] sm:w-[30rem] lg:w-[40rem] h-[20rem] sm:h-[30rem] lg:h-[40rem] bg-gradient-to-br from-cyan-600/30 to-blue-600/30 rounded-full blur-3xl animate-float [animation-delay:-6s]"></div>
            
            <!-- Glass Layer with reduced blur on mobile -->
            <div class="absolute inset-0 backdrop-blur-[50px] sm:backdrop-blur-[100px]"></div>
        </div>

        <!-- Content Container with better padding for mobie -->
        <div class="relative w-full max-w-7xl mx-auto  lg:p-8 ">
            <header class="w-full text-sm mb-6 not-has-[nav]:hidden">
                @if (Route::has('login'))
                    <nav class="flex items-center justify-end gap-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#ffffff] rounded-sm text-6xl leading-normal"
                            >
                                Dashboard
                            </a>
                        @else
                        
                        <a href="{{ route('login') }}" class="group relative w-full sm:w-auto px-6 py-3 min-w-[160px]">
                            <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-cyan-600 rounded-lg"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-cyan-600 rounded-lg blur-lg group-hover:opacity-60 transition-opacity duration-500"></div>
                            <div class="relative flex items-center justify-center gap-2">
                                <span class="text-white font-medium">Iniciar Sesion</span>
                                
                            </div>
                        </a>
        
                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-block px-2 underline underline-offset-4  border-[#19140035] hover:border-[#1915014a] border text-[#ffffff] rounded-sm text-xl leading-normal">
                                    Registrar
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>
            <!-- Main Grid with improved mobile layout -->
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                
                <!-- Left Column - Text Content -->
                <div class="space-y-6 sm:space-y-8 text-center lg:text-left">
                    <!-- Badge - Adjusted for mobile -->
                    <div class="animate-reveal [animation-delay:0.2s] flex justify-center lg:justify-start">
                        <div class="inline-flex items-center px-3 py-1.5 border border-white/10 rounded-full bg-white/5 backdrop-blur-lg transform hover:scale-105 transition-transform">
                            <div class="w-2 h-2 rounded-full bg-violet-500 animate-pulse"></div>
                            <span id="typing-text" class="ml-2 text-xs sm:text-sm text-white/70 tracking-wider"></span>
                        </div>
                    </div>

                    <!-- Main Title - Responsive text sizes -->
                    <div class="animate-reveal [animation-delay:0.4s]">
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold">
                            <span class="inline-block bg-gradient-to-r from-violet-300 via-cyan-300 to-violet-300 bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent">SENACIT</span>
                            <span class="block mt-2 text-white">Plataforma de capacitaciones</span>
                        </h1>
                    </div>

                    <!-- Description - Adjusted line length -->
                    <p class="text-base sm:text-lg text-white/60 max-w-xl mx-auto lg:mx-0 animate-reveal [animation-delay:0.6s]">
                        El Gobierno de la Presidenta Xiomara Castro pone a tu disposición esta plataforma de formación en línea, gratuita y accesible para todos. Aquí podrás aprender nuevas habilidades, fortalecer tu desarrollo personal y profesional, y construir un mejor futuro para ti y para Honduras.
                        ¡Tu crecimiento empieza hoy
                    </p>

                    <!-- CTA Section - Better mobile layout -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 animate-reveal [animation-delay:0.8s]">
                        <!-- Primary Button - Full width on mobile -->
                        <button class="group relative w-full sm:w-auto px-6 py-3 min-w-[160px]">
                            <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-cyan-600 rounded-lg"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-cyan-600 rounded-lg blur-lg group-hover:opacity-60 transition-opacity duration-500"></div>
                            <div class="relative flex items-center justify-center gap-2">
                                <span class="text-white font-medium">Explore Interface</span>
                                <svg class="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </button>

                        <!-- Secondary Button - Full width on mobile -->
                        <a  href="/cursos" class="w-full sm:w-auto px-6 py-3 rounded-lg border border-white/10 bg-white/5 backdrop-blur-lg text-white/70 hover:bg-white/10 hover:text-white transition-all min-w-[160px]">
                            Ver nuestros cursos
                        </a>
                    </div>
                </div>

                <!-- Right Column - Visual Element with better mobile scaling -->
                <div class="relative h-[400px] sm:h-[500px] lg:h-[600px] mt-8 lg:mt-0 animate-reveal [animation-delay:1s]">
            <!-- Morphing Shape Container -->
<div class="absolute inset-0 flex items-center justify-center">
    <div class="relative w-[280px] sm:w-[350px] lg:w-[400px] h-[280px] sm:h-[350px] lg:h-[400px] animate-morph">
        <!-- Glass Card with improved mobile appearance -->
        
        <!-- Floating Elements - Responsive spacing -->
        <div class="absolute inset-4 sm:inset-6 flex flex-col justify-between p-4 sm:p-6">
            <!-- Top Section -->
            <div class="space-y-3 sm:space-y-4">
                <div class="w-8 sm:w-12 h-8 sm:h-12 rounded-full bg-gradient-to-r from-violet-500 to-cyan-500 animate-pulse"></div>
                <div class="h-1.5 sm:h-2 w-20 sm:w-24 bg-white/20 rounded-full"></div>
                <div class="h-1.5 sm:h-2 w-24 sm:w-32 bg-white/10 rounded-full"></div>
            </div>
            
            <!-- Middle Section -->
            <div class="flex justify-between items-center">
                <div class="space-y-2">
                    <div class="h-6 sm:h-8 w-20 sm:w-24 rounded-lg bg-gradient-to-r from-violet-500/20 to-cyan-500/20"></div>
                    <div class="h-1.5 sm:h-2 w-12 sm:w-16 bg-white/20 rounded-full"></div>
                </div>
                <div class="w-12 sm:w-16 h-12 sm:h-16 rounded-full bg-gradient-to-r from-violet-500/30 to-cyan-500/30 animate-float"></div>
            </div>
            
            <!-- Bottom Section -->
            <div class="space-y-2 sm:space-y-3">
                <div class="h-1.5 sm:h-2 w-full bg-white/10 rounded-full"></div>
                <div class="h-1.5 sm:h-2 w-3/4 bg-white/20 rounded-full"></div>
            </div>
        </div>

        <!-- Imagen superpuesta (robot) -->
        <div class="absolute inset-0 flex items-center justify-center z-10 mix-blend-lighten opacity-80 hover:opacity-100 transition-opacity duration-300">
            <img src="img/robot-with-wrench2.png" 
                 alt="Robot" 
                 class=" object-contain animate-float w-full"
                 loading="lazy">
        </div>
    </div>
</div>
            </div>
            </div>
        </div>
    </div>
</body>
<script>
    // Tu JSON con las frases
    const phrases ={
    "messages": [
        "Xiomara impulsa educación digital",
        "Capacitación en línea para todos",
        "Revolución educativa con Xiomara",
        "Honduras aprende en línea",
        "Plataforma educativa del pueblo",
        "Xiomara conecta Honduras al saber",
        "Educación libre y gratuita",
        "Conectados al futuro digital",
        "Capacítate con el gobierno",
        "Saber es poder popular",
        "Honduras crece aprendiendo",
        "Xiomara democratiza el conocimiento",
        "Educación sin fronteras",
        "Tecnología al servicio del pueblo",
        "Aprende desde tu comunidad"
    ]
};

    const typingElement = document.getElementById('typing-text');
    let currentPhrase = 0;
    let currentChar = 0;
    let isDeleting = false;
    let typingSpeed = 100; // Velocidad en ms

    function typeWriter() {
        const fullText = phrases.messages[currentPhrase];
        
        if (isDeleting) {
            // Efecto de borrado
            typingElement.textContent = fullText.substring(0, currentChar - 1);
            currentChar--;
            typingSpeed = 50; // Más rápido al borrar
        } else {
            // Efecto de escritura
            typingElement.textContent = fullText.substring(0, currentChar + 1);
            currentChar++;
            typingSpeed = 100; // Velocidad normal
        }

        // Cambiar entre modos
        if (!isDeleting && currentChar === fullText.length) {
            // Pausa al completar la frase
            typingSpeed = 2000;
            isDeleting = true;
        } else if (isDeleting && currentChar === 0) {
            // Cambiar a la siguiente frase
            isDeleting = false;
            currentPhrase = (currentPhrase + 1) % phrases.messages.length;
            typingSpeed = 500; // Pausa antes de empezar nueva frase
        }

        setTimeout(typeWriter, typingSpeed);
    }

    // Iniciar el efecto cuando la página cargue
    document.addEventListener('DOMContentLoaded', typeWriter);
</script>