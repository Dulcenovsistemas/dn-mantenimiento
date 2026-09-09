<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sucursal extends Model
{
    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
        'codigo',
        'direccion',
        'telefono',
        'responsable',
        'activo',
    ];

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
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