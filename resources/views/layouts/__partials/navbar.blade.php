<header
    class="top-0 z-20 hidden w-full h-screen p-5 text-sm text-white border-r lg:fixed border-zinc-900 sm:w-1/2 md:w-1/3 lg:w-auto lg:block adminHeader sm:text-base">
    <button
        class="absolute top-0 right-0 p-2 m-4 text-current rounded bg-zinc-900 hover:bg-zinc-950 buttonClose lg:hidden">
        <x:svg-icon icon="close" class="w-5 h-5 text-current" />
    </button>
    <nav class="flex flex-col w-full h-full gap-10 lg:w-52">
        <div class="flex flex-col items-center gap-3">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="object-cover w-24 h-24 rounded-full">
            <p href="{{ route('dashboard') }}" class="text-lg font-bold uppercase text-violet-600 hover:text-violet-800">
                Botblaze
            </p>
        </div>
        <ul class="flex flex-col h-full gap-4">
            <li
                class=" rounded  {{ Request::is('dashboard') ? 'text-violet-700 border border-violet-700 hover:bg-violet-700 hover:text-white' : 'hover:bg-zinc-900' }}">
                <a href="{{ route('dashboard') }}" class="flex gap-2 p-2">
                    <span class="flex items-center justify-center text-current">
                        <x:svg-icon icon="dashboard" class="w-5 h-5 text-current" />
                    </span>
                    Dashboard
                </a>
            </li>
            <li
                class="rounded   {{ Request::is('products') || Request::is('products/create') ? 'text-violet-700 border border-violet-700 hover:bg-violet-700 hover:text-white' : 'hover:bg-zinc-900' }}">
                <a href="{{ route('products.index') }}" class="flex gap-2 p-2">
                    <span class="flex items-center justify-center">
                        <x:svg-icon icon="package" class="w-5 h-5 text-current" />
                    </span>
                    Productos
                </a>
            </li>
            <li
                class="rounded   {{ Request::is('movements') || Request::is('movements/input') || Request::is('movements/output') ? 'text-violet-700 border border-violet-700 hover:bg-violet-700 hover:text-white' : 'hover:bg-zinc-900' }}">
                <a href="{{ route('movements.index') }}" class="flex gap-2 p-2">
                    <span class="flex items-center justify-center text-current">
                        <x:svg-icon icon="arrow-left-right" class="w-5 h-5 text-current" />
                    </span>
                    Movimientos
                </a>
            </li>
        </ul>
    </nav>
</header>
