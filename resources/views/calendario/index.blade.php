<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cobalto leading-tight">
            {{ __('Calendario de Eventos Aprobados') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                
                <!-- Contenedor del Calendario -->
                <div id="calendar" class="w-full min-h-[650px]"></div>
                
            </div>
        </div>

        <!-- Modal de Evento para FullCalendar -->
        <div id="eventModal" class="fixed inset-0 z-50 hidden flex-col items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-100 transition-transform">
                <div class="flex justify-between items-center p-5 border-b bg-gray-50">
                    <h3 id="modalTitle" class="font-bold text-xl text-gray-800"></h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 bg-white space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="font-semibold text-gray-700 min-w-[90px]">Inicio:</span>
                        <span id="modalStart" class="text-gray-600"></span>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="font-semibold text-gray-700 min-w-[90px]">Fin:</span>
                        <span id="modalEnd" class="text-gray-600"></span>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="font-semibold text-gray-700 min-w-[90px]">Ubicación:</span>
                        <span id="modalDesc" class="text-gray-600"></span>
                    </div>
                </div>
                <div class="p-4 border-t bg-gray-50 flex justify-end">
                    <button onclick="closeModal()" class="px-5 py-2 bg-cobalto text-white rounded-md font-medium hover:bg-opacity-90 transition">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var eventos = @json($eventos);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                events: eventos,
                eventClick: function(info) {
                    document.getElementById('modalTitle').innerText = info.event.title;
                    
                    // Formateamos las fechas a formato legible
                    const options = { dateStyle: 'long', timeStyle: 'short' };
                    document.getElementById('modalStart').innerText = info.event.start.toLocaleString('es-ES', options);
                    document.getElementById('modalEnd').innerText = info.event.end ? info.event.end.toLocaleString('es-ES', options) : 'No especificada';
                    
                    document.getElementById('modalDesc').innerText = info.event.extendedProps.description 
                        ? info.event.extendedProps.description.replace('Ubicación: ', '') 
                        : 'No especificada';

                    // Mostramos el modal
                    document.getElementById('eventModal').classList.remove('hidden');
                    document.getElementById('eventModal').classList.add('flex');
                }
            });
            calendar.render();
        });

        // Función global para cerrar el modal
        window.closeModal = function() {
            document.getElementById('eventModal').classList.add('hidden');
            document.getElementById('eventModal').classList.remove('flex');
        };
    </script>
    <style>
        .fc .fc-button-primary { background-color: #695CFE; border-color: #695CFE; }
        .fc .fc-button-primary:hover { background-color: #5548c8; border-color: #5548c8; }
        .fc-theme-standard td, .fc-theme-standard th { border-color: #e5e7eb; }
    </style>
</x-app-layout>