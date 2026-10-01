<!-- NAV CONTENEDOR PRINCIPAL -->
<nav class="fixed top-0 left-0 h-screen bg-white shadow-[0_0_15px_rgba(0,0,0,0.05)] transition-all duration-500 z-50 py-2.5 px-3.5 flex flex-col"
     :class="sidebarOpen ? 'w-[250px]' : 'w-[88px]'">

    <!-- HEADER / LOGO -->
    <header class="relative flex items-center h-14 mt-2">
        <div class="flex items-center gap-3 w-full overflow-hidden">
            <!-- Contenedor de la imagen: Restringe el ancho y centra -->
            <span class="min-w-[60px] flex justify-center items-center shrink-0 transition-all duration-500">
                <img src="{{ asset('imgs/logo-sumat.jpeg') }}" alt="Logo" 
                     class="object-contain transition-all duration-500"
                     :class="sidebarOpen ? 'w-10 h-10' : 'w-8 h-8'">
            </span>
            
            <div class="flex flex-col transition-all duration-300 whitespace-nowrap"
                 :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">
                <span class="font-semibold text-[18px] text-[#707070] mt-0.5">SUMAT</span>
                <span class="font-medium text-[14px] text-[#707070] -mt-1 block">Panel Principal</span>
            </div>
        </div>

        <!-- Botón Toggle Circular -->
        <div @click="sidebarOpen = !sidebarOpen" 
             class="absolute top-1/2 -right-[26px] -translate-y-1/2 w-[25px] h-[25px] bg-[#695CFE] text-white rounded-full flex items-center justify-center text-[22px] cursor-pointer transition-transform duration-500 z-50"
             :class="sidebarOpen ? 'rotate-180' : 'rotate-0'">
            <i class='bx bx-chevron-right'></i>
        </div>
    </header>

    <!-- MENÚ Y SCROLL (Aquí inicializamos la variable search para el buscador) -->
    <div class="mt-10 flex flex-col justify-between h-[calc(100%-55px)] menu-bar overflow-y-auto" x-data="{ search: '' }">
        <ul class="flex flex-col gap-2 m-0 p-0">
            
            <!-- Buscador -->
            <li class="h-[50px] bg-[#F6F5FF] rounded-md flex items-center transition-all duration-500 cursor-pointer mb-2"
                @click="sidebarOpen = true">
                <i class="bx bx-search min-w-[60px] flex justify-center text-[20px] text-[#707070]"></i>
                <input type="text" placeholder="Buscar..." 
                       x-model="search"
                       class="w-full h-full bg-transparent border-none outline-none text-[#707070] font-medium text-[16px] focus:ring-0 px-0"
                       x-show="sidebarOpen">
            </li>

            <!-- Link: Contribuyentes (MOVIDO DE PRIMERO) -->
            <li class="h-[50px] flex items-center group"
                x-show="search === '' || $el.textContent.toLowerCase().includes(search.toLowerCase())">
                <a href="{{ route('contribuyentes.admin.index') }}" 
                   class="flex items-center w-full h-full rounded-md transition-all duration-300 {{ request()->routeIs('contribuyentes.admin.index') ? 'bg-[#695CFE] text-white' : 'text-[#707070] hover:bg-[#695CFE] hover:text-white' }}">
                    <i class="bx bx-group min-w-[60px] flex justify-center text-[20px] transition-all duration-300"></i>
                    <span class="font-medium text-[16px] transition-all duration-300 whitespace-nowrap overflow-hidden"
                          :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">Contribuyentes</span>
                </a>
            </li>

            <!-- Link: Solicitudes -->
            <li class="h-[50px] flex items-center group" 
                x-show="search === '' || $el.textContent.toLowerCase().includes(search.toLowerCase())">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center w-full h-full rounded-md transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-[#695CFE] text-white' : 'text-[#707070] hover:bg-[#695CFE] hover:text-white' }}">
                    <i class="bx bx-calendar-event min-w-[60px] flex justify-center text-[20px] transition-all duration-300"></i>
                    <span class="font-medium text-[16px] transition-all duration-300 whitespace-nowrap overflow-hidden"
                          :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">Solicitudes</span>
                </a>
            </li>

            <!-- Link: Eventos Aceptados -->
            <li class="h-[50px] flex items-center group"
                x-show="search === '' || $el.textContent.toLowerCase().includes(search.toLowerCase())">
                <a href="{{ route('contribuyentes.aceptados') }}" 
                   class="flex items-center w-full h-full rounded-md transition-all duration-300 {{ request()->routeIs('contribuyentes.aceptados') ? 'bg-[#695CFE] text-white' : 'text-[#707070] hover:bg-[#695CFE] hover:text-white' }}">
                    <i class="bx bx-check-square min-w-[60px] flex justify-center text-[20px] transition-all duration-300"></i>
                    <span class="font-medium text-[16px] transition-all duration-300 whitespace-nowrap overflow-hidden"
                          :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">Eventos Aceptados</span>
                </a>
            </li>

            <!-- Link: Eventos Métricas (Reportes) -->
            <li class="h-[50px] flex items-center group"
                x-show="search === '' || $el.textContent.toLowerCase().includes(search.toLowerCase())">
                <a href="{{ route('contribuyentes.dashboard') }}" 
                   class="flex items-center w-full h-full rounded-md transition-all duration-300 {{ request()->routeIs('contribuyentes.dashboard') ? 'bg-[#695CFE] text-white' : 'text-[#707070] hover:bg-[#695CFE] hover:text-white' }}">
                    <i class="bx bx-line-chart min-w-[60px] flex justify-center text-[20px] transition-all duration-300"></i>
                    <span class="font-medium text-[16px] transition-all duration-300 whitespace-nowrap overflow-hidden"
                          :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">Eventos Métricas</span>
                </a>
            </li>
        </ul>

        <!-- CONTENIDO INFERIOR -->
        <div class="mt-4 border-t border-gray-100 pt-3">
            <ul class="m-0 p-0">
                <!-- Perfil -->
                <li class="h-[50px] flex items-center group mb-1">
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center w-full h-full rounded-md transition-all duration-300 text-[#707070] hover:bg-[#695CFE] hover:text-white">
                        <i class="bx bx-user-circle min-w-[60px] flex justify-center text-[20px] transition-all duration-300"></i>
                        <span class="font-medium text-[16px] transition-all duration-300 whitespace-nowrap overflow-hidden"
                              :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">Mi Perfil</span>
                    </a>
                </li>

                <!-- Cerrar Sesión -->
                <li class="h-[50px] flex items-center group mb-3">
                    <form method="POST" action="{{ route('logout') }}" class="w-full h-full m-0">
                        @csrf
                        <button type="submit" class="flex items-center w-full h-full rounded-md transition-all duration-300 text-[#707070] hover:bg-[#695CFE] hover:text-white">
                            <i class="bx bx-log-out min-w-[60px] flex justify-center text-[20px] transition-all duration-300"></i>
                            <span class="font-medium text-[16px] transition-all duration-300 whitespace-nowrap overflow-hidden text-left"
                                  :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">Cerrar Sesión</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>