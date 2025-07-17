




<x-app-layout>
  
    <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16 motion-preset-slide-right ">
       
        <div class="  curso-header text-center py-8 text-white px-4 rounded-lg shadow-lg 
        animate-gradient-intense bg-[length:400%_400%] 
        bg-gradient-to-r from-blue-500 via-purple-500 to-pink-600">
<h1 class="text-4xl md:text-5xl font-bold mb-2 animate-title-pop">
    Domina Arduino desde Cero
</h1>
<p class="text-xl md:text-2xl font-light opacity-90 animate-subtitle-slide">
    Impartido por <span class="font-semibold text-yellow-300 drop-shadow-sm">Josue Nolasco</span> | Especialista en Robótica
</p>
</div>

  
  <p class="text-sm text-white p-4">
    Bienvenido al universo de la robótica, donde la creatividad y la tecnología convergen. Este curso te guiará desde los fundamentos esenciales hasta la construcción y programación de tus propios robots.

    Transformaremos juntos tu interacción con la tecnología.
  </p>
  <div class="flex justify-between mt-3">
    <span class="text-base font-medium text-blue-700 dark:text-white">Transcurso</span>
    <span class="text-sm font-medium text-blue-700 dark:text-white">45%</span>
  </div>

  <div class="w-full bg-gray-200 rounded-full mb-10 h-2.5 dark:bg-gray-700">
    <div 
      class="bg-blue-600 h-2.5 rounded-full animate-progress"
      style="--target-width: 45%"
    ></div>
  </div>
    <!-- Botón de Suscribirse al Curso -->
<div class="flex justify-center mb-8">
    <button class="group relative px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-500/50">
        <!-- Efecto de brillo en hover -->
        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
        
        <!-- Contenido del botón -->
        <div class="relative flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Suscribirse al Curso</span>
            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
        </div>
        
     
    </button>
</div>
  
  <style>
    @keyframes progress {
      from { width: 0%; }
      to { width: var(--target-width); }
    }
    .animate-progress {
      animation: progress 1.5s ease-out forwards;
    }
  </style>
  

      <div class="grid grid-cols-1  sm:grid-cols-3 gap-2">
   
        <a href="{{ route('curso.videos.x') }}" class="group relative block bg-black rounded-lg overflow-hidden">
            <img
              alt=""
              src="https://images.pexels.com/photos/771742/pexels-photo-771742.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
              class="absolute inset-0 h-full w-full rounded-lg object-cover opacity-75 transition-opacity group-hover:opacity-50"
            />
          
            <div class="relative p-4 sm:p-6 lg:p-8">
              <p class="text-sm font-medium tracking-widest text-pink-500 uppercase">VIDEO 1</p>
          
              <p class="text-xl font-bold text-white sm:text-2xl">CONCEPTOS BASICOS DE ROBOTICA</p>
          
              <div class="mt-32 sm:mt-48 lg:mt-64">
                <div
                  class="translate-y-8 transform opacity-0 transition-all group-hover:translate-y-0 group-hover:opacity-100"
                >
                  <p class="text-sm text-white">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Omnis perferendis hic asperiores
                    quibusdam quidem voluptates doloremque reiciendis nostrum harum. Repudiandae?
                  </p>
                </div>
              </div>
            </div>
          </a>
            <a href="#" class="group relative block bg-black rounded-lg overflow-hidden">
            <img
              alt=""
              src="https://images.pexels.com/photos/14653174/pexels-photo-14653174.jpeg"
              class="absolute inset-0 h-full w-full rounded-lg object-cover opacity-75 transition-opacity group-hover:opacity-50"
            />
          
            <div class="relative p-4 sm:p-6 lg:p-8">
              <p class="text-sm font-medium tracking-widest text-pink-500 uppercase">Developer</p>
          
              <p class="text-xl font-bold text-white sm:text-2xl">Tony Wayne</p>
          
              <div class="mt-32 sm:mt-48 lg:mt-64">
                <div
                  class="translate-y-8 transform opacity-0 transition-all group-hover:translate-y-0 group-hover:opacity-100"
                >
                  <p class="text-sm text-white">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Omnis perferendis hic asperiores
                    quibusdam quidem voluptates doloremque reiciendis nostrum harum. Repudiandae?
                  </p>
                </div>
              </div>
            </div>
          </a>
            <a href="#" class="group relative block bg-black rounded-lg overflow-hidden">
            <img
              alt=""
              src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHJvZmlsZXxlbnwwfHwwfHx8MA%3D%3D"
              class="absolute inset-0 h-full w-full rounded-lg object-cover opacity-75 transition-opacity group-hover:opacity-50"
            />
          
            <div class="relative p-4 sm:p-6 lg:p-8">
              <p class="text-sm font-medium tracking-widest text-pink-500 uppercase">Developer</p>
          
              <p class="text-xl font-bold text-white sm:text-2xl">Billu Mao</p>
          
              <div class="mt-32 sm:mt-48 lg:mt-64">
                <div
                  class="translate-y-8 transform opacity-0 transition-all group-hover:translate-y-0 group-hover:opacity-100"
                >
                  <p class="text-sm text-white">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Omnis perferendis hic asperiores
                    quibusdam quidem voluptates doloremque reiciendis nostrum harum. Repudiandae?
                  </p>
                </div>
              </div>
            </div>
          </a>
      </div>
      
x   

 
  </div>
  
  
  </x-app-layout>
  
 