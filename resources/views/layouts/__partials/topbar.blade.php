<section>
    <div
        class="absolute right-0 z-10 w-full px-4 py-3 text-white bg-black border-b border-zinc-900 topBar sm:px-8 lg:fixed">
        <div class="flex items-center justify-between text-sm lg:justify-end sm:text-base">
            <button
                class="flex items-center justify-end p-2 border-none rounded bg-zinc-900 hover:bg-zinc-950 lg:hidden buttonHamburger">
                <x:svg-icon icon="menu" class="w-6 h-6 text-white" />
            </button>
            <div class="relative flex items-center justify-center gap-4">
                <img src="{{ auth()->user()->photo }}" alt="Imagen perfil usuario"
                    class="object-cover w-10 h-10 rounded-full cursor-pointer userImage">
                <div
                    class="absolute right-0 overflow-hidden border rounded w-60 bg-zinc-950 top-11 userMenu border-zinc-900">
                    <div class="w-full">
                        <ul class="flex flex-col">
                            <li class="flex flex-col gap-2 px-4 py-3 font-bold border-b border-zinc-900">
                                <span class="px-4 py-1 text-sm text-white truncate rounded bg-violet-600"
                                    title="{{ auth()->user()->name }}">
                                    {{ auth()->user()->name }}
                                </span>
                                <span class="text-sm font-normal truncate text-zinc-400">
                                    {{ auth()->user()->email }}
                                </span>
                                <span
                                    class="px-3 py-1 text-sm font-normal text-green-200 uppercase truncate bg-green-800 rounded bg-opacity-15 w-max">
                                    {{ auth()->user()->status }}
                                </span>
                            </li>
                            <li class="border-t border-zinc-900">
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center justify-start w-full h-full gap-3 px-5 py-3 hover:bg-zinc-800">
                                        <x:svg-icon icon="logout" class="w-6 h-6 text-white" />
                                        Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
