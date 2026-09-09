<x-app-layout>

    <div class="max-w-4xl mx-auto">

        {{-- Encabezado --}}
        <div class="mb-8">

            <a
                href="{{ route('sucursales.areas.equipos.index', [$sucursal, $area]) }}"
                class="text-blue-600 hover:underline"
            >
                ← Regresar a equipos
            </a>

            <h1 class="text-3xl font-bold text-slate-800 mt-4">
                Nuevo Equipo
            </h1>

            <p class="text-slate-500 mt-2">
                Registra un nuevo equipo en {{ $area->nombre }}.
            </p>

        </div>


        {{-- Información del equipo --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-8">

            <h2 class="text-xl font-semibold text-slate-800 mb-6">
                Información del equipo
            </h2>


            <form
                action="{{ route('sucursales.areas.equipos.store', [$sucursal, $area]) }}"
                method="POST"
            >

                @csrf


                {{-- Nombre --}}
                <div>

                    <label
                        for="nombre"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Nombre del equipo
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        value="{{ old('nombre') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                        placeholder="Ej. Computadora de recepción"
                    >

                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Marca / Modelo --}}
                <div class="mt-5">

                    <label
                        for="marca_modelo"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Marca / Modelo
                    </label>

                    <input
                        type="text"
                        name="marca_modelo"
                        id="marca_modelo"
                        value="{{ old('marca_modelo') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                        placeholder="Ej. Dell OptiPlex 7090"
                    >

                </div>


                {{-- Número de serie --}}
                <div class="mt-5">

                    <label
                        for="numero_serie"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Número de serie
                    </label>

                    <input
                        type="text"
                        name="numero_serie"
                        id="numero_serie"
                        value="{{ old('numero_serie') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                    >

                </div>


                {{-- Fecha de adquisición --}}
                <div class="mt-5">

                    <label
                        for="fecha_adquisicion"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Fecha de adquisición
                    </label>

                    <input
                        type="date"
                        name="fecha_adquisicion"
                        id="fecha_adquisicion"
                        value="{{ old('fecha_adquisicion') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                    >

                </div>


                
                {{-- Responsable --}}
                <div class="mt-5">

                    <label
                        for="responsable"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Responsable
                    </label>

                    <input
                        type="text"
                        name="responsable"
                        id="responsable"
                        value="{{ old('responsable', $area->responsable) }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 focus:border-blue-600 focus:ring-blue-600"
                        readonly
                    >

                    <p class="text-xs text-slate-500 mt-2">
                        Responsable asignado al área: {{ $area->responsable ?: 'Sin responsable' }}
                    </p>

                </div>


                {{-- Especificaciones --}}
                <div class="mt-5">

                    <label
                        for="especificaciones"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Especificaciones
                    </label>

                    <textarea
                        name="especificaciones"
                        id="especificaciones"
                        rows="5"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                        placeholder="Procesador, memoria RAM, almacenamiento, capacidad, etc."
                    >{{ old('especificaciones') }}</textarea>

                </div>


                {{-- QR --}}
                <div class="mt-5">

                    <label
                        for="qr_codigo"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Código QR
                    </label>

                    <input
                        type="text"
                        name="qr_codigo"
                        id="qr_codigo"
                        value="{{ old('qr_codigo') }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                        placeholder="Código identificador del equipo"
                    >

                    <p class="text-xs text-slate-500 mt-2">
                        Puedes dejarlo vacío y generarlo posteriormente.
                    </p>

                </div>


                {{-- Botones --}}
                <div class="mt-8 flex justify-end gap-4 border-t border-slate-200 pt-6">

                    <a
                        href="{{ route('sucursales.areas.equipos.index', [$sucursal, $area]) }}"
                        class="rounded-xl border border-slate-300 px-6 py-3 text-slate-600 hover:bg-slate-100 transition"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="rounded-xl bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700 transition"
                    >
                        Guardar equipo
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>