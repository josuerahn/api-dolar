<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('fuente', 80)->index();
            $table->string('tipo', 40)->index();         // blue, oficial, mep, ccl...
            $table->decimal('compra', 12, 4)->nullable();
            $table->decimal('venta', 12, 4)->nullable();
            $table->timestamp('fecha_cotizacion')->index();
            $table->unsignedSmallInteger('anio')->index(); // p/consultas por mes
            $table->unsignedTinyInteger('mes')->index();   // 1..12
            $table->json('payload')->nullable();
            $table->timestamps();
            $table->unique(['fuente','tipo','fecha_cotizacion'], 'u_fuente_tipo_fecha');
        });
    }
    public function down(): void { Schema::dropIfExists('cotizaciones'); }
};
