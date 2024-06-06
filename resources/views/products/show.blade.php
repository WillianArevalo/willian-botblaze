@extends('layouts.template')

@section('title', 'Producto')

@section('content')
    <section class="pt-16 ml-0 lg:ml-64 ">
        <div class="h-full p-4 text-white sm:p-8">
            <div class="flex items-center justify-between gap-2">
                <h1 class="font-bold uppercase text-1xl text-violet-600 sm:text-3xl">Detalle del producto</h1>
                <a href="{{ route('products.index') }}"
                    class="flex items-center justify-center gap-2 p-3 px-5 text-white rounded bg-zinc-950">
                    <x:svg-icon icon="arrow-turn" class="w-5 h-5 text-current" />
                    Regresar
                </a>
            </div>
            <div class="mt-4 rounded bg-zinc-950">
                <div class="flex flex-col items-start">
                    <div class="flex items-center justify-between flex-1 w-full p-5 border-b border-zinc-900">
                        <h2>
                            <span class="text-base text-gray-400">Nombre:</span>
                            <span class="text-2xl font-semibold text-white">{{ $product->name }}</span>
                        </h2>
                        <div class="flex flex-col">
                            @switch($product->status)
                                @case('in_stock')
                                    <span
                                        class="px-5 py-1 text-green-200 uppercase bg-green-600 text-1xl bg-opacity-20 rounded-2xl w-max">
                                        Disponible
                                    </span>
                                @break

                                @case('out_of_stock')
                                    <span
                                        class="px-5 py-1 text-red-200 uppercase bg-red-600 text-1xl bg-opacity-20 rounded-2xl w-max">
                                        Agotado
                                    </span>
                                @break

                                @case('warning')
                                    <span
                                        class="px-5 py-1 text-yellow-200 uppercase bg-yellow-600 text-1xl bg-opacity-20 rounded-2xl w-max">
                                        Por agotarse
                                    </span>

                                    @default
                                @endswitch
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-1 w-full gap-2 p-4">
                        <div class="flex items-center justify-center flex-1 p-5">
                            <div class="w-full h-full overflow-hidden rounded">
                                <img src="{{ asset('images/products/' . $product->image) }}"
                                    alt="Image profile {{ $product->name }}" class="object-cover w-full h-full">
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 gap-4 p-4">
                            <div class="flex flex-col gap-2">
                                <label for="price" class="text-base text-gray-400">Precio:</label>
                                <p class="text-2xl font-semibold text-violet-600">{{ "$" . $product->price }}</p>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex-1 p-4 rounded bg-zinc-900">
                                    <label for="stock" class="text-gray-400 text-md">Cantidad inicial:</label>
                                    <p class="text-lg font-semibold text-white">{{ $product->stockInitial }}</p>
                                </div>
                                <div class="flex-1 p-4 rounded bg-zinc-900">
                                    <label for="stock" class="text-base text-gray-400">Cantidad actual:</label>
                                    <p class="text-lg font-semibold text-white">{{ $product->stockCurrent }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col h-full gap-2 p-4 rounded bg-zinc-900">
                                <label for="price" class="text-base text-gray-400">Descripción:</label>
                                <p class="text-base text-wrap">{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
