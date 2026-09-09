<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_trabajo', function (Blueprint $table) {

            $table->id();

            // Ubicación
            $table->foreignId('sucursal_id')
                ->constrained('sucursales')
                ->cascadeOnDelete();

            $table->foreignId('area_id')
                ->constrained('areas')
                ->cascadeOnDelete();

            // Equipo
            $table->foreignId('equipo_id')
                ->constrained('equipos')
                ->cascadeOnDelete();

            // Personas
            $table->foreignId('solicitante_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('tecnico_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Información de mantenimiento
            $table->string('tipo_mantenimiento');
            $table->text('falla');

            // Estado y prioridad
            $table->string('estatus')->default('en_espera');
            $table->string('urgencia')->default('media');

            // Fechas
            $table->timestamp('iniciada_at')->nullable();
            $table->timestamp('terminada_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_trabajo');
    }
};