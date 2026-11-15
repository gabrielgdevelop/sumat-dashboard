<?php

namespace App\Http\Controllers;

use App\Models\Contribuyente;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


class ContribuyentesGraficas extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $yearExpression = match (DB::connection()->getDriverName()) {
            'sqlite' => "strftime('%Y', fecha_evento)",
            'mysql' => 'YEAR(fecha_evento)',
            default => 'EXTRACT(YEAR FROM fecha_evento)',
        };
        $years = Evento::query()
            ->whereNotNull('fecha_evento')
            ->selectRaw("$yearExpression as year")
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('contribuyentes-graficas.index', compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contribuyente $contribuyente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contribuyente $contribuyente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contribuyente $contribuyente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribuyente $contribuyente)
    {
        //
    }

    public function graficaPorYear(Request $request)
    {
        $filters = $request->validate([
            'report' => ['required', Rule::in(['month', 'week', 'parish', 'total', 'taxpayer', 'history', 'rejected'])],
            'year' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'month' => ['required_if:report,week', 'integer', 'between:1,12'],
            'status' => ['nullable', Rule::in(['all', 'accepted', 'rejected', 'pending'])],
            'contribuyente_id' => ['nullable', 'integer', 'exists:contribuyentes,id'],
        ]);

        $report = $filters['report'];
        $status = $filters['status'] ?? 'all';
        $year = $filters['year'] ?? now()->year;
        $events = Evento::query()
            ->with(['estado', 'parroquia', 'contribuyente'])
            ->when($report !== 'history', fn ($query) => $query->whereYear('fecha_evento', $year))
            ->when($report === 'week', fn ($query) => $query->whereMonth('fecha_evento', $filters['month']))
            ->when($report === 'history', function ($query) use ($filters) {
                if (!empty($filters['contribuyente_id'])) {
                    $query->where('contribuyente_id', $filters['contribuyente_id']);
                } else {
                    $query->whereRaw('1 = 0');
                }
            })
            ->when($report === 'rejected', fn ($query) => $query->whereHas('estado', fn ($states) => $states->whereRaw('LOWER(nombre) = ?', ['rechazado'])))
            ->when(in_array($report, ['month', 'week'], true) && $status !== 'all', function ($query) use ($status) {
                $stateNames = match ($status) {
                    'accepted' => ['aceptado', 'aprobado'],
                    'rejected' => ['rechazado'],
                    'pending' => ['pendiente', 'en espera', 'en_espera'],
                };
                $placeholders = implode(', ', array_fill(0, count($stateNames), '?'));

                $query->whereHas('estado', fn ($states) => $states->whereRaw("LOWER(nombre) IN ($placeholders)", $stateNames));
            })
            ->orderByDesc('fecha_evento')
            ->orderByDesc('id')
            ->get();
        $historyContribuyentes = $report === 'history' && empty($filters['contribuyente_id'])
            ? Contribuyente::query()->withCount('eventos')->orderBy('nombre')->orderBy('apellido')->get()
            : collect();

        $rows = match ($report) {
            'month' => $this->temporalRows($events, 'month'),
            'week' => $this->temporalRows($events, 'week'),
            'parish' => $this->groupedRows($events, fn ($event) => $event->parroquia?->nombre ?? 'Sin parroquia', 'parroquia'),
            'total' => [['label' => 'Eventos públicos', 'total' => $events->count()]],
            'taxpayer' => $this->groupedRows($events, fn ($event) => trim(($event->contribuyente?->nombre ?? '').' '.($event->contribuyente?->apellido ?? '')) ?: 'Sin contribuyente', 'contribuyente'),
            'history' => !empty($filters['contribuyente_id'])
                ? $events->map(fn ($event) => $this->eventRow($event))->values()
                : $historyContribuyentes->map(fn ($contribuyente) => [
                    'id' => $contribuyente->id,
                    'label' => trim($contribuyente->nombre.' '.$contribuyente->apellido),
                    'total' => $contribuyente->eventos_count,
                ])->values(),
            'rejected' => $events->map(fn ($event) => $this->eventRow($event, true))->values(),
            default => $this->statusRows($events),
        };

        $chart = match ($report) {
            'month', 'week', 'total', 'taxpayer' => $this->chartRows($rows),
            'parish' => $this->chartStatusRows($events, fn ($event) => $event->parroquia?->nombre ?? 'Sin parroquia'),
            'rejected' => $this->chartRows($this->groupedRows($events, fn ($event) => $event->motivo_rechazo ?: 'Sin motivo indicado', 'motivo')),
            'history' => empty($filters['contribuyente_id']) ? $this->chartRows($rows) : $this->countByStatus($events),
            default => $this->countByStatus($events),
        };

        return response()->json([
            'rows' => $rows,
            'chart' => $chart,
            'title' => $this->reportTitle($report),
        ]);
    }

    private function temporalRows($events, string $period)
    {
        $groups = $events->filter(fn ($event) => $event->fecha_evento)->groupBy(function ($event) use ($period) {
            $date = Carbon::parse($event->fecha_evento);

            return $period === 'month' ? $date->format('Y-m') : $date->format('o-\\WW');
        });
        $months = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

        return $groups->map(function ($items, $key) use ($period, $months) {
            $date = Carbon::parse($items->first()->fecha_evento);
            $eligibleEvent = $items->first(fn ($event) => !$this->isRejected($event));

            return [
                'label' => $period === 'month' ? ucfirst($months[$date->month - 1]).' '.$date->year : 'Semana '.$date->isoWeek().' de '.$date->isoWeekYear(),
                'total' => $items->count(),
                'accepted' => $items->filter(fn ($event) => $this->isAccepted($event))->count(),
                'pending' => $items->filter(fn ($event) => $this->isPending($event))->count(),
                'rejected' => $items->filter(fn ($event) => $this->isRejected($event))->count(),
                'date' => $date->toDateString(),
                'url' => $eligibleEvent ? route('contribuyentes.show', $eligibleEvent->id) : null,
                'sort' => $key,
            ];
        })->sortByDesc('sort')->values();
    }

    private function groupedRows($events, callable $label, string $key)
    {
        return $events->groupBy($label)->map(function ($items, $name) use ($key) {
            return [
                'label' => $name,
                $key => $name,
                'total' => $items->count(),
                'accepted' => $items->filter(fn ($event) => $this->isAccepted($event))->count(),
                'pending' => $items->filter(fn ($event) => $this->isPending($event))->count(),
                'rejected' => $items->filter(fn ($event) => $this->isRejected($event))->count(),
            ];
        })->sortByDesc('total')->values();
    }

    private function eventRow(Evento $event, bool $includeReason = false): array
    {
        $row = [
            'label' => $event->ubicacion_evento ?: 'Evento sin ubicación',
            'date' => $event->fecha_evento,
            'contribuyente' => trim(($event->contribuyente?->nombre ?? '').' '.($event->contribuyente?->apellido ?? '')) ?: 'Sin contribuyente',
            'parroquia' => $event->parroquia?->nombre ?? 'Sin parroquia',
            'status' => $event->estado?->nombre ?? 'Sin estado',
            'url' => $this->isRejected($event) ? null : route('contribuyentes.show', $event->id),
        ];

        if ($includeReason) {
            $row['reason'] = $event->motivo_rechazo ?: 'Sin motivo indicado';
        }

        return $row;
    }

    private function statusRows($events)
    {
        return $this->countByStatus($events)->map(fn ($item) => [
            'label' => $item['label'],
            'total' => $item['total'],
        ])->values();
    }

    private function countByStatus($events): array
    {
        return collect(['Aceptados', 'Pendientes', 'Rechazados'])->map(function ($label) use ($events) {
            $predicate = match ($label) {
                'Aceptados' => fn ($event) => $this->isAccepted($event),
                'Pendientes' => fn ($event) => $this->isPending($event),
                default => fn ($event) => $this->isRejected($event),
            };

            return ['label' => $label, 'total' => $events->filter($predicate)->count()];
        })->all();
    }

    private function chartRows($rows): array
    {
        return collect($rows)->map(fn ($row) => [
            'label' => $row['label'],
            'total' => $row['total'],
        ])->values()->all();
    }

    private function chartStatusRows($events, callable $label): array
    {
        return $events->groupBy($label)->map(function ($items, $name) {
            return [
                'label' => $name,
                'accepted' => $items->filter(fn ($event) => $this->isAccepted($event))->count(),
                'pending' => $items->filter(fn ($event) => $this->isPending($event))->count(),
                'rejected' => $items->filter(fn ($event) => $this->isRejected($event))->count(),
            ];
        })->values()->all();
    }

    private function isAccepted(Evento $event): bool
    {
        return in_array(mb_strtolower($event->estado?->nombre ?? ''), ['aceptado', 'aprobado'], true);
    }

    private function isPending(Evento $event): bool
    {
        return in_array(mb_strtolower($event->estado?->nombre ?? ''), ['pendiente', 'en espera', 'en_espera'], true);
    }

    private function isRejected(Evento $event): bool
    {
        return mb_strtolower($event->estado?->nombre ?? '') === 'rechazado';
    }

    private function reportTitle(string $report): string
    {
        return [
            'month' => 'Permisos por Mes',
            'week' => 'Permisos por Semana',
            'parish' => 'Permisos por Parroquia',
            'total' => 'Total de Eventos Públicos',
            'taxpayer' => 'Total de Eventos por Contribuyente',
            'history' => 'Historial del Contribuyente',
            'rejected' => 'Solicitudes Rechazadas',
        ][$report];
    }
}
