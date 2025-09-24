<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('promedios', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 40)->index();
            $table->enum('periodo', ['mensual'])->default('mensual')->index();
            $table->unsignedSmallInteger('anio')->index();
            $table->unsignedTinyInteger('mes')->index();
            $table->decimal('promedio_compra', 14, 6)->nullable();
            $table->decimal('promedio_venta', 14, 6)->nullable();
            $table->unsignedInteger('muestras')->default(0);
            $table->timestamps();
            $table->unique(['tipo','periodo','anio','mes'], 'u_tipo_periodo_anio_mes');
        });
    }
    public function down(): void { Schema::dropIfExists('promedios'); }
};
