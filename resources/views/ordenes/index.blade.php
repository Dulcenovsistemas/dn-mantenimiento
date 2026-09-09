<x-app-layout>

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Encabezado --}}
        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Órdenes de trabajo
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Gestión de órdenes de mantenimiento
                </p>
            </div>

            <a
                href="{{ route('ordenes.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">

                <span class="text-lg leading-none">+</span>

                Nueva orden

            </a>

        </div>


        {{-- Mensaje de éxito --}}
        @if(session('success'))

            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

                {{ session('success') }}

            </div>

        @endif


        {{-- Tabla --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                Folio
                            </th>

                            <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                Equipo
                            </th>

                            <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                Ubicación
                            </th>

                            <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                Mantenimiento
                            </th>

                            <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                Técnico
                            </th>

                            <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                Urgencia
                            </th>

                            <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                Estatus
                            </th>

                            <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                Fecha
                            </th>

                            <th class="px-5 py-4 text-right font-semibold text-slate-600">
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($ordenes as $orden)

                            <tr class="hover:bg-slate-50">

                                {{-- Folio --}}
                                <td class="px-5 py-4">

                                    <span class="font-semibold text-slate-800">
                                        {{ $orden->folio ?? 'OT-' . str_pad($orden->id, 6, '0', STR_PAD_LEFT) }}
                                    </span>

                                </td>


                                {{-- Equipo --}}
                                <td class="px-5 py-4">

                                    <div class="font-medium text-slate-800">
                                        {{ $orden->equipo->nombre }}
                                    </div>

                                    @if($orden->equipo->numero_serie)

                                        <div class="text-xs text-slate-400 mt-1">
                                            S/N: {{ $orden->equipo->numero_serie }}
                                        </div>

                                    @endif

                                </td>


                                {{-- Ubicación --}}
                                <td class="px-5 py-4">

                                    <div class="text-slate-700">
                                        {{ $orden->sucursal->nombre }}
                                    </div>

                                    <div class="text-xs text-slate-400 mt-1">
                                        {{ $orden->area->nombre }}
                                    </div>

                                </td>


                                {{-- Tipo de mantenimiento --}}
                                <td class="px-5 py-4">

                                    <span class="text-slate-700">
                                        {{ ucfirst($orden->tipo_mantenimiento) }}
                                    </span>

                                </td>


                                {{-- Técnico --}}
                                <td class="px-5 py-4">

                                    @if($orden->tecnico)

                                        <div class="flex items-center gap-2">

                                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold">

                                                {{ strtoupper(substr($orden->tecnico->name, 0, 1)) }}

                                            </div>

                                            <span class="text-slate-700">
                                                {{ $orden->tecnico->name }}
                                            </span>

                                        </div>

                                    @else

                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-500">

                                            Sin asignar

                                        </span>

                                    @endif

                                </td>


                                {{-- Urgencia --}}
                                <td class="px-5 py-4">

                                    @switch($orden->urgencia)

                                        @case('critica')

                                            <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">

                                                🔴 Crítica

                                            </span>

                                            @break

                                        @case('alta')

                                            <span class="inline-flex items-center gap-1 rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">

                                                🟠 Alta

                                            </span>

                                            @break

                                        @case('media')

                                            <span class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">

                                                🟡 Media

                                            </span>

                                            @break

                                        @default

                                            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">

                                                🟢 Baja

                                            </span>

                                    @endswitch

                                </td>


                                {{-- Estatus --}}
                                <td class="px-5 py-4">

                                    @switch($orden->estatus)

                                        @case('en_espera')

                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">

                                                En espera

                                            </span>

                                            @break

                                        @case('en_proceso')

                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">

                                                En proceso

                                            </span>

                                            @break

                                        @case('terminada')

                                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">

                                                Terminada

                                            </span>

                                            @break

                                        @default

                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">

                                                {{ ucfirst($orden->estatus) }}

                                            </span>

                                    @endswitch

                                </td>


                                {{-- Fecha --}}
                                <td class="px-5 py-4 text-slate-500 whitespace-nowrap">

                                    {{ $orden->created_at->format('d/m/Y') }}

                                    <div class="text-xs text-slate-400">
                                        {{ $orden->created_at->format('H:i') }}
                                    </div>

                                </td>


                                {{-- Acciones --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center justify-end gap-3">

                                        <a
                                            href="{{ route('ordenes.show', $orden) }}"
                                            class="text-slate-600 hover:text-slate-900 font-medium">

                                            Ver

                                        </a>

                                        <a
                                            href="{{ route('ordenes.edit', $orden) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium">

                                            Editar

                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('ordenes.destroy', $orden) }}"
                                            onsubmit="return confirm('¿Estás seguro de eliminar esta orden de trabajo?');">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium">

                                                Eliminar

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9" class="px-6 py-14 text-center">

                                    <div class="text-4xl mb-3">
                                        📋
                                    </div>

                                    <h2 class="text-lg font-semibold text-slate-800">
                                        No hay órdenes de trabajo
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Todavía no se ha registrado ninguna orden de mantenimiento.
                                    </p>

                                    <a
                                        href="{{ route('ordenes.create') }}"
                                        class="inline-flex items-center gap-2 mt-5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">

                                        + Crear primera orden

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>