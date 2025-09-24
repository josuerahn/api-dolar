<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';

    protected $fillable = [
        'tipo',
        'compra',
        'venta',
        'fecha_actualizacion',
        'fuente',
        'fecha_consulta',
    ];

    protected $casts = [
        'compra' => 'float',
        'venta' => 'float',
        'fecha_actualizacion' => 'datetime',
        'fecha_consulta' => 'datetime',
    ];
}

