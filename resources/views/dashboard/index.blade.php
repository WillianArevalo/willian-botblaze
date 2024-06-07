@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
    <section>
        <div class="flex flex-col w-full xl:flex-row">
            <div class="flex flex-col flex-1 gap-2 p-4 sm:p-8">
                <h1 class="text-4xl font-bold text-violet-600">Dashboard</h1>
                <div>
                    <p class="font-light text-md text-zinc-300">Bienvenido a tu panel de control</p>
                </div>
                <div class="flex flex-wrap gap-4 mt-4 text-white">
                    <div class="flex flex-col gap-2 p-6 rounded bg-zinc-950">
                        <h2 class="text-2xl font-bold text-violet-500">Usuarios</h2>
                        <span class="text-2xl ">{{ $userCount }}</span>
                    </div>
                    <div class="flex flex-col gap-2 p-6 rounded bg-zinc-950">
                        <h2 class="text-2xl font-bold text-violet-500">Productos</h2>
                        <span class="text-2xl ">{{ $productCount }}</span>
                    </div>
                    <div class="flex flex-col gap-2 p-6 rounded bg-zinc-950">
                        <h2 class="text-2xl font-bold text-violet-500">Movimientos</h2>
                        <span class="text-2xl ">{{ $movementCount }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col flex-1 w-full gap-2">
                <div class="flex flex-col gap-3 p-4 sm:p-8">
                    <h2 class="text-2xl font-bold text-violet-600">Últimos movimientos</h2>
                    <div class="flex flex-col gap-3">
                        @foreach ($movements as $movement)
                            <div class="flex flex-col w-full gap-5 p-4 rounded sm:flex-row bg-zinc-950">
                                <h6 class="text-gray-200"><span class="font-semibold text-violet-600">Fecha:</span>
                                    {{ $movement->date }}</h6>
                                <h6 class="text-gray-400"><span class="font-semibold text-violet-600">Cantidad:
                                    </span>{{ $movement->quantity }}</h6>
                                <h6 class="text-gray-400 sm:ml-auto">
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
                                </h6>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('movements.input') }}"
                        class="flex items-center justify-center gap-2 p-3 mt-4 border-2 border-dashed rounded border-violet-600 text-violet-600 hover:bg-violet-600 hover:text-white">
                        <x:svg-icon icon="add-circle" class="w-6 h-6 text-current" />
                        <span>Registrar entrada</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
