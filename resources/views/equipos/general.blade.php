<x-app-layout>

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Encabezado --}}
        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Equipos
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Equipos de {{ $sucursal->nombre }}
                </p>
            </div>


        </div>


       
        {{-- Áreas --}}
        @forelse($sucursal->areas as $area)

            <div class="bg-white rounded-xl border border-slate-200 mb-5 overflow-hidden">

                {{-- Encabezado del área --}}
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">

                    <div class="flex items-center justify-between">

                        {{-- Botón para expandir/contraer --}}
                        <button
                            type="button"
                            onclick="toggleArea('{{ $area->id }}')"
                            class="flex items-center gap-3 text-left flex-1"
                        >

                            {{-- Flecha --}}
                            <svg
                                id="area-arrow-{{ $area->id }}"
                                class="w-5 h-5 text-slate-500 transition-transform duration-200"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>


                            <div>

                                <h2 class="text-lg font-semibold text-slate-800">
                                    {{ $area->nombre }}
                                </h2>

                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $area->equipos->count() }}
                                    {{ $area->equipos->count() === 1 ? 'equipo' : 'equipos' }}
                                </p>

                            </div>

                        </button>


                        {{-- Acciones del área --}}
                        <div class="flex items-center gap-2">

                            {{-- Importar Excel --}}
                            <button
                                type="button"
                                onclick="abrirModalImportar('{{ $area->id }}')"
                                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700"
                            >
                                <span>↑</span>
                                Importar Excel
                            </button>

                            {{-- Nuevo equipo --}}
                            <a
                                href="{{ route(
                                    'sucursales.areas.equipos.create',
                                    [$sucursal, $area]
                                ) }}"
                                class="inline-flex items-center gap-2 rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700"
                            >
                                <span>+</span>
                                Nuevo equipo
                            </a>

                        </div>

                    </div>

                </div>


                {{-- Contenido del área --}}
                <div
                    id="area-content-{{ $area->id }}"
                    class="hidden"
                >

                    {{-- Equipos --}}
                    @if($area->equipos->count())

                        <div class="overflow-x-auto">

                            <table class="w-full text-sm">

                                <thead class="border-b border-slate-200">

                                    <tr>

                                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                            Equipo
                                        </th>

                                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                            Marca / Modelo
                                        </th>

                                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                            Número de serie
                                        </th>

                                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                            Responsable
                                        </th>

                                        <th class="px-6 py-3 text-right font-semibold text-slate-600">
                                            Acciones
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-slate-100">

                                    @foreach($area->equipos as $equipo)

                                        <tr class="hover:bg-slate-50">

                                            <td class="px-6 py-4 font-medium text-slate-800">
                                                {{ $equipo->nombre }}
                                            </td>

                                            <td class="px-6 py-4 text-slate-600">
                                                {{ $equipo->marca_modelo ?: '—' }}
                                            </td>

                                            <td class="px-6 py-4 text-slate-600">
                                                {{ $equipo->numero_serie ?: '—' }}
                                            </td>

                                            <td class="px-6 py-4 text-slate-600">
                                                {{ $equipo->responsable ?: '—' }}
                                            </td>

                                           <td class="px-6 py-4 text-right">

    <div class="flex items-center justify-end gap-4">

        {{-- Ver --}}
        <a
            href="{{ route(
                'sucursales.areas.equipos.show',
                [$sucursal, $area, $equipo]
            ) }}"
            class="text-blue-600 hover:text-blue-800 font-medium"
        >
            Ver
        </a>

        {{-- Editar --}}
        <a
            href="{{ route(
                'sucursales.areas.equipos.edit',
                [$sucursal, $area, $equipo]
            ) }}"
            class="text-amber-600 hover:text-amber-800 font-medium"
        >
            Editar
        </a>

        {{-- Eliminar --}}
        <form
            action="{{ route(
                'sucursales.areas.equipos.destroy',
                [$sucursal, $area, $equipo]
            ) }}"
            method="POST"
            class="inline"
            onsubmit="return confirm('¿Estás segura de eliminar este equipo?');"
        >

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="text-red-600 hover:text-red-800 font-medium"
            >
                Eliminar
            </button>

        </form>

    </div>

</td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        {{-- Área sin equipos --}}
                        <div class="px-6 py-10 text-center">

                            <div class="text-3xl mb-2">
                                🛠️
                            </div>

                            <p class="font-medium text-slate-700">
                                No hay equipos registrados
                            </p>

                            <p class="text-sm text-slate-500 mt-1">
                                Esta área todavía no tiene equipos.
                            </p>

                            <a
                                href="{{ route(
                                    'sucursales.areas.equipos.create',
                                    [$sucursal, $area]
                                ) }}"
                                class="inline-block mt-4 text-blue-600 hover:text-blue-800 font-medium"
                            >
                                Agregar el primer equipo →
                            </a>

                        </div>

                    @endif

                </div>

            </div>

        @empty

            <div class="bg-white rounded-xl border border-slate-200 p-10 text-center">

                <div class="text-4xl mb-3">
                    📂
                </div>

                <h2 class="text-lg font-semibold text-slate-800">
                    No hay áreas registradas
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Esta sucursal todavía no tiene áreas configuradas.
                </p>

            </div>

        @endforelse

    </div>


    {{-- Modal para seleccionar área --}}
    <div
        id="modalAreas"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl">

            <div class="px-6 py-5 border-b border-slate-200">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">
                            Seleccionar área
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            ¿En qué área se registrará el equipo?
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="document.getElementById('modalAreas').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 text-xl">

                        ×

                    </button>

                </div>

            </div>


            <div class="p-4 space-y-2">

                @foreach($sucursal->areas as $area)

                    <a
                        href="{{ route(
                            'sucursales.areas.equipos.create',
                            [$sucursal, $area]
                        ) }}"
                        class="flex items-center justify-between rounded-xl px-4 py-3 hover:bg-slate-50 border border-transparent hover:border-slate-200">

                        <span class="font-medium text-slate-700">
                            {{ $area->nombre }}
                        </span>

                        <span class="text-slate-400">
                            →
                        </span>

                    </a>

                @endforeach

            </div>

        </div>

    </div>

    {{-- Modal para importar Excel --}}
    <div
        id="modalImportarExcel"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
    >

        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl">

            {{-- Encabezado --}}
            <div class="px-6 py-5 border-b border-slate-200">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">
                            Importar equipos
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Selecciona el archivo de Excel que deseas importar.
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="cerrarModalImportar()"
                        class="text-slate-400 hover:text-slate-600 text-xl"
                    >
                        ×
                    </button>

                </div>

            </div>


            {{-- Formulario --}}
            <form
                id="formImportarExcel"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="p-6">

                    <label
                        for="archivoExcel"
                        class="block text-sm font-medium text-slate-700 mb-2"
                    >
                        Archivo Excel
                    </label>

                    <input
                        type="file"
                        id="archivoExcel"
                        name="archivo"
                        accept=".xlsx,.xls"
                        required
                        class="block w-full text-sm text-slate-600
                            border border-slate-300 rounded-lg
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-medium
                            file:bg-slate-100 file:text-slate-700
                            hover:file:bg-slate-200"
                    >

                    <p class="text-xs text-slate-500 mt-2">
                        Formatos permitidos: .xlsx y .xls
                    </p>

                </div>


                {{-- Botones --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">

                    <button
                        type="button"
                        onclick="cerrarModalImportar()"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-white"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700"
                    >
                        Importar equipos
                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>

function toggleArea(areaId) {

    const content = document.getElementById(
        'area-content-' + areaId
    );

    const arrow = document.getElementById(
        'area-arrow-' + areaId
    );

    content.classList.toggle('hidden');

    arrow.classList.toggle('rotate-90');

}


function abrirModalImportar(areaId) {

    const modal = document.getElementById(
        'modalImportarExcel'
    );

    const formulario = document.getElementById(
        'formImportarExcel'
    );

    formulario.action =
        "{{ route('sucursales.areas.equipos.importar', [$sucursal, '__AREA__']) }}"
        .replace('__AREA__', areaId);

    modal.classList.remove('hidden');
}


function cerrarModalImportar() {

    const modal = document.getElementById(
        'modalImportarExcel'
    );

    const formulario = document.getElementById(
        'formImportarExcel'
    );

    formulario.reset();

    modal.classList.add('hidden');
}

</script>

</x-app-layout>