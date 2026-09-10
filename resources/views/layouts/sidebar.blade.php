
<aside
    id="sidebar"
    class="w-72 bg-white border-r border-slate-200 flex flex-col transition-all duration-300"
>

    {{-- Logo / Encabezado --}}
    <div class="h-20 px-5 flex items-center border-b border-slate-200">

        <div id="sidebar-logo" class="flex-1 flex items-center justify-center">
                {{-- Logo completo --}}
                <img
                    id="logo-completo"
                    src="{{ asset('images/logos/picto-pajaro.png') }}"
                    alt="Mantenimiento"
                    class="h-10 w-auto object-contain"
                >

            

        </div>

        {{-- Botón contraer --}}
        <button
            type="button"
            onclick="toggleSidebar()"
            class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition"
            title="Contraer menú"
        >
            <svg
                id="sidebar-arrow"
                class="w-5 h-5 transition-transform duration-300"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
        </button>

    </div>


    {{-- Menú --}}
    <nav class="flex-1 px-4 py-6">

        {{-- Categoría --}}
        <p
            id="menu-general"
            class="menu-label text-xs uppercase text-slate-400 px-4 mb-3"
        >
            General
        </p>

        <div class="space-y-1">

            {{-- Dashboard --}}
            <a
                href="{{ route('dashboard') }}"
                class="menu-item flex items-center gap-3 rounded-xl bg-blue-50 px-4 py-3 font-medium text-blue-600"
                title="Dashboard"
            >

                {{-- Icono --}}
                <svg
                    class="menu-icon w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"
                    />
                </svg>

                <span class="menu-text">
                    Dashboard
                </span>

            </a>


            {{-- Órdenes --}}
            <a
                href="{{ route('ordenes.index') }}"
                class="menu-item flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100"
                title="Órdenes de Trabajo"
            >

                <svg
                    class="menu-icon w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"
                    />
                </svg>

                <span class="menu-text">
                    Órdenes de Trabajo
                </span>

            </a>


            {{-- Equipos --}}
            <a
                href="{{ route('equipos.index') }}"
                class="menu-item flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100"
                title="Equipos"
                >

                <svg
                    class="menu-icon w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10.5 6h3m-7.5 4h15M6 14h12m-9 4h6"
                    />
                </svg>

                <span class="menu-text">
                    Equipos
                </span>

            </a>


            {{-- Preventivos --}}
            <a
                href="#"
                class="menu-item flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100"
                title="Preventivos"
            >

                <svg
                    class="menu-icon w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>

                <span class="menu-text">
                    Preventivos
                </span>

            </a>


            {{-- Inventario --}}
            <a
                href="#"
                class="menu-item flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100"
                title="Inventario"
            >

                <svg
                    class="menu-icon w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0v10l-8 4-8-4V7m16 0l-8 4m-8-4l8 4m0 0v10"
                    />
                </svg>

                <span class="menu-text">
                    Inventario
                </span>

            </a>

        </div>


        {{-- Administración --}}
        <p
            id="menu-admin"
            class="menu-label text-xs uppercase text-slate-400 px-4 mt-10 mb-3"
        >
            Administración
        </p>

        <div class="space-y-1">

            {{-- Usuarios --}}
            <a
                href="{{ route('usuarios.index') }}"
                class="menu-item flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100"
                title="Usuarios"
            >

                <svg
                    class="menu-icon w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m6-10a4 4 0 100-8 4 4 0 000 8zm10 10v-2a4 4 0 00-3-3.87m-1-8a4 4 0 110 8"
                    />
                </svg>

                <span class="menu-text">
                    Usuarios
                </span>

            </a>


            {{-- Sucursales --}}
            <a
                href="{{ route('sucursales.index') }}"
                class="menu-item flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100"
                title="Sucursales"
            >

                <svg
                    class="menu-icon w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 21h18M5 21V5l7-3 7 3v16M9 21v-4h6v4M9 8h1m4 0h1m-6 4h1m4 0h1"
                    />
                </svg>

                <span class="menu-text">
                    Sucursales
                </span>

            </a>


            {{-- Configuración --}}
            <a
                href="#"
                class="menu-item flex items-center gap-3 rounded-xl px-4 py-3 text-slate-600 hover:bg-slate-100"
                title="Configuración"
            >

                <svg
                    class="menu-icon w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10.3 4.3a1 1 0 013.4 0l.4.8a1 1 0 001.1.5l.9-.2a1 1 0 011.7 1.7l-.2.9a1 1 0 00.5 1.1l.8.4a1 1 0 010 3.4l-.8.4a1 1 0 00-.5 1.1l.2.9a1 1 0 01-1.7 1.7l-.9-.2a1 1 0 00-1.1.5l-.4.8a1 1 0 01-3.4 0l-.4-.8a1 1 0 00-1.1-.5l-.9.2a1 1 0 01-1.7-1.7l.2-.9a1 1 0 00-.5-1.1l-.8-.4a1 1 0 010-3.4l.8-.4a1 1 0 00.5-1.1l-.2-.9a1 1 0 011.7-1.7l.9.2a1 1 0 001.1-.5l.4-.8z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                </svg>

                <span class="menu-text">
                    Configuración
                </span>

            </a>

        </div>

    </nav>


 
    {{-- Usuario --}}
    <div
        id="user-section"
        class="border-t border-slate-200 p-5 relative"
    >

        <button
            type="button"
            onclick="toggleUserMenu()"
            class="w-full text-left"
        >

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">

                    {{-- Avatar --}}
                    <div
                        class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-semibold flex-shrink-0"
                    >
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    {{-- Información usuario --}}
                    <div class="menu-text">

                        <div class="font-semibold text-slate-700">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="text-sm text-slate-500">
                            {{ auth()->user()->email }}
                        </div>

                    </div>

                </div>

                {{-- Flecha --}}
                <svg
                    id="user-arrow"
                    class="menu-text w-5 h-5 text-slate-400 transition-transform"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>

            </div>

        </button>


        {{-- Menú usuario --}}
        <div
            id="user-menu"
            class="hidden mt-3 space-y-1"
        >

            {{-- Perfil --}}
            <a
                href="#"
                class="flex items-center px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-slate-100"
            >
                Perfil
            </a>


            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button
                    type="submit"
                    class="w-full text-left px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50"
                >
                    Cerrar sesión
                </button>

            </form>

        </div>

    </div>

</aside>


<script>

    function toggleSidebar() {

        const sidebar = document.getElementById('sidebar');

        const texts = document.querySelectorAll('.menu-text');
        const labels = document.querySelectorAll('.menu-label');

        const arrow = document.getElementById('sidebar-arrow');

        const logoCompleto = document.getElementById('logo-completo');
        const logoMini = document.getElementById('logo-mini');

        const userMenu = document.getElementById('user-menu');


        // Cambiar ancho
        sidebar.classList.toggle('w-72');
        sidebar.classList.toggle('w-20');

        const collapsed = sidebar.classList.contains('w-20');


        // Ocultar textos
        texts.forEach(element => {
            element.classList.toggle('hidden', collapsed);
        });


        // Ocultar títulos de sección
        labels.forEach(element => {
            element.classList.toggle('hidden', collapsed);
        });


        // Centrar iconos
        document.querySelectorAll('.menu-item').forEach(item => {

            item.classList.toggle('justify-center', collapsed);

            item.classList.toggle('px-4', !collapsed);
            item.classList.toggle('px-0', collapsed);

        });


        // Cambiar logo
        logoCompleto.classList.toggle('hidden', collapsed);
        logoMini.classList.toggle('hidden', !collapsed);


        // Rotar flecha principal
        arrow.classList.toggle('rotate-180', collapsed);


        // Cerrar menú de usuario al contraer
        if (collapsed) {

            userMenu.classList.add('hidden');

        }

    }
    
    function toggleUserMenu() {

    const menu = document.getElementById('user-menu');
    const arrow = document.getElementById('user-arrow');
    const sidebar = document.getElementById('sidebar');

    const collapsed = sidebar.classList.contains('w-20');


    if (collapsed) {

        // Menú flotante
        menu.classList.toggle('hidden');

        menu.classList.toggle(
            'absolute',
            !menu.classList.contains('hidden')
        );

        menu.classList.toggle(
            'left-full',
            !menu.classList.contains('hidden')
        );

        menu.classList.toggle(
            'bottom-4',
            !menu.classList.contains('hidden')
        );

        menu.classList.toggle(
            'ml-3',
            !menu.classList.contains('hidden')
        );

        menu.classList.toggle(
            'bg-white',
            !menu.classList.contains('hidden')
        );

        menu.classList.toggle(
            'border',
            !menu.classList.contains('hidden')
        );

        menu.classList.toggle(
            'border-slate-200',
            !menu.classList.contains('hidden')
        );

        menu.classList.toggle(
            'rounded-xl',
            !menu.classList.contains('hidden')
        );

        menu.classList.toggle(
            'shadow-lg',
            !menu.classList.contains('hidden')
        );

        menu.classList.toggle(
            'p-2',
            !menu.classList.contains('hidden')
        );

        menu.classList.toggle(
            'w-44',
            !menu.classList.contains('hidden')
        );

    } else {

        // Menú normal
        menu.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');

    }

}

</script>

