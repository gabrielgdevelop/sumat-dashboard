<!-- Envoltura global de Alpine para controlar el estado responsivo -->
<div x-data="{ sidebarOpen: true, mobileOpen: false }">

    <!-- HEADER MÓVIL (Solo visible en pantallas pequeñas) -->
    <div class="sm:hidden fixed top-0 left-0 right-0 h-16 bg-[#9cb2bb] flex items-center justify-between px-4 z-40 shadow-md">
        <div class="flex items-center gap-2">
            <x-application-logo class="h-8 w-auto fill-current text-gray-200" />
            <span class="font-bold text-white text-lg tracking-wide">SUMAT</span>
        </div>
        <button @click="mobileOpen = true" class="text-white hover:text-gray-200 focus:outline-none p-2">
            <span class="material-symbols-outlined text-3xl">menu</span>
        </button>
    </div>

    <!-- OVERLAY MÓVIL (Fondo oscuro al abrir el menú) -->
    <div x-show="mobileOpen" 
         @click="mobileOpen = false"
         x-transition.opacity
         class="fixed inset-0 bg-black/60 z-40 sm:hidden" x-cloak></div>

    <!-- SIDEBAR PRINCIPAL -->
    <nav class="bg-[#9cb2bb] border-r border-gray-300 dark:border-gray-700 h-screen fixed inset-y-0 left-0 z-50 transition-all duration-300 flex flex-col justify-between sm:translate-x-0"
         :class="[
            mobileOpen ? 'translate-x-0 w-64' : '-translate-x-full',
            sidebarOpen ? 'sm:w-64' : 'sm:w-20'
         ]">
        
        <!-- Botón de cerrar (Solo Móvil) -->
        <button @click="mobileOpen = false" class="sm:hidden absolute top-4 right-4 text-white hover:text-gray-200">
            <span class="material-symbols-outlined">close</span>
        </button>

        <!-- Botón colapsar (Solo Escritorio) -->
        <button @click="sidebarOpen = !sidebarOpen" 
                class="hidden sm:flex absolute -right-3 top-6 bg-cobalto text-white rounded-full p-2 shadow-md hover:bg-opacity-90 focus:outline-none transition-transform duration-300"
                :class="sidebarOpen ? '' : 'rotate-180'">
            <span class="material-symbols-outlined text-sm">chevron_left</span>
        </button>

        <div class="flex flex-col items-center pt-12 sm:pt-6 w-full px-4 overflow-y-auto">
            <div class="shrink-0 hidden sm:flex items-center justify-center mb-8 h-12">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-200" />
                </a>
            </div>

            <div class="flex flex-col gap-2 w-full">
                <x-nav-link :href="route('contribuyentes.admin.index')" :active="request()->routeIs('contribuyentes.admin.index')" 
                    class="flex items-center gap-4 px-3 py-3 rounded-lg text-gray-200 hover:bg-white/10 transition-colors w-full {{ request()->routeIs('contribuyentes.admin.index') ? 'bg-white/20 font-semibold text-white' : '' }}">
                    <span class="material-symbols-outlined min-w-[24px]">group</span>
                    <span x-show="sidebarOpen || mobileOpen" x-transition.opacity class="text-sm truncate">Contribuyentes</span>
                </x-nav-link>

                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                    class="flex items-center gap-4 px-3 py-3 rounded-lg text-gray-200 hover:bg-white/10 transition-colors w-full {{ request()->routeIs('dashboard') ? 'bg-white/20 font-semibold text-white' : '' }}">
                    <span class="material-symbols-outlined min-w-[24px]">calendar_today</span>
                    <span x-show="sidebarOpen || mobileOpen" x-transition.opacity class="text-sm truncate">Solicitudes</span>
                </x-nav-link>
                
                <x-nav-link :href="route('contribuyentes.aceptados')" :active="request()->routeIs('contribuyentes.aceptados')" 
                    class="flex items-center gap-4 px-3 py-3 rounded-lg text-gray-200 hover:bg-white/10 transition-colors w-full {{ request()->routeIs('contribuyentes.aceptados') ? 'bg-white/20 font-semibold text-white' : '' }}">
                    <span class="material-symbols-outlined min-w-[24px]">theater_comedy</span>
                    <span x-show="sidebarOpen || mobileOpen" x-transition.opacity class="text-sm truncate">Eventos Aceptados</span>
                </x-nav-link>

                <x-nav-link :href="route('calendario.index')" :active="request()->routeIs('calendario.index')" 
                    class="flex items-center gap-4 px-3 py-3 rounded-lg text-gray-200 hover:bg-white/10 transition-colors w-full {{ request()->routeIs('calendario.index') ? 'bg-white/20 font-semibold text-white' : '' }}">
                    <span class="material-symbols-outlined min-w-[24px]">calendar_month</span>
                    <span x-show="sidebarOpen || mobileOpen" x-transition.opacity class="text-sm truncate">Calendario</span>
                </x-nav-link>
                
                <x-nav-link :href="route('contribuyentes.dashboard')" :active="request()->routeIs('contribuyentes.dashboard')" 
                    class="flex items-center gap-4 px-3 py-3 rounded-lg text-gray-200 hover:bg-white/10 transition-colors w-full {{ request()->routeIs('contribuyentes.dashboard') ? 'bg-white/20 font-semibold text-white' : '' }}">
                    <span class="material-symbols-outlined min-w-[24px]">monitoring</span>
                    <span x-show="sidebarOpen || mobileOpen" x-transition.opacity class="text-sm truncate">Eventos Métricas</span>
                </x-nav-link>
            </div>
        </div>

        <div class="p-4 border-t border-white/20 w-full relative" x-data="{ profileOpen: false }">
            
            <div x-show="profileOpen" 
                 @click.outside="profileOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                 class="absolute bottom-full left-4 right-4 mb-3 bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden z-50 flex flex-col"
                 style="display: none;">
                 
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <span class="material-symbols-outlined text-[18px] text-gray-500">manage_accounts</span>
                    {{ __('Perfil') }}
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="m-0 border-t border-gray-100">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-left text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        {{ __('Cerrar sesión') }}
                    </button>
                </form>
            </div>

            <button @click="profileOpen = !profileOpen" 
                    class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg text-white bg-cobalto hover:bg-opacity-90 focus:outline-none transition-all duration-200 w-full shadow-md">
                <span class="material-symbols-outlined text-[20px]">account_circle</span>
                <div x-show="sidebarOpen || mobileOpen" x-transition.opacity class="font-medium text-sm truncate max-w-[100px]">
                    {{ Auth::user()->name }}
                </div>
                <span x-show="sidebarOpen || mobileOpen" 
                      class="material-symbols-outlined text-[18px] transition-transform duration-300"
                      :class="profileOpen ? 'rotate-180' : ''">arrow_drop_up</span>
            </button>
        </div>
    </nav>
</div>