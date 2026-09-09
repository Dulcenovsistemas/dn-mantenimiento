<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Mostrar las áreas de una sucursal.
     */
    public function index(Sucursal $sucursal)
    {
        $areas = $sucursal->areas;

        return view('areas.index', compact('sucursal', 'areas'));
    }

    /**
     * Mostrar formulario para crear un área.
     */
    public function create(Sucursal $sucursal)
    {
        return view('areas.create', compact('sucursal'));
    }

    /**
     * Guardar una nueva área.
     */
    public function store(Request $request, Sucursal $sucursal)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'responsable' => 'nullable|string|max:255',
        ]);

        $sucursal->areas()->create($validated);

        return redirect()
            ->route('sucursales.edit', $sucursal)
            ->with('success', 'Área creada correctamente.');
    }

    public function api(Sucursal $sucursal)
    {
        return response()->json(
            $sucursal->areas()
                ->orderBy('nombre')
                ->get(['id', 'nombre'])
        );
    }
}