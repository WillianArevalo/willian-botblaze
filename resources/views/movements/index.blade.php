@extends('layouts.template')


@section('title', 'Movimientos')

@section('content')
    <section class="pt-16 ml-0 text-sm lg:ml-64 sm:text-base">
        <div class="h-full p-4 text-white sm:p-8">
            <div class="flex items-center gap-2 justify-left">
                <h1 class="text-2xl font-bold uppercase text-violet-600 sm:text-3xl">Movimientos</h1>
            </div>
            <div class="mt-4">
                <div class="flex flex-col items-start justify-between gap-4 mb-5 sm:flex-row sm:items-center">
                    <h6 class="text-gray-400 ">Lista de movimientos</h6>
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('movements.input') }}"
                            class="flex items-center justify-center gap-2 px-4 py-3 text-green-500 bg-green-700 rounded hover:bg-opacity-20 bg-opacity-10">
                            <x:svg-icon icon="input" class="w-5 h-5 text-current" />
                            Registrar entrada
                        </a>
                        <a href="{{ route('movements.output') }}"
                            class="flex items-center justify-center gap-2 px-4 py-3 text-red-500 bg-red-700 rounded hover:bg-opacity-20 bg-opacity-10">
                            <x:svg-icon icon="output" class="w-5 h-5 text-current" />
                            Registrar salida
                        </a>
                    </div>
                </div>
                <div class="hidden w-full overflow-hidden overflow-x-auto rounded sm:block customScrollbar">
                    <table class="w-full text-left">
                        <thead class="text-white bg-zinc-900">
                            <tr>
                                <th class="px-6 py-6 font-medium leading-4">
                                    #
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Tipo
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Cantidad
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Descripción
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Fecha
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-white">
                            @forelse ($movements as $movement)
                                <tr class="border-t-4 border-black bg-zinc-950">
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        @switch($movement->typeMovement)
                                            @case('input')
                                                <span class="px-4 py-1 text-green-200 bg-green-600 bg-opacity-20 rounded-3xl">
                                                    Entrada
                                                </span>
                                            @break

                                            @case('output')
                                                <span class="px-4 py-1 text-red-200 bg-red-600 bg-opacity-20 rounded-3xl">
                                                    Salida
                                                </span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        {{ $movement->quantity }}
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        {{ $movement->description }}
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        {{ $movement->date }}
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black">
                                        <div class="flex gap-2 ">
                                            <a href="{{ route('movements.edit', $movement->id) }}"
                                                class="flex items-center justify-center gap-2 px-2 py-2 text-green-500 rounded hover:bg-green-700 hover:bg-opacity-10">
                                                <x:svg-icon icon="edit" class="w-5 h-5 text-current" />
                                            </a>
                                            <form action="{{ route('movements.destroy', $movement->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="flex items-center justify-center gap-2 px-2 py-2 text-red-600 rounded hover:bg-red-700 hover:bg-opacity-10 btnDeleteMovement">
                                                    <x:svg-icon icon="trash" class="w-5 h-5 text-current" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr class="text-center border-t-2 border-black bg-zinc-950">
                                        <td class="px-6 py-4 border-b-2 border-black" colspan="7">
                                            No hay movimientos registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $movements->links() }}
                    </div>
                </div>
                <div class="flex sm:hidden">
                    <div class="flex flex-col w-full gap-4">
                        @forelse ($movements as $movement)
                            <div class="flex flex-col gap-2 rounded bg-zinc-950">
                                <div class="flex items-center justify-between px-4 py-2">
                                    <h6 class="text-gray-400 ">Tipo:</h6>
                                    @switch($movement->typeMovement)
                                        @case('input')
                                            <span class="px-4 py-1 text-green-200 bg-green-600 bg-opacity-20 rounded-3xl">
                                                Entrada
                                            </span>
                                        @break

                                        @case('output')
                                            <span class="px-4 py-1 text-red-200 bg-red-600 bg-opacity-20 rounded-3xl">
                                                Salida
                                            </span>
                                        @break
                                    @endswitch
                                </div>
                                <div class="flex flex-wrap items-center justify-between px-4 py-2">
                                    <h6 class="text-gray-400 ">Cantidad:</h6>
                                    <span class="text-white ">{{ $movement->quantity }}</span>
                                </div>
                                <div class="flex flex-wrap items-center justify-between px-4 py-2">
                                    <h6 class="text-gray-400 ">Descripción:</h6>
                                    <span class="text-white ">{{ $movement->description }}</span>
                                </div>
                                <div class="flex items-center justify-between px-4 py-2">
                                    <h6 class="text-gray-400 ">Fecha:</h6>
                                    <span class="text-white ">{{ $movement->date }}</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-b bg-zinc-900">
                                    <div class="flex gap-2 ">
                                        <a href="{{ route('movements.edit', $movement->id) }}"
                                            class="flex items-center justify-center gap-2 px-2 py-2 text-green-500 bg-green-700 rounded bg-opacity-10 hover:bg-opacity-20">
                                            <x:svg-icon icon="edit" class="w-5 h-5 text-current" />
                                        </a>
                                        <form action="{{ route('movements.destroy', $movement->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="flex items-center justify-center gap-2 px-2 py-2 text-red-600 bg-red-700 rounded bg-opacity-10 hover:bg-opacity-20 btnDeleteMovement">
                                                <x:svg-icon icon="trash" class="w-5 h-5 text-current" />
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="flex flex-col gap-2 p-4 rounded bg-zinc-950">
                                    <h6 class="text-center text-gray-400 ">No hay movimientos registrados</h6>
                                </div>
                            @endforelse
                        </div>
                    </div>
            </section>
        @endsection
