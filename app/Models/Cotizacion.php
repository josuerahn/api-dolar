<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones'; // 👈 nombre correcto de la tabla

    protected $fillable = [
        'fuente','tipo','compra','venta','fecha_cotizacion','payload'
    ];

    protected $casts = [
        'fecha_cotizacion' => 'datetime',
        'payload' => 'array',
    ];
}