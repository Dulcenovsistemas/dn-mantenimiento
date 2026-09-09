<x-app-layout>

    <div class="max-w-5xl mx-auto px-6 py-8">

        {{-- Navegación --}}
        <div class="mb-6">

            <a
                href="{{ route(
                    'sucursales.areas.equipos.index',
                    [$sucursal, $area]
                ) }}"
                class="text-sm text-blue-600 hover:text-blue-800">

                ← Volver a equipos

            </a>

        </div>


        {{-- Encabezado --}}
        <div class="flex items-start justify-between mb-6">

            <div>

                <p class="text-sm text-slate-500">
                    {{ $sucursal->nombre }} /
                    {{ $area->nombre }}
                </p>

                <h1 class="text-3xl font-bold text-slate-800 mt-1">
                    {{ $equipo->nombre }}
                </h1>

            </div>

            <div class="flex items-center gap-3">

                <a
                    href="{{ route(
                        'sucursales.areas.equipos.edit',
                        [$sucursal, $area, $equipo]
                    ) }}"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">

                    Editar

                </a>

                <form
                    method="POST"
                    action="{{ route(
                        'sucursales.areas.equipos.destroy',
                        [$sucursal, $area, $equipo]
                    ) }}"
                    onsubmit="return confirm('¿Estás seguro de eliminar este equipo?');">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="rounded-lg border border-red-200 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">

                        Eliminar

                    </button>

                </form>

            </div>

        </div>


        {{-- Información --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">

                <h2 class="font-semibold text-slate-800">
                    Información del equipo
                </h2>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 p-6">

                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Nombre
                    </p>

                    <p class="mt-1 font-medium text-slate-800">
                        {{ $equipo->nombre }}
                    </p>
                </div>


                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Marca / Modelo
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $equipo->marca_modelo ?: 'No especificado' }}
                    </p>
                </div>


                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Número de serie
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $equipo->numero_serie ?: 'No especificado' }}
                    </p>
                </div>


                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Fecha de adquisición
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $equipo->fecha_adquisicion
                            ? \Carbon\Carbon::parse($equipo->fecha_adquisicion)->format('d/m/Y')
                            : 'No especificada'
                        }}
                    </p>
                </div>


                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Responsable
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $equipo->responsable ?: 'No asignado' }}
                    </p>
                </div>


                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Código QR
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $equipo->qr_codigo ?: 'No asignado' }}
                    </p>
                </div>


                <div class="md:col-span-2">

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Especificaciones
                    </p>

                    <p class="mt-2 text-slate-700 whitespace-pre-line">
                        {{ $equipo->especificaciones ?: 'Sin especificaciones registradas.' }}
                    </p>

                </div>

            </div>

        </div>
        
        {{-- Historial de órdenes de trabajo --}}
<div class="mt-6 bg-white rounded-xl border border-slate-200 overflow-hidden">

    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">

        <div>

            <h2 class="font-semibold text-slate-800">
                Historial de mantenimiento
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Órdenes de trabajo relacionadas con este equipo.
            </p>

        </div>

        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
            {{ $ordenes->count() }}
            {{ $ordenes->count() === 1 ? 'orden' : 'órdenes' }}
        </span>

    </div>


    @if($ordenes->isEmpty())

        <div class="px-6 py-10 text-center">

            <div class="text-4xl mb-3">
                🔧
            </div>

            <p class="font-medium text-slate-700">
                No hay órdenes de mantenimiento
            </p>

            <p class="text-sm text-slate-500 mt-1">
                Este equipo todavía no tiene órdenes de trabajo registradas.
            </p>

        </div>

    @else

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Orden
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Fecha
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Tipo
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Urgencia
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Estatus
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Técnico
                        </th>

                        <th class="px-6 py-3">
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @foreach($ordenes as $orden)

                        <tr class="hover:bg-slate-50">

                            {{-- Orden --}}
                            <td class="px-6 py-4">

                                <span class="font-semibold text-slate-800">
                                    #{{ $orden->id }}
                                </span>

                            </td>


                            {{-- Fecha --}}
                            <td class="px-6 py-4 text-slate-600">

                                {{ $orden->created_at
                                    ? $orden->created_at->format('d/m/Y')
                                    : '—'
                                }}

                            </td>


                            {{-- Tipo --}}
                            <td class="px-6 py-4 text-slate-700">

                                {{ $orden->tipo_mantenimiento }}

                            </td>


                            {{-- Urgencia --}}
                            <td class="px-6 py-4">

                                @php
                                    $urgenciaClasses = match($orden->urgencia) {
                                        'critica' => 'bg-red-100 text-red-700',
                                        'alta' => 'bg-orange-100 text-orange-700',
                                        'media' => 'bg-yellow-100 text-yellow-700',
                                        'baja' => 'bg-green-100 text-green-700',
                                        default => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp

                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $urgenciaClasses }}">
                                    {{ ucfirst($orden->urgencia) }}
                                </span>

                            </td>


                            {{-- Estatus --}}
                            <td class="px-6 py-4">

                                @php
                                    $estatusClasses = match($orden->estatus) {
                                        'en_espera' => 'bg-slate-100 text-slate-700',
                                        'en_proceso' => 'bg-blue-100 text-blue-700',
                                        'terminada' => 'bg-green-100 text-green-700',
                                        default => 'bg-slate-100 text-slate-600',
                                    };

                                    $estatusNombre = match($orden->estatus) {
                                        'en_espera' => 'En espera',
                                        'en_proceso' => 'En proceso',
                                        'terminada' => 'Terminada',
                                        default => ucfirst($orden->estatus),
                                    };
                                @endphp

                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $estatusClasses }}">
                                    {{ $estatusNombre }}
                                </span>

                            </td>


                            {{-- Técnico --}}
                            <td class="px-6 py-4 text-slate-600">

                                {{ $orden->tecnico?->name ?? 'Sin asignar' }}

                            </td>


                            {{-- Ver --}}
                            <td class="px-6 py-4 text-right">

                                <a
                                    href="{{ route('ordenes.show', $orden) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium"
                                >
                                    Ver
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>


    </div>


    

</x-app-layout>