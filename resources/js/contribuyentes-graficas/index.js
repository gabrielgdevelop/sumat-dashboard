"use strict";

const reportButtons = [...document.querySelectorAll('[data-report]')];
const title = document.getElementById('report-title');
const printTitle = document.getElementById('print-report-title');
const yearSelect = document.getElementById('yearSelect');
const monthSelect = document.getElementById('monthSelect');
const statusSelect = document.getElementById('statusSelect');
const historyBack = document.getElementById('history-back');
const yearFilter = document.getElementById('year-filter');
const monthFilter = document.getElementById('month-filter');
const statusFilter = document.getElementById('status-filter');
const tableHead = document.getElementById('report-table-head');
const tableBody = document.getElementById('report-table-body');
const tableWrap = document.getElementById('report-table-wrap');
const emptyMessage = document.getElementById('report-empty');
const chartColumn = document.getElementById('report-chart-column');
const pagination = document.getElementById('report-pagination');
const reportPanel = document.querySelector('.report-panel');
const pageSize = 10;
let activeReport = 'month';
let selectedContributorId = '';
let currentPage = 1;
let reportRows = [];
let chart;
let activeRequest;

const reportTitles = {
    month: 'Permisos por Mes',
    week: 'Permisos por Semana',
    parish: 'Permisos por Parroquia',
    total: 'Total de Eventos Públicos',
    taxpayer: 'Total de Eventos por Contribuyente',
    history: 'Historial del Contribuyente',
    rejected: 'Solicitudes Rechazadas',
};

const columns = {
    month: [['label', 'Mes'], ['accepted', 'Aprobados'], ['pending', 'En espera'], ['rejected', 'Rechazados'], ['total', 'Total'], ['action', 'Ver']],
    week: [['label', 'Semana'], ['accepted', 'Aprobados'], ['pending', 'En espera'], ['rejected', 'Rechazados'], ['total', 'Total'], ['action', 'Ver']],
    parish: [['label', 'Parroquia'], ['accepted', 'Aprobados'], ['pending', 'En espera'], ['rejected', 'Rechazados'], ['total', 'Total']],
    total: [['label', 'Concepto'], ['total', 'Eventos']],
    taxpayer: [['label', 'Contribuyente'], ['total', 'Eventos']],
    history: [['label', 'Contribuyente'], ['total', 'Eventos'], ['select-history', 'Historial']],
    historyEvents: [['label', 'Evento'], ['date', 'Fecha'], ['parroquia', 'Parroquia'], ['status', 'Estado'], ['action', 'Ver']],
    rejected: [['label', 'Evento'], ['date', 'Fecha'], ['contribuyente', 'Contribuyente'], ['parroquia', 'Parroquia'], ['reason', 'Motivo']],
};

const chartColors = {
    accepted: '#83c9e2',
    pending: '#42a7cc',
    rejected: '#17618b',
    total: '#1887b2',
};

function makeCell(value, tag = 'td') {
    const cell = document.createElement(tag);
    cell.textContent = value ?? '';
    return cell;
}

function makeViewLink(url) {
    const link = document.createElement('a');
    link.className = 'report-view-link';
    link.href = url;
    link.title = 'Ver solicitud';
    link.setAttribute('aria-label', 'Ver solicitud');
    link.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"/><circle cx="12" cy="12" r="2.5"/></svg>';
    return link;
}

function renderTable() {
    const start = (currentPage - 1) * pageSize;
    const pageRows = reportRows.slice(start, start + pageSize);
    const visibleColumns = activeReport === 'history' && selectedContributorId ? columns.historyEvents : columns[activeReport];
    tableBody.replaceChildren();
    const headingRow = document.createElement('tr');
    visibleColumns.forEach(([, label]) => headingRow.append(makeCell(label, 'th')));
    tableHead.replaceChildren(headingRow);
    pageRows.forEach((row) => {
        const tableRow = document.createElement('tr');
        visibleColumns.forEach(([key]) => {
            if (key === 'action') {
                const cell = document.createElement('td');
                if (row.url) cell.append(makeViewLink(row.url));
                tableRow.append(cell);
            } else if (key === 'select-history') {
                const cell = document.createElement('td');
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'report-history-select';
                button.textContent = 'Ver historial';
                button.addEventListener('click', () => {
                    selectedContributorId = row.id;
                    historyBack.classList.remove('is-hidden');
                    loadReport();
                });
                cell.append(button);
                tableRow.append(cell);
            } else {
                tableRow.append(makeCell(key === 'date' && row[key] ? new Date(`${row[key]}T00:00:00`).toLocaleDateString('es-VE') : row[key]));
            }
        });
        tableBody.append(tableRow);
    });

    emptyMessage.classList.toggle('is-hidden', reportRows.length > 0);
    tableWrap.classList.toggle('is-hidden', reportRows.length === 0);
    renderPagination();
}

function renderPagination() {
    pagination.replaceChildren();
    const pageCount = Math.ceil(reportRows.length / pageSize);
    pagination.classList.toggle('is-hidden', pageCount <= 1);
    if (pageCount <= 1) return;

    const previous = document.createElement('button');
    previous.type = 'button';
    previous.textContent = 'Anterior';
    previous.disabled = currentPage === 1;
    previous.addEventListener('click', () => changePage(currentPage - 1));

    const pageLabel = document.createElement('span');
    pageLabel.textContent = `Página ${currentPage} de ${pageCount}`;

    const next = document.createElement('button');
    next.type = 'button';
    next.textContent = 'Siguiente';
    next.disabled = currentPage === pageCount;
    next.addEventListener('click', () => changePage(currentPage + 1));
    pagination.append(previous, pageLabel, next);
}

function changePage(page) {
    currentPage = page;
    renderTable();
    tableWrap.scrollTop = 0;
}

function renderChart(chartRows) {
    const context = document.getElementById('chart').getContext('2d');
    const labels = chartRows.map((row) => row.label);
    const hasStatusSeries = activeReport === 'parish';
    const datasets = hasStatusSeries
        ? [
            ['accepted', 'Aprobados'],
            ['pending', 'En espera'],
            ['rejected', 'Rechazados'],
        ].map(([key, label]) => ({
            label,
            data: chartRows.map((row) => row[key] ?? 0),
            backgroundColor: chartColors[key],
            borderRadius: 2,
        }))
        : [{
            label: activeReport === 'total' || activeReport === 'history' ? 'Solicitudes' : 'Eventos',
            data: chartRows.map((row) => row.total ?? 0),
            backgroundColor: chartColors.total,
            borderRadius: 2,
        }];

    if (chart) chart.destroy();
    chart = new Chart(context, {
        type: 'bar',
        data: { labels, datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: activeReport === 'parish' || activeReport === 'taxpayer' || activeReport === 'rejected' ? 'y' : 'x',
            plugins: {
                legend: { display: hasStatusSeries, position: 'top', labels: { usePointStyle: true, boxWidth: 9, color: '#294252' } },
                title: { display: false },
            },
            scales: {
                x: { beginAtZero: true, ticks: { precision: 0, color: '#526574' }, grid: { color: '#e1e8ec' } },
                y: { beginAtZero: true, ticks: { precision: 0, color: '#526574' }, grid: { color: '#e1e8ec' } },
            },
        },
    });
}

async function loadReport() {
    activeRequest?.abort();
    const request = new AbortController();
    activeRequest = request;
    const params = new URLSearchParams({ report: activeReport });
    if (activeReport !== 'history') params.set('year', yearSelect.value);
    if (activeReport === 'week') params.set('month', monthSelect.value);
    if (activeReport === 'month' || activeReport === 'week') params.set('status', statusSelect.value);
    if (activeReport === 'history' && selectedContributorId) params.set('contribuyente_id', selectedContributorId);

    try {
        reportPanel.setAttribute('aria-busy', 'true');
        const response = await fetch(`/reportes/datos?${params.toString()}`, {
            headers: { Accept: 'application/json' },
            signal: request.signal,
        });
        if (!response.ok) throw new Error('No fue posible obtener el reporte.');

        const result = await response.json();
        const hasData = result.rows.length > 0 && !(activeReport === 'total' && Number(result.rows[0].total) === 0);
        reportRows = hasData ? result.rows : [];
        currentPage = 1;
        emptyMessage.textContent = 'No hay información sobre esto';
        title.textContent = result.title;
        printTitle.textContent = result.title;
        renderTable();
        chartColumn.classList.toggle('is-hidden', !hasData);
        renderChart(hasData ? result.chart : []);
    } catch (error) {
        if (error.name === 'AbortError') return;
        reportRows = [];
        renderTable();
        chartColumn.classList.add('is-hidden');
        renderChart([]);
        emptyMessage.textContent = 'No fue posible cargar el reporte.';
        title.textContent = reportTitles[activeReport];
        printTitle.textContent = reportTitles[activeReport];
        console.error(error);
    } finally {
        if (activeRequest === request) {
            activeRequest = null;
            reportPanel.removeAttribute('aria-busy');
        }
    }
}

function selectReport(report) {
    activeReport = report;
    reportButtons.forEach((button) => {
        const isActive = button.dataset.report === report;
        button.classList.toggle('is-active', isActive);
        button.setAttribute('aria-pressed', String(isActive));
    });
    yearFilter.classList.toggle('is-hidden', report === 'history');
    monthFilter.classList.toggle('is-hidden', report !== 'week');
    statusFilter.classList.toggle('is-hidden', report !== 'month' && report !== 'week');
    selectedContributorId = '';
    historyBack.classList.add('is-hidden');
    title.textContent = reportTitles[report];
    printTitle.textContent = reportTitles[report];
    loadReport();
}

reportButtons.forEach((button) => button.addEventListener('click', () => selectReport(button.dataset.report)));
yearSelect.addEventListener('change', loadReport);
monthSelect.addEventListener('change', loadReport);
statusSelect.addEventListener('change', loadReport);
historyBack.addEventListener('click', () => {
    selectedContributorId = '';
    historyBack.classList.add('is-hidden');
    loadReport();
});
document.getElementById('export-report').addEventListener('click', () => window.print());

selectReport(activeReport);