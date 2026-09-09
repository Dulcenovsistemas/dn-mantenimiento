<x-app-layout>

    <div class="max-w-5xl mx-auto px-6 py-8">

        {{-- Navegación --}}
        <div class="mb-6">

            <a
                href="{{ route('ordenes.index') }}"
                class="text-sm text-blue-600 hover:text-blue-800">

                ← Volver a órdenes

            </a>

        </div>


        {{-- Encabezado --}}
        <div class="flex items-start justify-between mb-6">

            <div>

                <p class="text-sm text-slate-500">
                    Orden de trabajo #{{ $orden->id }}
                </p>

                <h1 class="text-3xl font-bold text-slate-800 mt-1">
                    {{ $orden->tipo_mantenimiento }}
                </h1>

                <p class="text-sm text-slate-500 mt-2">
                    Creada el
                    {{ $orden->created_at->format('d/m/Y H:i') }}
                </p>

            </div>


            {{-- Acciones --}}
            <div class="flex items-center gap-3">


                {{-- Supervisor: editar mientras esté en espera --}}
                @if(
                    auth()->user()->role === 'Supervisor' &&
                    $orden->estatus === 'en_espera'
                )

                

                    <a
                        href="{{ route('ordenes.edit', $orden) }}"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">

                        Editar orden

                    </a>

                @endif

                


                @if(
                    auth()->user()->hasRole('Tecnico') &&
                    $orden->estatus === 'en_espera'
                )

                    <form
                        method="POST"
                        action="{{ route('ordenes.tomar', $orden) }}"
                        onsubmit="return confirm('¿Deseas tomar esta orden?');">

                        @csrf

                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">

                            Tomar orden

                        </button>

                    </form>

                @endif


                {{-- Técnico: editar después de tomarla --}}
                @if(
                    auth()->user()->role === 'Tecnico' &&
                    $orden->estatus === 'en_proceso' &&
                    $orden->tecnico_id === auth()->id()
                )

                    <a
                        href="{{ route('ordenes.edit', $orden) }}"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">

                        Editar orden

                    </a>

                @endif


            </div>

        </div>


        {{-- Información general --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">

            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">

                <h2 class="font-semibold text-slate-800">
                    Información de la orden
                </h2>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 p-6">


                {{-- Estatus --}}
                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Estatus
                    </p>

                    <p class="mt-1 font-medium text-slate-800">
                        {{ ucfirst(str_replace('_', ' ', $orden->estatus)) }}
                    </p>

                </div>


                {{-- Urgencia --}}
                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Urgencia
                    </p>

                    <p class="mt-1 font-medium text-slate-800">
                        {{ ucfirst($orden->urgencia) }}
                    </p>

                </div>


                {{-- Sucursal --}}
                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Sucursal
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $orden->sucursal->nombre }}
                    </p>

                </div>


                {{-- Área --}}
                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Área
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $orden->area->nombre }}
                    </p>

                </div>


                {{-- Equipo --}}
                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Equipo
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $orden->equipo->nombre }}
                    </p>

                </div>


                {{-- Solicitante --}}
                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Solicitante
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $orden->solicitante->name }}
                    </p>

                </div>


                {{-- Técnico --}}
                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Técnico asignado
                    </p>

                    <p class="mt-1 text-slate-700">

                        @if($orden->tecnico)
                            {{ $orden->tecnico->name }}
                        @else
                            Sin técnico asignado
                        @endif

                    </p>

                </div>


                {{-- Fecha de inicio --}}
                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Inicio del mantenimiento
                    </p>

                    <p class="mt-1 text-slate-700">

                        @if($orden->iniciada_at)

                            {{ \Carbon\Carbon::parse($orden->iniciada_at)->format('d/m/Y H:i') }}

                        @else

                            Aún no iniciada

                        @endif

                    </p>

                </div>


                {{-- Fecha de creación --}}
                <div>

                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        Fecha de solicitud
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $orden->created_at->format('d/m/Y H:i') }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Descripción de la falla --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">

            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">

                <h2 class="font-semibold text-slate-800">
                    Descripción de la falla / solicitud
                </h2>

            </div>

            <div class="p-6">

                <p class="text-slate-700 whitespace-pre-line">
                    {{ $orden->falla }}
                </p>

            </div>

        </div>


        {{-- Mensajes --}}
        @if(session('success'))

            <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">

                {{ session('error') }}

            </div>

        @endif


    </div>

    {{-- Trabajo realizado --}}
@if($orden->trabajo_realizado)

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">

        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">

            <h2 class="font-semibold text-slate-800">
                Trabajo realizado
            </h2>

        </div>

        <div class="p-6">

            <p class="text-slate-700 whitespace-pre-line">
                {{ $orden->trabajo_realizado }}
            </p>

        </div>

    </div>

@endif

{{-- Observaciones finales --}}
@if($orden->observaciones_finales)

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">

        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">

            <h2 class="font-semibold text-slate-800">
                Observaciones finales
            </h2>

        </div>

        <div class="p-6">

            <p class="text-slate-700 whitespace-pre-line">
                {{ $orden->observaciones_finales }}
            </p>

        </div>

    </div>

@endif

{{-- Fotografías --}}
@if($orden->imagenes->count())

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">

        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">

            <h2 class="font-semibold text-slate-800">
                Fotografías del mantenimiento
            </h2>

        </div>

        <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-4">

            @foreach($orden->imagenes as $imagen)

                <div class="rounded-lg overflow-hidden border border-slate-200">

                    <img
                        src="{{ asset('storage/' . $imagen->ruta) }}"
                        alt="Fotografía del mantenimiento"
                        class="w-full h-48 object-cover"
                    >

                </div>

            @endforeach

        </div>

    </div>

@endif

{{-- Costos --}}
@if($orden->costos->count())

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">

        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">

            <h2 class="font-semibold text-slate-800">
                Costos del mantenimiento
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>
                        <th class="text-left px-6 py-3 font-medium text-slate-600">
                            Concepto
                        </th>

                        <th class="text-center px-6 py-3 font-medium text-slate-600">
                            Cantidad
                        </th>

                        <th class="text-right px-6 py-3 font-medium text-slate-600">
                            Costo
                        </th>

                        <th class="text-right px-6 py-3 font-medium text-slate-600">
                            Subtotal
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @php
                        $total = 0;
                    @endphp

                    @foreach($orden->costos as $costo)

                        @php
                            $subtotal = $costo->cantidad * $costo->costo;
                            $total += $subtotal;
                        @endphp

                        <tr>

                            <td class="px-6 py-4 text-slate-700">
                                {{ $costo->concepto }}
                            </td>

                            <td class="px-6 py-4 text-center text-slate-700">
                                {{ $costo->cantidad }}
                            </td>

                            <td class="px-6 py-4 text-right text-slate-700">
                                ${{ number_format($costo->costo, 2) }}
                            </td>

                            <td class="px-6 py-4 text-right font-medium text-slate-700">
                                ${{ number_format($subtotal, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

                <tfoot class="border-t border-slate-200">

                    <tr>

                        <td colspan="3"
                            class="px-6 py-4 text-right font-semibold text-slate-800">

                            Total

                        </td>

                        <td class="px-6 py-4 text-right font-bold text-slate-800">

                            ${{ number_format($total, 2) }}

                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

@endif

</x-app-layout>