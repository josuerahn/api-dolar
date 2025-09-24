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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 30);
            $table->decimal('compra', 12, 2)->nullable();
            $table->decimal('venta', 12, 2)->nullable();
            $table->timestamp('fecha_actualizacion')->nullable();
            $table->string('fuente')->nullable();
            $table->timestamp('fecha_consulta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
