<x-app-layout>

    <div class="max-w-4xl mx-auto px-6 py-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">
                Nuevo usuario
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Registra un usuario y asigna las sucursales a las que tendrá acceso.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <form method="POST" action="{{ route('usuarios.store') }}">

                @csrf

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
                        value="{{ old('name') }}"
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
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                    <div>
                        <label for="password"
                               class="block text-sm font-medium text-slate-700 mb-2">
                            Contraseña
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500"
                        >

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
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500"
                        >
                    </div>

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

                        <option
                            value="Admin"
                            @selected(old('role') === 'Admin')>
                            Administrador
                        </option>

                        <option
                            value="Supervisor"
                            @selected(old('role') === 'Supervisor')>
                            Supervisor
                        </option>

                        <option
                            value="Tecnico"
                            @selected(old('role') === 'Tecnico')>
                            Técnico
                        </option>

                    </select>

                    @error('role')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Sucursales y áreas --}}
                <div class="mb-6">

                    <label class="block text-sm font-medium text-slate-700 mb-3">
                        Sucursales y áreas asignadas
                    </label>

                    <div class="space-y-4">

                        @forelse($sucursales as $sucursal)

                            <div class="border border-slate-200 rounded-xl overflow-hidden">

                                {{-- Sucursal --}}
                                <div class="bg-slate-50 px-4 py-3">

                                    <label class="flex items-center gap-3 cursor-pointer">

                                        <input
                                            type="checkbox"
                                            name="sucursales[]"
                                            value="{{ $sucursal->id }}"
                                            id="sucursal_{{ $sucursal->id }}"
                                            @checked(in_array($sucursal->id, old('sucursales', [])))
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
                                                @checked(in_array($area->id, old('areas', [])))
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

                            <div class="border border-slate-200 rounded-xl p-4">
                                <p class="text-sm text-slate-500">
                                    No existen sucursales registradas.
                                </p>
                            </div>

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
                        Crear usuario
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>