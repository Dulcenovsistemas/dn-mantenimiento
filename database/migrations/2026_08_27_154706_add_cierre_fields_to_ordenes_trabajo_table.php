<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordenes_trabajo', function (Blueprint $table) {

            $table->text('trabajo_realizado')
    ->nullable();

            $table->timestamp('finalizada_at')
                ->nullable()
                ->after('iniciada_at');

        });
    }

    public function down(): void
    {
        Schema::table('ordenes_trabajo', function (Blueprint $table) {

            $table->dropColumn([
                'trabajo_realizado',
                'finalizada_at',
            ]);

        });
    }
};