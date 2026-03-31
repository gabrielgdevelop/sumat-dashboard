<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contribuyentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 15);
            $table->string('apellido', 15);
            $table->string('dni', 10)->unique();
            $table->string('telefono', 11)->unique();
            $table->string('correo', 100)->unique();
            $table->string('ubicacion_evento', 100);
            $table->string('rif', 11)->unique();
            $table->date('fecha_evento', 10);
            $table->string('tipo_evento', 255);
            $table->string('aceptado')->default('en espera');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribuyentes');
    }
};
