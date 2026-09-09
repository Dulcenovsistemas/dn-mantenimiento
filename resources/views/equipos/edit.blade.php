<x-app-layout>

    <div class="max-w-4xl mx-auto px-6 py-8">

        {{-- Encabezado --}}
        <div class="mb-6">

            <a
                href="{{ route(
                    'sucursales.areas.equipos.show',
                    [$sucursal, $area, $equipo]
                ) }}"
                class="text-sm text-blue-600 hover:text-blue-800">

                ← Volver al equipo

            </a>

            <h1 class="text-2xl font-bold text-slate-800 mt-4">
                Editar equipo
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                {{ $sucursal->nombre }} /
                {{ $area->nombre }}
            </p>

        </div>


        <div class="bg-white rounded-xl border border-slate-200 p-6">

            <form
                method="POST"
                action="{{ route(
                    'sucursales.areas.equipos.update',
                    [$sucursal, $area, $equipo]
                ) }}">

                @csrf
                @method('PUT')


                {{-- Nombre --}}
                <div class="mb-5">

                    <label
                        for="nombre"
                        class="block text-sm font-medium text-slate-700 mb-2">

                        Nombre del equipo

                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre', $equipo->nombre) }}"
                        required
                        class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Marca / Modelo --}}
                <div class="mb-5">

                    <label
                        for="marca_modelo"
                        class="block text-sm font-medium text-slate-700 mb-2">

                        Marca / Modelo

                    </label>

                    <input
                        type="text"
                        id="marca_modelo"
                        name="marca_modelo"
                        value="{{ old('marca_modelo', $equipo->marca_modelo) }}"
                        class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                    @error('marca_modelo')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Serie y fecha --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                    <div>

                        <label
                            for="numero_serie"
                            class="block text-sm font-medium text-slate-700 mb-2">

                            Número de serie

                        </label>

                        <input
                            type="text"
                            id="numero_serie"
                            name="numero_serie"
                            value="{{ old('numero_serie', $equipo->numero_serie) }}"
                            class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                        @error('numero_serie')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label
                            for="fecha_adquisicion"
                            class="block text-sm font-medium text-slate-700 mb-2">

                            Fecha de adquisición

                        </label>

                        <input
                            type="date"
                            id="fecha_adquisicion"
                            name="fecha_adquisicion"
                            value="{{ old('fecha_adquisicion', $equipo->fecha_adquisicion) }}"
                            class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                        @error('fecha_adquisicion')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- Responsable --}}
                <div class="mb-5">

                    <label
                        for="responsable"
                        class="block text-sm font-medium text-slate-700 mb-2">

                        Responsable

                    </label>

                    <input
                        type="text"
                        id="responsable"
                        name="responsable"
                        value="{{ old('responsable', $equipo->responsable) }}"
                        class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                    @error('responsable')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- QR --}}
                <div class="mb-5">

                    <label
                        for="qr_codigo"
                        class="block text-sm font-medium text-slate-700 mb-2">

                        Código QR

                    </label>

                    <input
                        type="text"
                        id="qr_codigo"
                        name="qr_codigo"
                        value="{{ old('qr_codigo', $equipo->qr_codigo) }}"
                        class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                    @error('qr_codigo')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Especificaciones --}}
                <div class="mb-6">

                    <label
                        for="especificaciones"
                        class="block text-sm font-medium text-slate-700 mb-2">

                        Especificaciones

                    </label>

                    <textarea
                        id="especificaciones"
                        name="especificaciones"
                        rows="5"
                        class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">{{ old('especificaciones', $equipo->especificaciones) }}</textarea>

                    @error('especificaciones')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Botones --}}
                <div class="flex justify-end gap-3">

                    <a
                        href="{{ route(
                            'sucursales.areas.equipos.show',
                            [$sucursal, $area, $equipo]
                        ) }}"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">

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

</x-app-layout>