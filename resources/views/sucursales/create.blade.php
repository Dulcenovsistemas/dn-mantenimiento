<x-app-layout>

<div class="max-w-4xl mx-auto">

    {{-- Encabezado --}}
    <div class="mb-8">

        <a href="{{ route('sucursales.index') }}"
            class="text-blue-600 hover:underline">

            ← Regresar

        </a>

        <h1 class="text-3xl font-bold text-slate-800 mt-4">

            Nueva Sucursal

        </h1>

        <p class="text-slate-500 mt-2">

            Agrega una nueva sucursal al sistema.

        </p>

    </div>

    {{-- Tarjeta --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-8">

        <form action="{{ route('sucursales.store') }}" method="POST">

            @csrf

            {{-- Aquí pondremos los inputs --}}
            <div>
                <label for="nombre" class="block text-sm font-medium text-slate-700">
                    Nombre
                </label>
                <input type="text" name="nombre" id="nombre" class="mt-2 w-full rounded-x1 border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600">

            </div>

            <div>
                <label for="codigo" class="block text-sm font-medium text-slate-700">
                    Codigo
                </label>
                <input type="text" name="codigo" id="codigo" class="mt-2 w-full rounded-x1 border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600">

            </div>

            <div>
                <label for="direccion" class="block text-sm font-medium text-slate-700">
                    Direccion
                </label>
                <input type="text" name="direccion" id="direccion" class="mt-2 w-full rounded-x1 border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600">

            </div>

            <div>
                <label for="telefono" class="block text-sm font-medium text-slate-700">
                    Telefono
                </label>
                <input type="text" name="telefono" id="telefono" class="mt-2 w-full rounded-x1 border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600">

            </div>

            <div>
                <label for="responsable" class="block text-sm font-medium text-slate-700">
                    Responsable
                </label>
                <input type="text" name="responsable" id="responsable" class="mt-2 w-full rounded-x1 border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-blue-600">

            </div>


            <div class="mt-8 flex justify-end gap-4 border-t border-slate-200 pt-6">

                <a href="{{ route('sucursales.index') }}"
                    class="rounded-xl border border-slate-300 px-6 py-3 text-slate-600 hover:bg-slate-100 transition">

                    Cancelar

                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700 transition">

                    Guardar Sucursal

                </button>

            </div>

        </form>

    </div>

</div>

</x-app-layout>