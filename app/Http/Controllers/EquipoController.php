<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Equipo;
use App\Models\Sucursal;
use Illuminate\Http\Request;

use App\Imports\EquiposImport;
use Maatwebsite\Excel\Facades\Excel;

class EquipoController extends Controller
{
    /**
     * Mostrar los equipos de un área.
     */
    public function index(Sucursal $sucursal, Area $area)
    {
        $equipos = $area->equipos()
            ->orderBy('nombre')
            ->get();

        return view('equipos.index', compact(
            'sucursal',
            'area',
            'equipos'
        ));
    }

    /**
     * Mostrar formulario para crear un equipo.
     */
    public function create(Sucursal $sucursal, Area $area)
    {
        return view('equipos.create', compact(
            'sucursal',
            'area'
        ));
    }

    /**
     * Guardar un equipo.
     */
    public function store(
    Request $request,
    Sucursal $sucursal,
    Area $area
) {
    abort_unless(
        $area->sucursal_id === $sucursal->id,
        404
    );

    $validated = $request->validate([
        'nombre'            => ['required', 'string', 'max:255'],
        'marca_modelo'      => ['nullable', 'string', 'max:255'],
        'numero_serie'      => ['nullable', 'string', 'max:255'],
        'fecha_adquisicion' => ['nullable', 'date'],
        'especificaciones'  => ['nullable', 'string'],
        'qr_codigo'         => [
            'nullable',
            'string',
            'max:255',
            'unique:equipos,qr_codigo'
        ],
    ]);

    $validated['sucursal_id'] = $sucursal->id;
    $validated['area_id'] = $area->id;

    // El responsable se obtiene automáticamente del área
    $validated['responsable'] = $area->responsable;

    Equipo::create($validated);

    return redirect()
        ->route(
            'sucursales.areas.equipos.index',
            [$sucursal, $area]
        )
        ->with('success', 'Equipo creado correctamente.');
}

    /**
     * Mostrar un equipo.
     */
   public function show(
    Sucursal $sucursal,
    Area $area,
    Equipo $equipo
) {
    abort_unless(
        $equipo->sucursal_id === $sucursal->id &&
        $equipo->area_id === $area->id,
        404
    );

    $ordenes = $equipo->ordenes()
        ->with([
            'solicitante',
            'tecnico',
        ])
        ->latest()
        ->get();

    return view('equipos.show', compact(
        'sucursal',
        'area',
        'equipo',
        'ordenes'
    ));
}

    /**
     * Mostrar formulario para editar un equipo.
     */
    public function edit(
        Sucursal $sucursal,
        Area $area,
        Equipo $equipo
    ) {
        abort_unless(
            $equipo->sucursal_id === $sucursal->id &&
            $equipo->area_id === $area->id,
            404
        );

        return view('equipos.edit', compact(
            'sucursal',
            'area',
            'equipo'
        ));
    }

    /**
     * Actualizar un equipo.
     */
    public function update(
        Request $request,
        Sucursal $sucursal,
        Area $area,
        Equipo $equipo
    ) {
        abort_unless(
            $equipo->sucursal_id === $sucursal->id &&
            $equipo->area_id === $area->id,
            404
        );

        $validated = $request->validate([
            'nombre'            => ['required', 'string', 'max:255'],
            'marca_modelo'      => ['nullable', 'string', 'max:255'],
            'numero_serie'      => ['nullable', 'string', 'max:255'],
            'fecha_adquisicion' => ['nullable', 'date'],
            'responsable'       => ['nullable', 'string', 'max:255'],
            'especificaciones'  => ['nullable', 'string'],
            'qr_codigo'         => [
                'nullable',
                'string',
                'max:255',
                'unique:equipos,qr_codigo,' . $equipo->id,
            ],
        ]);

        $equipo->update($validated);

        return redirect()
            ->route(
                'sucursales.areas.equipos.show',
                [$sucursal, $area, $equipo]
            )
            ->with('success', 'Equipo actualizado correctamente.');
    }

    /**
     * Eliminar un equipo.
     */
    public function destroy(
        Sucursal $sucursal,
        Area $area,
        Equipo $equipo
    ) {
        abort_unless(
            $equipo->sucursal_id === $sucursal->id &&
            $equipo->area_id === $area->id,
            404
        );

        $equipo->delete();

        return redirect()
            ->route(
                'sucursales.areas.equipos.index',
                [$sucursal, $area]
            )
            ->with('success', 'Equipo eliminado correctamente.');
    }

    /**
     * Mostrar todos los equipos de la sucursal activa.
     */
  
 
    public function general()
    {
        $usuario = auth()->user();

        // Si todavía no hay una sucursal seleccionada,
        // usamos la primera sucursal asignada al usuario.
        if (!session()->has('sucursal_id')) {

            $sucursal = $usuario->sucursales()->first();

            if (!$sucursal) {
                abort(403, 'El usuario no tiene ninguna sucursal asignada.');
            }

            session([
                'sucursal_id' => $sucursal->id,
            ]);
        }

        $sucursalId = session('sucursal_id');

        $sucursal = Sucursal::with([
            'areas.equipos'
        ])->findOrFail($sucursalId);

        return view('equipos.general', compact('sucursal'));
    }

    public function importar(Request $request, Sucursal $sucursal, Area $area)
    {
        abort_unless(
            $area->sucursal_id === $sucursal->id,
            404
        );

        $request->validate([
            'archivo' => [
                'required',
                'file',
                'mimes:xlsx,xls',
            ],
        ]);

        Excel::import(
            new EquiposImport(
                $sucursal->id,
                $area->id,
                $area->responsable
            ),
            $request->file('archivo')
        );

        return redirect()
            ->route(
                'sucursales.areas.equipos.index',
                [$sucursal, $area]
            )
            ->with('success', 'Equipos importados correctamente.');
    }
}