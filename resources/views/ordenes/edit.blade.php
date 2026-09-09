<x-app-layout>

    <div class="max-w-5xl mx-auto px-6 py-8">

        {{-- Encabezado --}}
        <div class="mb-6">

            <a
                href="{{ route('ordenes.show', $orden) }}"
                class="text-sm text-blue-600 hover:text-blue-800">

                ← Volver a la orden

            </a>

            <div class="mt-4">

                <p class="text-sm text-slate-500">
                    Orden #{{ $orden->id }}
                </p>

                <h1 class="text-3xl font-bold text-slate-800">
                    Editar orden de trabajo
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Modifica la información de la orden antes de que sea tomada por un técnico.
                </p>

            </div>

          @if(
    auth()->user()->hasRole('Tecnico') &&
    $orden->estatus === 'en_proceso' &&
    $orden->tecnico_id === auth()->id()
)

    <button
        type="button"
        onclick="document.getElementById('modalCerrarOrden').classList.remove('hidden')"
        class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">

        Cerrar orden

    </button>

@endif

        </div>


        {{-- Formulario --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">

            <form
                method="POST"
                action="{{ route('ordenes.update', $orden) }}">

                @csrf
                @method('PUT')


                <div class="p-6 space-y-6">


                    {{-- Sucursal --}}
                    <div>

                        <label
                            class="block text-sm font-medium text-slate-700 mb-2">

                            Sucursal

                        </label>

                        <input
                            type="text"
                            value="{{ $orden->sucursal->nombre }}"
                            disabled
                            class="w-full rounded-lg border-slate-300 bg-slate-100 text-slate-600">

                        <p class="mt-1 text-xs text-slate-400">
                            La sucursal no puede modificarse desde la orden.
                        </p>

                    </div>


                    {{-- Área --}}
                    <div>

                        <label
                            for="area_id"
                            class="block text-sm font-medium text-slate-700 mb-2">

                            Área

                        </label>

                        <select
                            id="area_id"
                            name="area_id"
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                            <option value="">
                                Selecciona un área
                            </option>

                            @foreach($orden->sucursal->areas as $area)

                                <option
                                    value="{{ $area->id }}"
                                    @selected(
                                        old('area_id', $orden->area_id) == $area->id
                                    )>

                                    {{ $area->nombre }}

                                </option>

                            @endforeach

                        </select>

                        @error('area_id')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Equipo --}}
                    <div>

                        <label
                            for="equipo_id"
                            class="block text-sm font-medium text-slate-700 mb-2">

                            Equipo

                        </label>

                        <select
                            id="equipo_id"
                            name="equipo_id"
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                            <option value="">
                                Selecciona un equipo
                            </option>

                            @foreach($orden->area->equipos as $equipo)

                                <option
                                    value="{{ $equipo->id }}"
                                    @selected(
                                        old('equipo_id', $orden->equipo_id) == $equipo->id
                                    )>

                                    {{ $equipo->nombre }}

                                </option>

                            @endforeach

                        </select>

                        @error('equipo_id')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Tipo de mantenimiento --}}
                    <div>

                        <label
                            for="tipo_mantenimiento"
                            class="block text-sm font-medium text-slate-700 mb-2">

                            Tipo de mantenimiento

                        </label>

                        <input
                            type="text"
                            id="tipo_mantenimiento"
                            name="tipo_mantenimiento"
                            value="{{ old('tipo_mantenimiento', $orden->tipo_mantenimiento) }}"
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                        @error('tipo_mantenimiento')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Falla --}}
                    <div>

                        <label
                            for="falla"
                            class="block text-sm font-medium text-slate-700 mb-2">

                            Descripción de la falla / solicitud

                        </label>

                        <textarea
                            id="falla"
                            name="falla"
                            rows="5"
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">{{ old('falla', $orden->falla) }}</textarea>

                        @error('falla')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Urgencia --}}
                    <div>

                        <label
                            for="urgencia"
                            class="block text-sm font-medium text-slate-700 mb-2">

                            Urgencia

                        </label>

                        <select
                            id="urgencia"
                            name="urgencia"
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                            <option
                                value="baja"
                                @selected(old('urgencia', $orden->urgencia) === 'baja')>
                                Baja
                            </option>

                            <option
                                value="media"
                                @selected(old('urgencia', $orden->urgencia) === 'media')>
                                Media
                            </option>

                            <option
                                value="alta"
                                @selected(old('urgencia', $orden->urgencia) === 'alta')>
                                Alta
                            </option>

                            <option
                                value="critica"
                                @selected(old('urgencia', $orden->urgencia) === 'critica')>
                                Crítica
                            </option>

                        </select>

                        @error('urgencia')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Información que NO se modifica --}}
                    <div class="border-t border-slate-200 pt-6">

                        <h2 class="text-sm font-semibold text-slate-700 mb-4">
                            Información de control
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            <div>

                                <p class="text-xs uppercase tracking-wide text-slate-400">
                                    Estatus
                                </p>

                                <p class="mt-1 font-medium text-slate-700">
                                    {{ ucfirst(str_replace('_', ' ', $orden->estatus)) }}
                                </p>

                            </div>


                            <div>

                                <p class="text-xs uppercase tracking-wide text-slate-400">
                                    Solicitante
                                </p>

                                <p class="mt-1 font-medium text-slate-700">
                                    {{ $orden->solicitante->name }}
                                </p>

                            </div>


                            <div>

                                <p class="text-xs uppercase tracking-wide text-slate-400">
                                    Inicio
                                </p>

                                <p class="mt-1 font-medium text-slate-700">
                                    {{ $orden->iniciada_at
                                        ? $orden->iniciada_at->format('d/m/Y H:i')
                                        : 'Aún no iniciada'
                                    }}
                                </p>

                            </div>

                        </div>

                        <p class="mt-4 text-xs text-slate-400">
                            La hora de inicio se registrará automáticamente cuando un técnico tome la orden.
                        </p>

                    </div>

                </div>


                {{-- Botones --}}
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 bg-slate-50">

                    <a
                        href="{{ route('ordenes.show', $orden) }}"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-white">

                        Cancelar

                    </a>

                    <button
                        type="submit"
                        class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">

                        Guardar cambios

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- Modal cerrar orden --}}
<div
    id="modalCerrarOrden"
    class="fixed inset-0 z-50 hidden"
>

    {{-- Fondo --}}
    <div
        class="absolute inset-0 bg-black/50"
        onclick="document.getElementById('modalCerrarOrden').classList.add('hidden')"
    ></div>


    {{-- Contenido --}}
    <div class="relative flex min-h-screen items-center justify-center px-4 py-8">

        <div class="w-full max-w-3xl rounded-xl bg-white shadow-xl">

            {{-- Encabezado --}}
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

                <div>

                    <h2 class="text-xl font-bold text-slate-800">
                        Cerrar orden de trabajo
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Registra la información final de la intervención.
                    </p>

                </div>

                <button
                    type="button"
                    onclick="document.getElementById('modalCerrarOrden').classList.add('hidden')"
                    class="text-2xl text-slate-400 hover:text-slate-600"
                >
                    &times;
                </button>

            </div>


            {{-- Formulario --}}
            <form
                method="POST"
                action="{{ route('ordenes.cerrar', $orden) }}"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="max-h-[70vh] overflow-y-auto px-6 py-6 space-y-6">


                    {{-- Trabajo realizado --}}
                    <div>

                        <label
                            for="trabajo_realizado"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            Trabajo realizado
                        </label>

                        <textarea
                            id="trabajo_realizado"
                            name="trabajo_realizado"
                            rows="5"
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500"
                            placeholder="Describe detalladamente el trabajo realizado..."
                        >{{ old('trabajo_realizado') }}</textarea>

                        @error('trabajo_realizado')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Observaciones finales --}}
                    <div>

                        <label
                            for="observaciones_finales"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            Observaciones finales
                        </label>

                        <textarea
                            id="observaciones_finales"
                            name="observaciones_finales"
                            rows="4"
                            class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500"
                            placeholder="Agrega cualquier observación importante sobre el servicio..."
                        >{{ old('observaciones_finales') }}</textarea>

                        @error('observaciones_finales')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Fotografías --}}
                    <div>

                        <label
                            for="imagenes"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            Fotografías

                        </label>

                        <input
                            type="file"
                            id="imagenes"
                            name="imagenes[]"
                            multiple
                            accept="image/*"
                            class="block w-full text-sm text-slate-600"
                        >

                        <p class="mt-1 text-xs text-slate-400">
                            Puedes seleccionar varias fotografías.
                        </p>

                        @error('imagenes.*')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Costos --}}
                    <div>

                        <div class="flex items-center justify-between mb-3">

                            <div>

                                <h3 class="text-sm font-semibold text-slate-700">
                                    Materiales / costos
                                </h3>

                                <p class="text-xs text-slate-400">
                                    Agrega los costos utilizados durante el trabajo.
                                </p>

                            </div>

                            <button
                                type="button"
                                onclick="agregarCosto()"
                                class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                            >
                                + Agregar costo
                            </button>

                        </div>


                        <div
                            id="costosContainer"
                            class="space-y-3"
                        >

                            {{-- Los costos aparecerán aquí --}}

                        </div>

                    </div>

                </div>


                {{-- Botones --}}
                <div class="flex justify-end gap-3 border-t border-slate-200 px-6 py-4">

                    <button
                        type="button"
                        onclick="document.getElementById('modalCerrarOrden').classList.add('hidden')"
                        class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="rounded-lg bg-green-600 px-5 py-2 text-sm font-medium text-white hover:bg-green-700"
                    >
                        Confirmar cierre
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</x-app-layout>