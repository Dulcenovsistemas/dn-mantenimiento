<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenCosto extends Model
{
    protected $table = 'orden_costos';

    protected $fillable = [
        'orden_trabajo_id',
        'concepto',
        'cantidad',
        'costo',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'costo' => 'decimal:2',
    ];

    /**
     * Orden de trabajo a la que pertenece el costo.
     */
    public function orden(): BelongsTo
    {
        return $this->belongsTo(
            OrdenTrabajo::class,
            'orden_trabajo_id'
        );
    }
}