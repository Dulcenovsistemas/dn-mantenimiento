<aside class="w-72 bg-white border-r border-slate-200 flex flex-col">

    {{-- Logo --}}
    <div class="h-20 px-8 flex items-center border-b border-slate-200">

        <div>

            <h1 class="text-xl font-bold text-slate-800">
                APP
            </h1>

            <p class="text-sm text-slate-500">
                Mantenimiento
            </p>

        </div>

    </div>

    {{-- Menú --}}
    <nav class="flex-1 px-4 py-6">

        <p class="text-xs uppercase text-slate-400 px-4 mb-3">

            General

        </p>

        <div class="space-y-1">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 rounded-xl bg-blue-50 px-4 py-3 font-medium text-blue-600">

                Dashboard

            </a>

            <a href="{{ route('ordenes.index') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100">

                Órdenes de Trabajo

            </a>

            <a href="{{ route('equipos.index') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100">

                Equipos

            </a>

            <a href="#"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100">

                Preventivos

            </a>

            <a href="#"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100">

                Inventario

            </a>

        </div>

        <p class="text-xs uppercase text-slate-400 px-4 mt-10 mb-3">

            Administración

        </p>

        <div class="space-y-1">

            <a href="{{ route('usuarios.index') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100">

                Usuarios

            </a>

            <a href="{{ route('sucursales.index') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100">

                Sucursales

            </a>

            <a href="#"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100">

                Configuración

            </a>

        </div>

    </nav>

    {{-- Usuario --}}
    <div class="border-t border-slate-200 p-5">

        <div class="font-semibold text-slate-700">

            {{ auth()->user()->name }}

        </div>

        <div class="text-sm text-slate-500">

            {{ auth()->user()->email }}

        </div>

    </div>

</aside>