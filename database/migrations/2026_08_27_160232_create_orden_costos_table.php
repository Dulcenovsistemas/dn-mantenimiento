<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orden_costos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('orden_trabajo_id')
                ->constrained('ordenes_trabajo')
                ->cascadeOnDelete();

            $table->string('concepto');

            $table->decimal('cantidad', 10, 2)
                ->default(1);

            $table->decimal('costo_unitario', 12, 2)
                ->default(0);

            $table->decimal('total', 12, 2)
                ->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_costos');
    }
};