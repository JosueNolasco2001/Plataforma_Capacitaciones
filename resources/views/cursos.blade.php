<x-guest-layout>
  <x-navbar/>
  <!-- Fondo con efectos especiales -->
  <div class="fixed inset-0 -z-10 bg-[#0A0A0A]">
      <!-- Gradient Mesh -->
      <div class="absolute inset-0 bg-gradient-to-br from-violet-600/20 via-transparent to-cyan-600/20 opacity-50"></div>
      
      <!-- Animated Shapes -->
      <div class="absolute top-1/4 -left-20 w-[20rem] sm:w-[30rem] lg:w-[40rem] h-[20rem] sm:h-[30rem] lg:h-[40rem] bg-gradient-to-br from-violet-600/30 to-fuchsia-600/30 rounded-full blur-3xl animate-float"></div>
      <div class="absolute bottom-1/4 -right-20 w-[20rem] sm:w-[30rem] lg:w-[40rem] h-[20rem] sm:h-[30rem] lg:h-[40rem] bg-gradient-to-br from-cyan-600/30 to-blue-600/30 rounded-full blur-3xl animate-float [animation-delay:-6s]"></div>
      
      <!-- Glass Layer -->
      <div class="absolute inset-0 backdrop-blur-[20px] sm:backdrop-blur-[30px]"></div>
  </div>

  <section class="text-gray-600 body-font">
      <div class="container px-5 py-10 mx-auto">
        <div class="flex flex-wrap -m-4">
          <!-- Card 1 con animación -->
          <div class="p-4 md:w-1/3 intersect:motion-preset-slide-left">
            <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden bg-white/10 backdrop-blur-sm">
              <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="https://picsum.photos/200/300" alt="blog">
              <div class="p-6">
                <h2 class="tracking-widest text-xs title-font font-medium text-gray-300 mb-1">CATEGORY</h2>
                <h1 class="title-font text-lg font-medium mb-3 text-white intersect:motion-preset-focus">The Catalyzer</h1>
                <p class="leading-relaxed mb-3 text-gray-300 intersect:motion-preset-focus intersect:motion-delay-[200ms]">Photo booth fam kinfolk cold-pressed sriracha leggings jianbing microdosing tousled waistcoat.</p>
                <div class="flex items-center flex-wrap intersect:motion-preset-focus intersect:motion-delay-[400ms]">
                  <a class="text-indigo-400 hover:text-indigo-300 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M5 12h14"></path>
                      <path d="M12 5l7 7-7 7"></path>
                    </svg>
                  </a>
                  <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1 border-r-2 border-gray-600">
                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>1.2K
                  </span>
                  <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                      <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                    </svg>6
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 2 con animación -->
          <div class="p-4 md:w-1/3 intersect:motion-preset-slide-left intersect:motion-delay-[200ms]">
            <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden bg-white/10 backdrop-blur-sm">
              <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="https://picsum.photos/200/302" alt="blog">
              <div class="p-6">
                <h2 class="tracking-widest text-xs title-font font-medium text-gray-300 mb-1">CATEGORY</h2>
                <h1 class="title-font text-lg font-medium text-white mb-3 intersect:motion-preset-focus">The 400 Blows</h1>
                <p class="leading-relaxed mb-3 text-gray-300 intersect:motion-preset-focus intersect:motion-delay-[200ms]">Photo booth fam kinfolk cold-pressed sriracha leggings jianbing microdosing tousled waistcoat.</p>
                <div class="flex items-center flex-wrap intersect:motion-preset-focus intersect:motion-delay-[400ms]">
                  <a class="text-indigo-400 hover:text-indigo-300 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M5 12h14"></path>
                      <path d="M12 5l7 7-7 7"></path>
                    </svg>
                  </a>
                  <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1 border-r-2 border-gray-600">
                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>1.2K
                  </span>
                  <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                      <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                    </svg>6
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 3 con animación -->
          <div class="p-4 md:w-1/3 intersect:motion-preset-slide-left intersect:motion-delay-[400ms]">
            <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden bg-white/10 backdrop-blur-sm">
              <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="https://picsum.photos/200/301" alt="blog">
              <div class="p-6">
                <h2 class="tracking-widest text-xs title-font font-medium text-gray-300 mb-1">CATEGORY</h2>
                <h1 class="title-font text-lg font-medium text-white mb-3 intersect:motion-preset-focus">Shooting Stars</h1>
                <p class="leading-relaxed mb-3 text-gray-300 intersect:motion-preset-focus intersect:motion-delay-[200ms]">Photo booth fam kinfolk cold-pressed sriracha leggings jianbing microdosing tousled waistcoat.</p>
                <div class="flex items-center flex-wrap intersect:motion-preset-focus intersect:motion-delay-[400ms]">
                  <a class="text-indigo-400 hover:text-indigo-300 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M5 12h14"></path>
                      <path d="M12 5l7 7-7 7"></path>
                    </svg>
                  </a>
                  <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1 border-r-2 border-gray-600">
                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>1.2K
                  </span>
                  <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                      <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                    </svg>6
                  </span>
                </div>
              </div>
            </div>
          </div>

          
          <!-- Card 4 con animación -->
          <div class="p-4 md:w-1/3 intersect:motion-preset-slide-left intersect:motion-delay-[600ms]">
            <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden bg-white/10 backdrop-blur-sm">
              <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="https://picsum.photos/200/301" alt="blog">
              <div class="p-6">
                <h2 class="tracking-widest text-xs title-font font-medium text-gray-300 mb-1">CATEGORY</h2>
                <h1 class="title-font text-lg font-medium text-white mb-3 intersect:motion-preset-focus">Shooting Stars</h1>
                <p class="leading-relaxed mb-3 text-gray-300 intersect:motion-preset-focus intersect:motion-delay-[200ms]">Photo booth fam kinfolk cold-pressed sriracha leggings jianbing microdosing tousled waistcoat.</p>
                <div class="flex items-center flex-wrap intersect:motion-preset-focus intersect:motion-delay-[400ms]">
                  <a class="text-indigo-400 hover:text-indigo-300 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M5 12h14"></path>
                      <path d="M12 5l7 7-7 7"></path>
                    </svg>
                  </a>
                  <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1 border-r-2 border-gray-600">
                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>1.2K
                  </span>
                  <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                      <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                    </svg>6
                  </span>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
  </section>
</x-guest-layout>