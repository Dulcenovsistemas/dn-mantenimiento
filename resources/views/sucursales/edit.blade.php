<x-app-layout>

    <div class="max-w-4xl mx-auto">

        {{-- Encabezado --}}
        <div class="mb-8">

            <a href="{{ route('sucursales.index') }}"
                class="text-blue-600 hover:underline">

                ← Regresar

            </a>

            <h1 class="text-3xl font-bold text-slate-800 mt-4">

                Editar Sucursal

            </h1>

            <p class="text-slate-500 mt-2">

                Actualiza la información de la sucursal.

            </p>

        </div>


        {{-- Información de la sucursal --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-8">

            <h2 class="text-xl font-semibold text-slate-800 mb-6">
                Información de la sucursal
            </h2>

            <form action="{{ route('sucursales.update', ['sucursal' => $sucursal->id]) }}" method="POST">

                @csrf

                @method('PUT')


                {{-- Nombre --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-slate-700">
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                        value="{{ old('nombre', $sucursal->nombre) }}"
                    >
                </div>


                {{-- Código --}}
                <div class="mt-5">
                    <label for="codigo" class="block text-sm font-medium text-slate-700">
                        Código
                    </label>

                    <input
                        type="text"
                        name="codigo"
                        id="codigo"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                        value="{{ old('codigo', $sucursal->codigo) }}"
                    >
                </div>


                {{-- Dirección --}}
                <div class="mt-5">
                    <label for="direccion" class="block text-sm font-medium text-slate-700">
                        Dirección
                    </label>

                    <input
                        type="text"
                        name="direccion"
                        id="direccion"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                        value="{{ old('direccion', $sucursal->direccion) }}"
                    >
                </div>


                {{-- Teléfono --}}
                <div class="mt-5">
                    <label for="telefono" class="block text-sm font-medium text-slate-700">
                        Teléfono
                    </label>

                    <input
                        type="text"
                        name="telefono"
                        id="telefono"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                        value="{{ old('telefono', $sucursal->telefono) }}"
                    >
                </div>


                {{-- Responsable --}}
                <div class="mt-5">
                    <label for="responsable" class="block text-sm font-medium text-slate-700">
                        Responsable
                    </label>

                    <input
                        type="text"
                        name="responsable"
                        id="responsable"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                        value="{{ old('responsable', $sucursal->responsable) }}"
                    >
                </div>


                {{-- Botones --}}
                <div class="mt-8 flex justify-end gap-4 border-t border-slate-200 pt-6">

                    <a
                        href="{{ route('sucursales.index') }}"
                        class="rounded-xl border border-slate-300 px-6 py-3 text-slate-600 hover:bg-slate-100 transition"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="rounded-xl bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700 transition"
                    >
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

        {{-- Áreas de la sucursal --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-8 mt-6">

            {{-- Encabezado --}}
            <div class="flex items-center justify-between mb-6">

                <div>
                    <h2 class="text-xl font-semibold text-slate-800">
                        Áreas
                    </h2>

                    <p class="text-slate-500 text-sm mt-1">
                        Áreas pertenecientes a esta sucursal.
                    </p>
                </div>

                <button
                    type="button"
                    id="mostrar-form-area"
                    class="rounded-xl bg-blue-600 px-5 py-3 font-medium text-white hover:bg-blue-700 transition"
                >
                    + Nueva área
                </button>

            </div>


            {{-- Lista de áreas --}}
            <div class="border-t border-slate-200">

                @forelse($sucursal->areas as $area)

                    <div class="flex items-center justify-between py-4 border-b border-slate-200">

                        <div>
                            <h3 class="font-medium text-slate-800">
                                {{ $area->nombre }}
                            </h3>

                            @if($area->descripcion)
                                <p class="text-sm text-slate-500 mt-1">
                                    {{ $area->descripcion }}
                                </p>
                            @endif
                        </div>

                        <div>
                            {{-- Aquí posteriormente pondremos eliminar --}}
                        </div>

                    </div>

                @empty

                    <div class="py-8 text-center">
                        <p class="text-slate-500">
                            Esta sucursal todavía no tiene áreas.
                        </p>
                    </div>

                @endforelse

            </div>


            {{-- FORMULARIO NUEVA ÁREA --}}
            <div id="form-area" class="hidden mt-6 border-t border-slate-200 pt-6">

                <h3 class="text-lg font-semibold text-slate-800 mb-5">
                    Nueva área
                </h3>

                <form action="{{ route('sucursales.areas.store', $sucursal) }}" method="POST">

                    @csrf

                    {{-- NOMBRE --}}
                    <div>
                        <label
                            for="area_nombre"
                            class="block text-sm font-medium text-slate-700"
                        >
                            Nombre
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            id="area_nombre"
                            value="{{ old('nombre') }}"
                            class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                            placeholder="Ej. Sistemas"
                        >

                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="mt-5">

                        <label
                            for="area_descripcion"
                            class="block text-sm font-medium text-slate-700"
                        >
                            Descripción
                        </label>

                        <textarea
                            name="descripcion"
                            id="area_descripcion"
                            rows="3"
                            class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                            placeholder="Descripción del área..."
                        >{{ old('descripcion') }}</textarea>

                    </div>

                    {{-- RESPONSABLE --}}
                    <div class="mt-5">

                        <label
                            for="area_responsable"
                            class="block text-sm font-medium text-slate-700"
                        >
                            Responsable
                        </label>

                        <input
                            type="text"
                            name="responsable"
                            id="area_responsable"
                            value="{{ old('responsable') }}"
                            class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600"
                            placeholder="Ej. Juan Pérez"
                        >

                        @error('responsable')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- BOTONES --}}
                    <div class="mt-6 flex justify-end gap-4">

                        <button
                            type="button"
                            id="cancelar-area"
                            class="rounded-xl border border-slate-300 px-6 py-3 text-slate-600 hover:bg-slate-100 transition"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700 transition"
                        >
                            Guardar área
                        </button>

                    </div>

                </form>
            </div>

        </div>
        

    </div>

    <script>

    const botonMostrar = document.getElementById('mostrar-form-area');
    const botonCancelar = document.getElementById('cancelar-area');
    const formulario = document.getElementById('form-area');

    botonMostrar.addEventListener('click', function () {
        formulario.classList.remove('hidden');
    });

    botonCancelar.addEventListener('click', function () {
        formulario.classList.add('hidden');
    });

</script>

</x-app-layout>