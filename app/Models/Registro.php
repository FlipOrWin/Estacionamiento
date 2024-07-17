<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    // Desactivar los timestamps automáticos
    public $timestamps = false;
    use HasFactory;

    protected $table = 'registros';

    protected $fillable = [
        'placa',
        'tipo',
        'entrada',
        'salida', // Agrega 'salida' aquí
        'pago',
        // Otros campos si los tienes
    ];
}
