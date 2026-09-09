<x-app-layout>

    <div class="max-w-4xl mx-auto px-6 py-8">

        <div class="mb-6">

            <h1 class="text-2xl font-bold text-slate-800">
                Editar usuario
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Modifica los datos y permisos de {{ $usuario->name }}.
            </p>

        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <form method="POST"
                  action="{{ route('usuarios.update', $usuario) }}">

                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-5">

                    <label for="name"
                           class="block text-sm font-medium text-slate-700 mb-2">
                        Nombre
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $usuario->name) }}"
                        required
                        class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Correo --}}
                <div class="mb-5">

                    <label for="email"
                           class="block text-sm font-medium text-slate-700 mb-2">
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $usuario->email) }}"
                        required
                        class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                    {{-- Rol --}}
<div class="mb-5">

    <label
        for="role"
        class="block text-sm font-medium text-slate-700 mb-2">

        Rol

    </label>

    <select
        id="role"
        name="role"
        required
        class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500">

        <option value="">
            Selecciona un rol
        </option>

        @foreach($roles as $role)

            <option
                value="{{ $role }}"
                @selected(old('role', $usuario->getRoleNames()->first()) === $role)>

                {{ $role }}

            </option>

        @endforeach

    </select>

    @error('role')
        <p class="mt-1 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

</div>

                {{-- Contraseña --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

                    <div>

                        <label for="password"
                               class="block text-sm font-medium text-slate-700 mb-2">
                            Nueva contraseña
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500"
                        >

                        <p class="text-xs text-slate-400 mt-1">
                            Déjala vacía para conservar la actual.
                        </p>

                        @error('password')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div>

                        <label for="password_confirmation"
                               class="block text-sm font-medium text-slate-700 mb-2">
                            Confirmar contraseña
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500"
                        >

                    </div>

                </div>

                {{-- Sucursales y áreas --}}
                <div class="mb-6">

                    <label class="block text-sm font-medium text-slate-700 mb-3">
                        Sucursales y áreas asignadas
                    </label>

                    <div class="space-y-4">

                        @forelse($sucursales as $sucursal)

                            @php
                                $sucursalSeleccionada = $usuario->sucursales
                                    ->contains('id', $sucursal->id);
                            @endphp

                            <div class="border border-slate-200 rounded-xl overflow-hidden">

                                {{-- Sucursal --}}
                                <div class="bg-slate-50 px-4 py-3">

                                    <label class="flex items-center gap-3 cursor-pointer">

                                        <input
                                            type="checkbox"
                                            name="sucursales[]"
                                            value="{{ $sucursal->id }}"
                                            id="sucursal_{{ $sucursal->id }}"
                                            @checked(
                                                in_array(
                                                    $sucursal->id,
                                                    old('sucursales', $usuario->sucursales->pluck('id')->toArray())
                                                )
                                            )
                                            class="sucursal-checkbox rounded border-slate-300 text-slate-800 focus:ring-slate-500"
                                            data-sucursal="{{ $sucursal->id }}"
                                        >

                                        <span class="font-semibold text-slate-700">
                                            {{ $sucursal->nombre }}
                                        </span>

                                    </label>

                                </div>

                                {{-- Áreas --}}
                                <div class="px-4 py-3 bg-white">

                                    @forelse($sucursal->areas as $area)

                                        <label class="flex items-center gap-3 py-2 ml-6">

                                            <input
                                                type="checkbox"
                                                name="areas[]"
                                                value="{{ $area->id }}"
                                                @checked(
                                                    in_array(
                                                        $area->id,
                                                        old('areas', $usuario->areas->pluck('id')->toArray())
                                                    )
                                                )
                                                class="area-checkbox rounded border-slate-300 text-slate-800 focus:ring-slate-500"
                                                data-sucursal="{{ $sucursal->id }}"
                                            >

                                            <span class="text-sm text-slate-600">
                                                {{ $area->nombre }}
                                            </span>

                                        </label>

                                    @empty

                                        <p class="ml-6 text-sm text-slate-400">
                                            Esta sucursal no tiene áreas registradas.
                                        </p>

                                    @endforelse

                                </div>

                            </div>

                        @empty

                            <p class="text-sm text-slate-500">
                                No existen sucursales registradas.
                            </p>

                        @endforelse

                    </div>

                    @error('sucursales')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    @error('areas')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Botones --}}
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('usuarios.index') }}"
                       class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="px-5 py-2 rounded-lg bg-slate-800 text-white hover:bg-slate-700">
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sucursales = document.querySelectorAll('.sucursal-checkbox');

            sucursales.forEach(function (sucursal) {

                const sucursalId = sucursal.dataset.sucursal;

                const areas = document.querySelectorAll(
                    `.area-checkbox[data-sucursal="${sucursalId}"]`
                );

                function actualizarAreas() {

                    areas.forEach(function (area) {

                        area.disabled = !sucursal.checked;

                        if (!sucursal.checked) {
                            area.checked = false;
                        }

                    });

                }

                sucursal.addEventListener('change', actualizarAreas);

                actualizarAreas();
            });

        });
    </script>

</x-app-layout>