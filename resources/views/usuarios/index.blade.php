<x-app-layout>

    <div class="max-w-7xl mx-auto px-6 py-8">

        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex items-center justify-between mb-6">

                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Usuarios
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Administración de usuarios y sucursales asignadas
                    </p>
                </div>

                <a href="{{ route('usuarios.create') }}"
                class="px-4 py-2 rounded-lg bg-slate-800 text-white hover:bg-slate-700">
                    Nuevo usuario
                </a>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="px-4 py-3">Usuario</th>
                            <th class="px-4 py-3">Correo</th>
                            <th class="px-4 py-3">Sucursales</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">

                        @forelse($usuarios as $usuario)

                            <tr class="hover:bg-slate-50">

                                <td class="px-4 py-4">
                                    <div class="font-medium text-slate-800">
                                        {{ $usuario->name }}
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-slate-600">
                                    {{ $usuario->email }}
                                </td>

                                <td class="px-4 py-4">

                                    <div class="flex flex-wrap gap-2">

                                        @forelse($usuario->sucursales as $sucursal)

                                            <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs">
                                                {{ $sucursal->nombre }}
                                            </span>

                                        @empty

                                            <span class="text-xs text-slate-400">
                                                Sin sucursales asignadas
                                            </span>

                                        @endforelse

                                    </div>

                                </td>

                                <td class="px-4 py-4 text-right">

                                    <a href="{{ route('usuarios.edit', $usuario) }}"
                                    class="text-blue-600 hover:text-blue-800">
                                        Editar
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4"
                                    class="px-4 py-8 text-center text-slate-500">
                                    No hay usuarios registrados.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>