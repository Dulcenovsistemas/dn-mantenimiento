<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     public function index()
    {
        $usuarios = User::with('sucursales')
            ->orderBy('name')
            ->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $sucursales = Sucursal::with('areas')
            ->orderBy('nombre')
            ->get();

        return view('usuarios.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],

            'role' => [
                'required',
                'in:Admin,Supervisor,Tecnico',
            ],

            'sucursales' => [
                'required',
                'array',
                'min:1',
            ],

            'sucursales.*' => [
                'exists:sucursales,id',
            ],

            'areas' => [
                'nullable',
                'array',
            ],

            'areas.*' => [
                'exists:areas,id',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Crear usuario
        |--------------------------------------------------------------------------
        */

        $usuario = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Asignar rol
        |--------------------------------------------------------------------------
        */

        $usuario->assignRole(
            $validated['role']
        );


        /*
        |--------------------------------------------------------------------------
        | Asignar sucursales
        |--------------------------------------------------------------------------
        */

        $usuario->sucursales()->sync(
            $validated['sucursales']
        );


        /*
        |--------------------------------------------------------------------------
        | Asignar áreas
        |--------------------------------------------------------------------------
        */

        $usuario->areas()->sync(
            $validated['areas'] ?? []
        );


        /*
        |--------------------------------------------------------------------------
        | Redireccionar
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario creado correctamente.'
            );
    }

    public function edit(User $usuario)
{
    /*
    |--------------------------------------------------------------------------
    | Sucursales disponibles
    |--------------------------------------------------------------------------
    */

    $sucursales = Sucursal::with('areas')
        ->orderBy('nombre')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Sucursales y áreas actuales del usuario
    |--------------------------------------------------------------------------
    */

    $usuario->load([
        'sucursales',
        'areas',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Roles disponibles
    |--------------------------------------------------------------------------
    */

    $roles = [
        'Admin',
        'Supervisor',
        'Tecnico',
    ];


    return view('usuarios.edit', compact(
        'usuario',
        'sucursales',
        'roles'
    ));
}

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $usuario->id,
            ],

            'password' => [
                'nullable',
                'confirmed',
                'min:8',
            ],

            'role' => [
                'required',
                'in:Admin,Supervisor,Tecnico',
            ],

            'sucursales' => [
                'required',
                'array',
                'min:1',
            ],

            'sucursales.*' => [
                'exists:sucursales,id',
            ],

            'areas' => [
                'nullable',
                'array',
            ],

            'areas.*' => [
                'exists:areas,id',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Actualizar datos básicos
        |--------------------------------------------------------------------------
        */

        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];


        /*
        |--------------------------------------------------------------------------
        | Actualizar contraseña
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['password'])) {

            $usuario->password = Hash::make(
                $validated['password']
            );

        }


        $usuario->save();


        /*
        |--------------------------------------------------------------------------
        | Actualizar rol
        |--------------------------------------------------------------------------
        */

        $usuario->syncRoles([
            $validated['role']
        ]);


        /*
        |--------------------------------------------------------------------------
        | Actualizar sucursales
        |--------------------------------------------------------------------------
        */

        $usuario->sucursales()->sync(
            $validated['sucursales']
        );


        /*
        |--------------------------------------------------------------------------
        | Actualizar áreas
        |--------------------------------------------------------------------------
        */

        $usuario->areas()->sync(
            $validated['areas'] ?? []
        );


        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario actualizado correctamente.'
            );
    }
}
