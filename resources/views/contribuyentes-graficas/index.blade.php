<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-cobalto leading-tight">Módulo de Reportes</h2>
        </div>
    </x-slot>

    <section class="reports-page">
        <nav class="report-tabs" aria-label="Tipos de reportes">
            <button type="button" class="report-tab is-active" data-report="month">
                <span class="report-tab-icon" aria-hidden="true">▥</span><span>Permisos por Mes</span>
            </button>
            <button type="button" class="report-tab" data-report="week">
                <span class="report-tab-icon" aria-hidden="true">▦</span><span>Permisos por Semana</span>
            </button>
            <button type="button" class="report-tab" data-report="parish">
                <span class="report-tab-icon" aria-hidden="true">⌖</span><span>Permisos por Parroquia</span>
            </button>
            <button type="button" class="report-tab" data-report="total">
                <span class="report-tab-icon" aria-hidden="true">▤</span><span>Total de Eventos Públicos</span>
            </button>
            <button type="button" class="report-tab" data-report="taxpayer">
                <span class="report-tab-icon" aria-hidden="true">♙</span><span>Eventos por Contribuyente</span>
            </button>
            <button type="button" class="report-tab" data-report="history">
                <span class="report-tab-icon" aria-hidden="true">◷</span><span>Historial del Contribuyente</span>
            </button>
            <button type="button" class="report-tab" data-report="rejected">
                <span class="report-tab-icon" aria-hidden="true">!</span><span>Solicitudes Rechazadas</span>
            </button>
        </nav>

        <section class="report-panel" aria-labelledby="report-title">
            <header class="report-panel-heading">
                <h1 id="report-title">Permisos por Mes</h1>
                <div class="report-filters" id="report-filters">
                    <label class="report-filter" id="year-filter">
                        <span>Año</span>
                        <select id="yearSelect" aria-label="Año del reporte">
                            @forelse ($years as $year)
                                <option value="{{ $year }}" @selected($loop->first)>{{ $year }}</option>
                            @empty
                                <option value="{{ now()->year }}">{{ now()->year }}</option>
                            @endforelse
                        </select>
                    </label>
                    <label class="report-filter is-hidden" id="month-filter">
                        <span>Mes</span>
                        <select id="monthSelect" aria-label="Mes del reporte semanal">
                            @foreach (['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $monthName)
                                <option value="{{ $loop->iteration }}" @selected($loop->iteration === now()->month)>{{ $monthName }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="report-filter is-hidden" id="status-filter">
                        <span>Estado</span>
                        <select id="statusSelect" aria-label="Filtrar por estado">
                            <option value="all">Todos</option>
                            <option value="accepted">Aceptados</option>
                            <option value="rejected">Rechazados</option>
                            <option value="pending">En espera</option>
                        </select>
                    </label>
                    <button class="report-history-back is-hidden" id="history-back" type="button">Volver a contribuyentes</button>
                </div>
            </header>

            <div class="report-print-area" id="report-print-area">
                <div class="institutional-heading" aria-hidden="true">
                    <img src="{{ asset('imgs/encabezado.png') }}" alt="Gobierno Bolivariano de Venezuela y SUMAT">
                </div>
                <h2 class="print-report-title" id="print-report-title">Permisos por Mes</h2>

                <div class="report-content-grid">
                    <div class="report-table-column">
                        <div class="report-table-wrap" id="report-table-wrap">
                            <table class="report-table">
                                <thead id="report-table-head"></thead>
                                <tbody id="report-table-body"></tbody>
                            </table>
                        </div>
                        <div class="report-empty is-hidden" id="report-empty">No hay información sobre esto.</div>
                    </div>
                    <div class="report-chart-column" id="report-chart-column">
                        <div class="report-chart-wrap">
                            <canvas id="chart" aria-label="Gráfica estadística del reporte"></canvas>
                        </div>
                        <button class="report-export" id="export-report" type="button" title="Exportar a PDF" aria-label="Exportar reporte a PDF">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v12m0 0 4-4m-4 4-4-4M5 17v3h14v-3" /></svg>
                            <span>Exportar a PDF</span>
                        </button>
                    </div>
                </div>
                <nav class="report-pagination" id="report-pagination" aria-label="Paginación del reporte"></nav>
            </div>
        </section>
    </section>

    <style>
        .reports-page { max-width: 1440px; margin: 0 auto; padding: 24px 28px 40px; color: #172a3a; }
        .report-tabs { display: flex; gap: 14px; overflow-x: auto; padding: 2px 2px 18px; scrollbar-width: thin; }
        .report-tab { display: flex; align-items: center; gap: 12px; flex: 1 0 205px; min-height: 76px; padding: 12px 16px; border: 1px solid #d5e0e7; border-radius: 8px; background: #fff; box-shadow: 0 2px 5px #163a501c; color: #152b3c; text-align: left; font-size: 15px; font-weight: 600; transition: border-color .16s ease, background .16s ease, transform .16s ease; }
        .report-tab:hover { transform: translateY(-2px); border-color: #5da8c7; }
        .report-tab.is-active { border-color: #3c96b8; background: #e3f3f9; box-shadow: inset 0 0 0 1px #98ccdc, 0 2px 5px #163a501c; }
        .report-tab-icon { display: grid; flex: 0 0 40px; width: 40px; height: 40px; place-items: center; border-radius: 6px; background: #c9eaf4; color: #087ba2; font-size: 24px; font-weight: 700; }
        .report-panel { overflow: hidden; border: 1px solid #d1dce3; border-radius: 9px; background: #fff; box-shadow: 0 3px 9px #163a501c; }
        .report-panel-heading { display: flex; min-height: 60px; align-items: center; justify-content: space-between; gap: 16px; padding: 12px 18px; border-bottom: 1px solid #cbd6dd; }
        .report-panel-heading h1 { margin: 0; color: #172a3a; font-size: 21px; font-weight: 650; }
        .report-filters { display: flex; align-items: center; gap: 10px; }
        .report-filter { display: flex; align-items: center; gap: 8px; color: #526574; font-size: 13px; }
        .report-filter select { max-width: 240px; min-height: 36px; border: 1px solid #c9d6de; border-radius: 5px; background: #fff; padding: 5px 28px 5px 10px; color: #173c54; }
        .report-history-back { min-height: 36px; padding: 5px 10px; border: 1px solid #a9cad9; border-radius: 5px; background: #f5fbfd; color: #086e91; font-size: 13px; font-weight: 600; }
        .is-hidden { display: none !important; }
        .report-print-area { padding: 16px; }
        .institutional-heading { display: none; }
        .print-report-title { display: none; }
        .report-content-grid { display: grid; grid-template-columns: minmax(0, 1.65fr) minmax(300px, .9fr); gap: 20px; align-items: start; }
        .report-table-column { min-width: 0; }
        .report-table-wrap { max-height: 430px; overflow: auto; border: 1px solid #d9e3e8; border-radius: 4px; }
        .report-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .report-table th, .report-table td { min-width: 92px; padding: 10px 12px; border-bottom: 1px solid #d2dce2; text-align: left; vertical-align: middle; }
        .report-table th { position: sticky; top: 0; z-index: 1; background: #d6edf6; color: #1d3443; font-weight: 650; white-space: nowrap; }
        .report-table td:first-child, .report-table th:first-child { min-width: 140px; }
        .report-table tbody tr:nth-child(odd) { background: #e5f4fa; }
        .report-table tbody tr:nth-child(even) { background: #fff; }
        .report-table tbody tr:last-child td { border-bottom: 0; }
        .report-view-link { display: inline-grid; width: 30px; height: 30px; place-items: center; border: 1px solid #a9cad9; border-radius: 5px; color: #087ba2; }
        .report-view-link:hover { background: #d5eff8; }
        .report-history-select { border: 0; background: transparent; padding: 3px 0; color: #087ba2; font-weight: 650; text-decoration: underline; text-underline-offset: 3px; }
        .report-view-link svg, .report-export svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .report-chart-column { min-width: 0; }
        .report-chart-wrap { position: relative; height: 350px; }
        .report-chart-wrap canvas { display: block; width: 100% !important; height: 100% !important; }
        .report-export { display: flex; min-height: 40px; align-items: center; justify-content: center; gap: 8px; margin: 12px auto 0; padding: 8px 14px; border: 1px solid #0a6e91; border-radius: 5px; background: #087fa5; color: #fff; font-size: 14px; font-weight: 600; }
        .report-export:hover { background: #086c8b; }
        .report-pagination { display: flex; justify-content: flex-end; align-items: center; gap: 12px; padding: 12px 2px 0; color: #516574; font-size: 13px; }
        .report-pagination button { min-width: 34px; min-height: 32px; border: 1px solid #c8d6de; border-radius: 4px; background: #fff; color: #1b536e; }
        .report-pagination button:disabled { opacity: .45; }
        .report-empty { padding: 28px 16px; color: #627583; text-align: center; }
        @media (max-width: 850px) {
            .reports-page { padding: 16px 14px 28px; }
            .report-panel-heading { align-items: flex-start; flex-direction: column; }
            .report-content-grid { grid-template-columns: 1fr; }
            .report-chart-wrap { height: 300px; }
            .report-table-wrap { max-height: 380px; }
            .report-filters { width: 100%; flex-wrap: wrap; }
        }
        @media print {
            @page { size: A4 landscape; margin: 10mm; }
            body * { visibility: hidden !important; }
            #report-print-area, #report-print-area * { visibility: visible !important; }
            #report-print-area { position: absolute; inset: 0; width: 100%; padding: 0; }
            .institutional-heading { display: block; margin-bottom: 12px; }
            .institutional-heading img { display: block; width: 100%; max-height: 36mm; object-fit: contain; object-position: left center; }
            .print-report-title { display: block; margin: 0 0 10px; color: #172a3a; font-size: 15px; font-weight: 700; }
            .report-content-grid { grid-template-columns: minmax(0, 1.7fr) minmax(250px, .9fr); gap: 14px; }
            .report-table-wrap { max-height: none; overflow: visible; border: 0; }
            .report-table { font-size: 10px; }
            .report-table th, .report-table td { min-width: 0; padding: 6px; }
            .report-table th { position: static; }
            .report-chart-wrap { height: 330px; }
            .report-pagination, .report-export, .report-view-link { display: none !important; }
            .report-table tbody tr { break-inside: avoid; }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/js/contribuyentes-graficas/index.js'])
</x-app-layout>