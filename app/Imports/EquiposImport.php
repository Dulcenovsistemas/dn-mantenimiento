<?php

namespace App\Imports;

use App\Models\Equipo;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EquiposImport implements ToModel, WithStartRow
{
    protected $sucursalId;
    protected $areaId;
    protected $responsable;

    public function __construct($sucursalId, $areaId, $responsable)
    {
        $this->sucursalId = $sucursalId;
        $this->areaId = $areaId;
        $this->responsable = $responsable;
    }

    /**
     * Comenzar desde la fila 2 para ignorar los encabezados.
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Crear cada equipo a partir de una fila del Excel.
     */
    public function model(array $row)
    {
        return new Equipo([
            // Sucursal y área vienen de la página desde donde importamos
            'sucursal_id' => $this->sucursalId,
            'area_id' => $this->areaId,

            // Datos que vienen del Excel
            'nombre' => $row[3] ?? null,
            'marca_modelo' => $row[4] ?? null,
            'numero_serie' => $row[5] ?? null,
            'fecha_adquisicion' => $row[7] ?? null,
            'especificaciones' => $row[8] ?? null,

            // Responsable viene automáticamente del área
            'responsable' => $this->responsable,
        ]);
    }
}