<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Promedio extends Model
{
    protected $fillable = [
        'tipo','periodo','anio','mes','promedio_compra','promedio_venta','muestras'
    ];
}
