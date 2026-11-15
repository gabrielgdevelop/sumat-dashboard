<?php

use App\Models\Contribuyente;
use App\Models\Parroquia;
use App\Models\User;
use Illuminate\Support\Facades\DB;

it('filters monthly reports by status and lists contributor event histories', function () {
    $this->actingAs(User::factory()->create(['cedula' => 'V-12345678']));

    $this->get(route('contribuyentes.dashboard'))
        ->assertOk()
        ->assertSee('Módulo de Reportes')
        ->assertSee('Exportar a PDF');

    $acceptedStateId = DB::table('estados')->insertGetId(['nombre' => 'aceptado', 'created_at' => now(), 'updated_at' => now()]);
    $rejectedStateId = DB::table('estados')->insertGetId(['nombre' => 'rechazado', 'created_at' => now(), 'updated_at' => now()]);
    $parroquia = Parroquia::create(['nombre' => 'Centro']);
    $contribuyente = Contribuyente::create([
        'nombre' => 'Ana',
        'apellido' => 'Pérez',
        'dni' => 'V-12345678',
        'correo' => 'ana@example.test',
        'password' => 'password',
    ]);

    foreach ([
        ['fecha_evento' => '2026-05-29', 'id_estado' => $acceptedStateId],
        ['fecha_evento' => '2026-06-05', 'id_estado' => $acceptedStateId],
        ['fecha_evento' => '2026-06-12', 'id_estado' => $rejectedStateId, 'motivo_rechazo' => 'Documentación incompleta'],
        ['fecha_evento' => '2026-07-03', 'id_estado' => $acceptedStateId],
    ] as $event) {
        DB::table('eventos')->insert([
            'contribuyente_id' => $contribuyente->id,
            'ubicacion_evento' => 'Plaza central',
            'fecha_evento' => $event['fecha_evento'],
            'motivo_rechazo' => $event['motivo_rechazo'] ?? null,
            'id_estado' => $event['id_estado'],
            'parroquia_id' => $parroquia->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    $this->getJson(route('contribuyentes.dashboard.data', [
        'report' => 'month',
        'year' => 2026,
        'status' => 'accepted',
    ]))
        ->assertOk()
        ->assertJsonFragment([
            'label' => 'Junio 2026',
            'total' => 1,
            'accepted' => 1,
        ]);

    $this->getJson(route('contribuyentes.dashboard.data', [
        'report' => 'week',
        'year' => 2026,
        'month' => 6,
    ]))
        ->assertOk()
        ->assertJsonCount(2, 'rows');

    $this->getJson(route('contribuyentes.dashboard.data', ['report' => 'total', 'year' => 2026]))
        ->assertOk()
        ->assertJsonPath('rows.0.label', 'Eventos públicos')
        ->assertJsonPath('rows.0.total', 4)
        ->assertJsonPath('chart.0.total', 4);

    $this->getJson(route('contribuyentes.dashboard.data', ['report' => 'week', 'year' => 2026]))
        ->assertUnprocessable()
        ->assertJsonValidationErrors('month');

    $this->getJson(route('contribuyentes.dashboard.data', ['report' => 'history']))
        ->assertOk()
        ->assertJsonPath('rows.0.label', 'Ana Pérez')
        ->assertJsonPath('rows.0.total', 4);

    $this->getJson(route('contribuyentes.dashboard.data', [
        'report' => 'history',
        'contribuyente_id' => $contribuyente->id,
    ]))
        ->assertOk()
        ->assertJsonCount(4, 'rows')
        ->assertJsonPath('rows.1.status', 'rechazado')
        ->assertJsonPath('rows.1.url', null);

    $this->getJson(route('contribuyentes.dashboard.data', ['report' => 'rejected', 'year' => 2026]))
        ->assertOk()
        ->assertJsonPath('rows.0.reason', 'Documentación incompleta');
});