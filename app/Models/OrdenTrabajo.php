<?php

namespace App\Models;


use App\Models\Sucursal;
use App\Models\Area;
use App\Models\Equipo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenTrabajo extends Model
{
    protected $table = 'ordenes_trabajo';

   
        protected $fillable = [
        'sucursal_id',
        'area_id',
        'equipo_id',
        'solicitante_id',
        'tecnico_id',
        'tipo_mantenimiento',
        'falla',
        'estatus',
        'urgencia',
        'iniciada_at',

        // Cierre
        'trabajo_realizado',
        'observaciones_finales',
        'finalizada_at',

        'terminada_at',
        ];

    protected $casts = [
        'iniciada_at' => 'datetime',
        'terminada_at' => 'datetime',
    ];

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function imagenes()
    {
        return $this->hasMany(
            OrdenImagen::class,
            'orden_trabajo_id'
        );
    }

    public function costos()
    {
        return $this->hasMany(
            OrdenCosto::class,
            'orden_trabajo_id'
        );
    }
}