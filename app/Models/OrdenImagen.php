<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdenImagen extends Model
{
    use HasFactory;

    protected $table = 'orden_imagenes';

    protected $fillable = [
        'orden_trabajo_id',
        'ruta',
        'nombre_original',
    ];

    public function orden()
    {
        return $this->belongsTo(
            OrdenTrabajo::class,
            'orden_trabajo_id'
        );
    }
}