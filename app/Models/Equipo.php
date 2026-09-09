<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $fillable = [
        'sucursal_id',
        'area_id',
        'nombre',
        'marca_modelo',
        'numero_serie',
        'fecha_adquisicion',
        'responsable',
        'especificaciones',
        'qr_codigo',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function ordenesTrabajo()
    {
        return $this->hasMany(OrdenTrabajo::class);
    }

    public function ordenes()
    {
        return $this->hasMany(OrdenTrabajo::class);
    }
}