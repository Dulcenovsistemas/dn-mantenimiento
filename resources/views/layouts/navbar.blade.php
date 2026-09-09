<nav class="bg-white border-b border-slate-200 h-20 px-8 flex items-center">

    {{-- Título --}}
    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Dashboard
        </h1>
    </div>

    {{-- Controles de la derecha --}}
    <div class="ml-auto flex items-center gap-5">

        {{-- Selector de sucursal --}}
        <form method="POST" action="{{ route('sucursal.cambiar') }}">
            @csrf

            <select
                name="sucursal_id"
                onchange="this.form.submit()"
                class="w-64 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-700 outline-none focus:border-blue-500 focus:ring-blue-500">

                @foreach(auth()->user()->sucursales as $sucursal)

                    <option
                        value="{{ $sucursal->id }}"
                        @selected(session('sucursal_id') == $sucursal->id)>
                        {{ $sucursal->nombre }}
                    </option>

                @endforeach

            </select>
        </form>

        {{-- Notificaciones --}}
        <button
            class="rounded-xl border border-slate-200 px-4 py-2 hover:bg-slate-100">
            🔔
        </button>

        {{-- Usuario --}}
        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

    </div>

</nav>