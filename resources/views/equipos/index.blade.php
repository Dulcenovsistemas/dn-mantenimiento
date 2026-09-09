<x-app-layout>

    <div class="max-w-6xl mx-auto">

        {{-- Encabezado --}}
        <div class="mb-8">

            <a
                href="#"
                class="text-blue-600 hover:underline"
            >
                ← Regresar 
            </a>

            <div class="flex items-center justify-between mt-4">

                <div>

                    <h1 class="text-3xl font-bold text-slate-800">
                        {{ $area->nombre }}
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Equipos registrados en esta área.
                    </p>

                </div>

            </div>

        </div>


        {{-- Información del área --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">

            <div class="flex items-center gap-6">

                <div>
                    <p class="text-sm text-slate-500">
                        Sucursal
                    </p>

                    <p class="font-medium text-slate-800">
                        {{ $sucursal->nombre }}
                    </p>
                </div>


                <div class="border-l border-slate-200 pl-6">

                    <p class="text-sm text-slate-500">
                        Área
                    </p>

                    <p class="font-medium text-slate-800">
                        {{ $area->nombre }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Lista de equipos --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">

                <h2 class="text-lg font-semibold text-slate-800">
                    Equipos
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $equipos->count() }} equipos registrados.
                </p>

            </div>


            @forelse($equipos as $equipo)

                <div class="px-6 py-5 border-b border-slate-200 last:border-b-0">

                    <div class="flex items-center justify-between">

                        {{-- Información --}}
                        <div>

                            <h3 class="font-semibold text-slate-800">
                                {{ $equipo->nombre }}
                            </h3>

                            <div class="flex gap-6 mt-2 text-sm text-slate-500">

                                @if($equipo->marca_modelo)

                                    <span>
                                        {{ $equipo->marca_modelo }}
                                    </span>

                                @endif


                                @if($equipo->numero_serie)

                                    <span>
                                        S/N: {{ $equipo->numero_serie }}
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Acciones --}}
                        <div class="flex items-center gap-4">

                            <a
                                href="#"
                                class="text-blue-600 hover:text-blue-800"
                            >
                                Editar
                            </a>


                            <form
                                action="{{ route('sucursales.areas.equipos.destroy', [$sucursal, $area, $equipo]) }}"
                                method="POST"
                                class="inline"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('¿Estás segura de eliminar este equipo?')"
                                    class="text-red-600 hover:text-red-800"
                                >
                                    Eliminar
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @empty

                <div class="py-16 text-center">

                    <div class="text-4xl mb-4">
                        🛠️
                    </div>

                    <h3 class="font-semibold text-slate-800">
                        No hay equipos registrados
                    </h3>

                    <p class="text-slate-500 mt-2">
                        Esta área todavía no tiene equipos.
                    </p>

                    <a
                        href="#"
                        class="inline-block mt-4 text-blue-600 hover:underline"
                    >
                        Agregar el primer equipo
                    </a>

                </div>

            @endforelse

        </div>

    </div>

</x-app-layout>