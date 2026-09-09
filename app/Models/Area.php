<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Equipo;
use App\Models\User;

class Area extends Model
{
    protected $fillable = [
        'sucursal_id',
        'nombre',
        'descripcion',
        'responsable',
    ];

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function ordenesTrabajo()
    {
        return $this->hasMany(OrdenTrabajo::class);
    }

}
