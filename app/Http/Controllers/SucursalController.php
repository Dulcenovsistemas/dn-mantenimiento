<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sucursal;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sucursales = Sucursal::orderBy('nombre')->paginate(10);

        return view('sucursales.index', compact('sucursales'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sucursales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo'      => 'required|string|max:20|unique:sucursales,codigo',
            'nombre'      => 'required|string|max:255',
            'direccion'   => 'nullable|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'telefono'    => 'nullable|string|max:20',
        ]);

        Sucursal::create($validated);

        return redirect()
            ->route('sucursales.index')
            ->with('success', 'Sucursal creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sucursal $sucursal)
    {
        return view('sucursales.edit', compact('sucursal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sucursal $sucursal)
    {
        $validated = $request->validate([
            'codigo'      => 'required|string|max:20|unique:sucursales,codigo,' . $sucursal->id,
            'nombre'      => 'required|string|max:255',
            'direccion'   => 'nullable|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'telefono'    => 'nullable|string|max:20',
        ]);

        $sucursal->update($validated);

        return redirect()
            ->route('sucursales.index')
            ->with('success', 'Sucursal actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sucursal $sucursal)
    {
        $sucursal->delete();

        return redirect()
            ->route('sucursales.index')
            ->with('success', 'Sucursal eliminada correctamente.');
    }
}
