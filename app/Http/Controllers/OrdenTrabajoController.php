<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Equipo;
use App\Models\OrdenTrabajo;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;

class OrdenTrabajoController extends Controller
{
    /**
     * Mostrar todas las órdenes de trabajo.
     */
    public function index()
    {
        $ordenes = OrdenTrabajo::with([
            'sucursal',
            'area',
            'equipo',
            'solicitante',
            'tecnico',
        ])
        ->latest()
        ->get();

        return view('ordenes.index', compact('ordenes'));
    }


    /**
     * Mostrar formulario para crear una orden.
     */
    public function create()
    {
        $usuario = auth()->user();

        $sucursales = $usuario->sucursales()
            ->with('areas')
            ->orderBy('nombre')
            ->get();

        $sucursalId = session('sucursal_id');

        $sucursal = $sucursales->firstWhere('id', $sucursalId);

        // Si no hay sucursal seleccionada, usamos la primera disponible
        if (!$sucursal) {
            $sucursal = $sucursales->first();

            if ($sucursal) {
                session(['sucursal_id' => $sucursal->id]);
            }
        }

        $tecnicos = User::orderBy('name')->get();

        return view('ordenes.create', compact(
            'sucursales',
            'sucursal',
            'tecnicos'
        ));
    }

    /**
     * Guardar una nueva orden.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Obtener sucursal activa
        |--------------------------------------------------------------------------
        */

        $sucursalId = session('sucursal_id');

        if (!$sucursalId) {
            return redirect()
                ->back()
                ->with('error', 'Selecciona una sucursal antes de crear una orden.');
        }


        /*
        |--------------------------------------------------------------------------
        | Validar que el usuario tenga acceso a la sucursal
        |--------------------------------------------------------------------------
        */

       

        $usuario = auth()->user();

        abort_unless(
            $usuario->hasAnyRole(['Admin', 'Supervisor']),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Validar formulario
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'area_id' => [
                'required',
                'exists:areas,id',
            ],

            'equipo_id' => [
                'required',
                'exists:equipos,id',
            ],

            'tipo_mantenimiento' => [
                'required',
                'string',
                'max:100',
            ],

            'falla' => [
                'required',
                'string',
            ],

            'urgencia' => [
                'required',
                'in:baja,media,alta,critica',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Verificar que el área pertenece a la sucursal activa
        |--------------------------------------------------------------------------
        */

        $area = Area::findOrFail($validated['area_id']);

        abort_unless(
            $area->sucursal_id == $sucursalId,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Verificar que el equipo pertenece al área y sucursal
        |--------------------------------------------------------------------------
        */

        $equipo = Equipo::findOrFail($validated['equipo_id']);

        abort_unless(
            $equipo->sucursal_id == $sucursalId &&
            $equipo->area_id == $validated['area_id'],
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Crear orden
        |--------------------------------------------------------------------------
        */

        $orden = OrdenTrabajo::create([
            'sucursal_id' => $sucursalId,
            'area_id' => $validated['area_id'],
            'equipo_id' => $validated['equipo_id'],

            'solicitante_id' => auth()->id(),
            'tecnico_id' => null,

            'tipo_mantenimiento' => $validated['tipo_mantenimiento'],
            'falla' => $validated['falla'],

            'estatus' => 'en_espera',
            'urgencia' => $validated['urgencia'],

            'iniciada_at' => null,
            'terminada_at' => null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redireccionar
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('ordenes.show', $orden)
            ->with(
                'success',
                'Orden de trabajo creada correctamente.'
            );
    }

    public function tomar(OrdenTrabajo $orden)
    {
        $usuario = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Solo técnicos pueden tomar órdenes
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $usuario->hasRole('Tecnico'),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | La orden debe estar en espera
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $orden->estatus === 'en_espera',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | El técnico debe tener acceso a la sucursal
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $usuario->sucursales()
                ->whereKey($orden->sucursal_id)
                ->exists(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | El técnico debe tener acceso al área
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $usuario->areas()
                ->whereKey($orden->area_id)
                ->exists(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Tomar orden
        |--------------------------------------------------------------------------
        */

        $orden->update([
            'tecnico_id' => $usuario->id,
            'estatus' => 'en_proceso',
            'iniciada_at' => now(),
        ]);


        return redirect()
            ->route('ordenes.show', $orden)
            ->with(
                'success',
                'Orden tomada correctamente.'
            );
    }


    /**
     * Mostrar una orden.
     */
    public function show(OrdenTrabajo $orden)
    {
        $orden->load([
            'sucursal',
            'area',
            'equipo',
            'solicitante',
            'tecnico',
            'imagenes',
            'costos',
        ]);

        return view('ordenes.show', compact('orden'));
    }


    /**
     * Mostrar formulario para editar una orden.
     */
    public function edit(OrdenTrabajo $orden)
    {
        $usuario = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Orden en espera
        |--------------------------------------------------------------------------
        */

        if ($orden->estatus === 'en_espera') {

            abort_unless(
                $usuario->hasAnyRole(['Admin', 'Supervisor']),
                403
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Orden en proceso
        |--------------------------------------------------------------------------
        */

        elseif ($orden->estatus === 'en_proceso') {

            $puedeEditar =
                $usuario->hasRole('Admin') ||
                (
                    $usuario->hasRole('Tecnico') &&
                    $orden->tecnico_id === $usuario->id
                );

            abort_unless(
                $puedeEditar,
                403
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Orden terminada
        |--------------------------------------------------------------------------
        */

        else {

            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Cargar relaciones
        |--------------------------------------------------------------------------
        */

        $orden->load([
            'sucursal',
            'area',
            'equipo',
            'solicitante',
            'tecnico',
        ]);

        return view('ordenes.edit', compact('orden'));
    }
    // El resto de tu código continúa...

    /**
     * Actualizar una orden.
     */
    public function update(
    Request $request,
    OrdenTrabajo $orden
    ) {
        $usuario = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Determinar quién puede editar
        |--------------------------------------------------------------------------
        */

        if ($orden->estatus === 'en_espera') {

            // Admin y Supervisor pueden editar
            abort_unless(
                $usuario->hasAnyRole(['Admin', 'Supervisor']),
                403
            );

        } elseif ($orden->estatus === 'en_proceso') {

            // Admin y el técnico que tomó la orden pueden editar
            $puedeEditar =
                $usuario->hasRole('Admin') ||
                (
                    $usuario->hasRole('Tecnico') &&
                    $orden->tecnico_id === $usuario->id
                );

            abort_unless(
                $puedeEditar,
                403
            );

        } else {

            // Una orden terminada no se puede editar
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Validar únicamente datos editables
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'area_id' => [
                'required',
                'exists:areas,id',
            ],

            'equipo_id' => [
                'required',
                'exists:equipos,id',
            ],

            'tipo_mantenimiento' => [
                'required',
                'string',
                'max:100',
            ],

            'falla' => [
                'required',
                'string',
            ],

            'urgencia' => [
                'required',
                'in:baja,media,alta,critica',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Verificar que el área pertenece a la sucursal de la orden
        |--------------------------------------------------------------------------
        */

        $area = Area::findOrFail(
            $validated['area_id']
        );

        abort_unless(
            $area->sucursal_id == $orden->sucursal_id,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Verificar que el equipo pertenece al área
        |--------------------------------------------------------------------------
        */

        $equipo = Equipo::findOrFail(
            $validated['equipo_id']
        );

        abort_unless(
            $equipo->sucursal_id == $orden->sucursal_id &&
            $equipo->area_id == $validated['area_id'],
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Actualizar únicamente los datos permitidos
        |--------------------------------------------------------------------------
        */

        $orden->update([

            'area_id' => $validated['area_id'],

            'equipo_id' => $validated['equipo_id'],

            'tipo_mantenimiento' =>
                $validated['tipo_mantenimiento'],

            'falla' =>
                $validated['falla'],

            'urgencia' =>
                $validated['urgencia'],

        ]);


        return redirect()
            ->route('ordenes.index', $orden)
            ->with(
                'success',
                'Orden de trabajo actualizada correctamente.'
            );
    }

    public function cerrar(Request $request, OrdenTrabajo $orden)
{
    /*
    |--------------------------------------------------------------------------
    | Validar que sea el técnico que tomó la orden
    |--------------------------------------------------------------------------
    */

    abort_unless(
        auth()->user()->hasRole('Tecnico') &&
        $orden->tecnico_id === auth()->id() &&
        $orden->estatus === 'en_proceso',
        403
    );


    /*
    |--------------------------------------------------------------------------
    | Validar información del cierre
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([

        'trabajo_realizado' => [
            'required',
            'string',
        ],

        'imagenes' => [
            'nullable',
            'array',
        ],

        'imagenes.*' => [
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:5120',
        ],

        'costos' => [
            'nullable',
            'array',
        ],

        'costos.*.concepto' => [
            'required',
            'string',
            'max:255',
        ],

        'costos.*.cantidad' => [
            'required',
            'numeric',
            'min:1',
        ],

        'costos.*.costo' => [
            'required',
            'numeric',
            'min:0',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | Actualizar orden
    |--------------------------------------------------------------------------
    */

    $orden->update([
    'trabajo_realizado' => $validated['trabajo_realizado'],
    'estatus' => 'cerrada',
    'finalizada_at' => now(),
]);

    /*
    |--------------------------------------------------------------------------
    | Guardar imágenes
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('imagenes')) {

        foreach ($request->file('imagenes') as $imagen) {

            $ruta = $imagen->store(
                'ordenes/' . $orden->id,
                'public'
            );

            $orden->imagenes()->create([

                'ruta' => $ruta,

                'nombre_original' =>
                    $imagen->getClientOriginalName(),

            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Guardar costos
    |--------------------------------------------------------------------------
    */

    $orden->costos()->delete();

    foreach ($validated['costos'] ?? [] as $costo) {

        $orden->costos()->create([

            'concepto' => $costo['concepto'],

            'cantidad' => $costo['cantidad'],

            'costo' => $costo['costo'],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Regresar
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('ordenes.show', $orden)
        ->with(
            'success',
            'Orden cerrada correctamente.'
        );
}
    /**
     * Eliminar una orden.
     */
    public function destroy(OrdenTrabajo $orden)
    {
        $orden->delete();

        return redirect()
            ->route('ordenes.index')
            ->with(
                'success',
                'Orden de trabajo eliminada correctamente.'
            );
    }
}