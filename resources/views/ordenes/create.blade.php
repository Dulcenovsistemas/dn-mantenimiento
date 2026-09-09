<x-app-layout>

    <div class="max-w-4xl mx-auto px-6 py-8">

        {{-- Encabezado --}}
        <div class="mb-6">

            <a
                href="{{ route('ordenes.index') }}"
                class="text-sm text-blue-600 hover:text-blue-800">

                ← Volver a órdenes

            </a>

            <h1 class="text-2xl font-bold text-slate-800 mt-4">
                Nueva orden de trabajo
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Registra una nueva solicitud de mantenimiento.
            </p>

        </div>


        {{-- Errores --}}
        @if($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4">

                <p class="font-semibold text-red-700 mb-2">
                    Revisa los siguientes errores:
                </p>

                <ul class="list-disc list-inside text-sm text-red-600 space-y-1">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Formulario --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6">

            <form
                method="POST"
                action="{{ route('ordenes.store') }}">

                @csrf


                {{-- Ubicación --}}
                <div class="mb-6">

                    <h2 class="text-lg font-semibold text-slate-800 mb-4">
                        Ubicación del equipo
                    </h2>


                    


                    {{-- Área --}}
                    <div class="mb-5">

                        <label
                            for="area_id"
                            class="block text-sm font-medium text-slate-700 mb-2">

                            Área

                        </label>

                        <select
                            id="area_id"
                            name="area_id"
                            required
                            class="w-full rounded-lg border-slate-300 bg-white focus:border-blue-500 focus:ring-blue-500">

                            <option value="">
                                Selecciona un área
                            </option>

                            @foreach($sucursal->areas as $area)

                                <option
                                    value="{{ $area->id }}"
                                    {{ old('area_id') == $area->id ? 'selected' : '' }}>

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
                            disabled
                            class="w-full rounded-lg border-slate-300 bg-slate-50 focus:border-blue-500 focus:ring-blue-500">

                            <option value="">
                                Primero selecciona un área
                            </option>

                        </select>

                        @error('equipo_id')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>


                <hr class="border-slate-200 mb-6">


                {{-- Información del mantenimiento --}}
                <div class="mb-6">

                    <h2 class="text-lg font-semibold text-slate-800 mb-4">
                        Información del mantenimiento
                    </h2>


                    {{-- Tipo --}}
                    <div class="mb-5">

                        <label
                            for="tipo_mantenimiento"
                            class="block text-sm font-medium text-slate-700 mb-2">

                            Tipo de mantenimiento

                        </label>

                        <select
                            id="tipo_mantenimiento"
                            name="tipo_mantenimiento"
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                            <option value="">
                                Selecciona un tipo
                            </option>

                            <option
                                value="correctivo"
                                {{ old('tipo_mantenimiento') === 'correctivo' ? 'selected' : '' }}>

                                Correctivo

                            </option>

                            <option
                                value="preventivo"
                                {{ old('tipo_mantenimiento') === 'preventivo' ? 'selected' : '' }}>

                                Preventivo

                            </option>

                            <option
                                value="predictivo"
                                {{ old('tipo_mantenimiento') === 'predictivo' ? 'selected' : '' }}>

                                Predictivo

                            </option>

                        </select>

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

                            Falla / descripción del problema

                        </label>

                        <textarea
                            id="falla"
                            name="falla"
                            rows="5"
                            required
                            placeholder="Describe la falla o el motivo por el que se solicita el mantenimiento..."
                            class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">{{ old('falla') }}</textarea>

                        @error('falla')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>


                <hr class="border-slate-200 mb-6">


                {{-- Solicitud --}}
                <div class="mb-6">

                    <h2 class="text-lg font-semibold text-slate-800 mb-4">
                        Solicitud
                    </h2>


                    {{-- Solicitante --}}
                    <div class="mb-5">

                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Solicitante
                        </label>

                        <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">

                            <div class="h-9 w-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">

                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                            </div>

                            <div>

                                <p class="text-sm font-medium text-slate-800">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    Usuario solicitante
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Técnico --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Técnico asignado
                        </label>

                        <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">

                            <span class="inline-flex items-center gap-2 text-sm text-slate-500">

                                <span>
                                    ⏳
                                </span>

                                Sin asignar — la orden está esperando ser tomada.

                            </span>

                        </div>

                    </div>

                </div>


                <hr class="border-slate-200 mb-6">


                {{-- Prioridad --}}
                <div class="mb-6">

                    <h2 class="text-lg font-semibold text-slate-800 mb-4">
                        Prioridad
                    </h2>


                    <label
                        for="urgencia"
                        class="block text-sm font-medium text-slate-700 mb-2">

                        Nivel de urgencia

                    </label>

                    <select
                        id="urgencia"
                        name="urgencia"
                        required
                        class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">

                        <option
                            value="baja"
                            {{ old('urgencia', 'media') === 'baja' ? 'selected' : '' }}>

                            🟢 Baja

                        </option>

                        <option
                            value="media"
                            {{ old('urgencia', 'media') === 'media' ? 'selected' : '' }}>

                            🟡 Media

                        </option>

                        <option
                            value="alta"
                            {{ old('urgencia') === 'alta' ? 'selected' : '' }}>

                            🟠 Alta

                        </option>

                        <option
                            value="critica"
                            {{ old('urgencia') === 'critica' ? 'selected' : '' }}>

                            🔴 Crítica

                        </option>

                    </select>

                    @error('urgencia')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Estado inicial --}}
                <div class="mb-6">

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Estatus
                    </label>

                    <div class="flex items-center gap-3 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3">

                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">

                            En espera

                        </span>

                        <span class="text-sm text-yellow-700">
                            La orden quedará disponible para que un técnico la tome.
                        </span>

                    </div>

                </div>


                {{-- Botones --}}
                <div class="flex items-center justify-end gap-3 pt-2">

                    <a
                        href="{{ route('ordenes.index') }}"
                        class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">

                        Cancelar

                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700">

                        Crear orden

                    </button>
                </div>
            </form>
        </div>
    </div>

  
    {{-- JavaScript --}}
  <script>

    const sucursalSelect = document.getElementById('sucursal_id');
    const areaSelect = document.getElementById('area_id');
    const equipoSelect = document.getElementById('equipo_id');


    /*
    |--------------------------------------------------------------------------
    | Cargar equipos de un área
    |--------------------------------------------------------------------------
    */

    function cargarEquipos(areaId) {

        equipoSelect.innerHTML = `
            <option value="">
                Cargando equipos...
            </option>
        `;

        equipoSelect.disabled = true;


        if (!areaId) {

            equipoSelect.innerHTML = `
                <option value="">
                    Primero selecciona un área
                </option>
            `;

            return;
        }


        fetch(`/api/areas/${areaId}/equipos`)

            .then(response => {

                if (!response.ok) {
                    throw new Error('Error al cargar los equipos.');
                }

                return response.json();

            })

            .then(equipos => {

                equipoSelect.innerHTML = `
                    <option value="">
                        Selecciona un equipo
                    </option>
                `;


                if (equipos.length === 0) {

                    equipoSelect.innerHTML = `
                        <option value="">
                            No hay equipos registrados en esta área
                        </option>
                    `;

                    equipoSelect.disabled = true;

                    return;
                }


                equipos.forEach(equipo => {

                    equipoSelect.innerHTML += `
                        <option value="${equipo.id}">
                            ${equipo.nombre}
                        </option>
                    `;

                });

                equipoSelect.disabled = false;

            })

            .catch(error => {

                console.error(error);

                equipoSelect.innerHTML = `
                    <option value="">
                        Error al cargar los equipos
                    </option>
                `;

                equipoSelect.disabled = true;

            });
    }


    /*
    |--------------------------------------------------------------------------
    | Cuando cambia el área
    |--------------------------------------------------------------------------
    */

    areaSelect.addEventListener('change', function () {

        cargarEquipos(this.value);

    });


    /*
    |--------------------------------------------------------------------------
    | Cargar automáticamente el equipo si ya existe un área seleccionada
    |--------------------------------------------------------------------------
    */

    document.addEventListener('DOMContentLoaded', function () {

        if (areaSelect && areaSelect.value) {

            cargarEquipos(areaSelect.value);

        }

    });


</script>

</x-app-layout>