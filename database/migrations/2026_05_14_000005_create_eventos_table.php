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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contribuyente_id')->nullable()
            ->constrained('contribuyentes')
            ->nullOnDelete();
            $table->string('ubicacion_evento', 255)->nullable();
            $table->date('fecha_evento')->nullable();
            $table->time('hora_evento')->nullable();
            $table->string('tipo_evento')->nullable();
            $table->foreignId('id_estado')
            ->constrained('estados')
            ->restrictOnDelete()
            ->cascadeOnUpdate();
            $table->foreignId('parroquia_id')->nullable()->constrained('parroquias')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
