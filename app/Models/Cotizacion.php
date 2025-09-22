<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $fillable = [
        'tipo',
        'compra',
        'venta',
        'fecha_actualizacion',
        'fuente',
    ];

    protected $casts = [
        'compra' => 'float',
        'venta' => 'float',
        'fecha_actualix}zacion' => 'datetime',
    ];
}
