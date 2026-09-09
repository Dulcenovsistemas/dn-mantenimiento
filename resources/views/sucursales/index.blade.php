<x-app-layout>

<div class="space-y-8">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Sucursales
            </h1>

            <p class="text-slate-500 mt-1">
                Administra las sucursales del sistema.
            </p>

        </div>

        <a href="{{ route('sucursales.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

            Nueva Sucursal

        </a>

    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

        {{-- Buscador --}}
        <div class="p-6 border-b border-slate-200">

            <input
                type="text"
                placeholder="Buscar sucursal..."
                class="w-80 rounded-xl border border-slate-300 px-4 py-2 focus:border-blue-600 focus:ring-blue-600">

        </div>

        {{-- Tabla --}}
        <table class="min-w-full">

            <thead class="bg-slate-50">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                        Código
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                        Nombre
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                        Dirección
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                        Responsable
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">
                        Teléfono
                    </th>

                    <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">
                        Acciones
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-slate-200">

                @forelse($sucursales as $sucursal)

                    <tr class="hover:bg-slate-50">

                        <td class="px-6 py-4">
                            {{ $sucursal->codigo }}
                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $sucursal->nombre }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $sucursal->direccion }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $sucursal->responsable ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $sucursal->telefono ?? '-' }}
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-3">

                                <a href="{{ route('sucursales.edit', $sucursal) }}"
                                    class="text-blue-600 hover:text-blue-800">

                                    Editar

                                </a>

                                <form action="{{ route('sucursales.destroy', ['sucursal' => $sucursal->id]) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('¿Estás segura de eliminar esta sucursal?')"
                                        class="text-red-600 hover:text-red-800">
                                        Eliminar
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="py-12 text-center text-slate-500">

                            No hay sucursales registradas.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

        {{-- Paginación --}}
        <div class="p-6 border-t border-slate-200">

            {{ $sucursales->links() }}

        </div>

    </div>

</div>

</x-app-layout>