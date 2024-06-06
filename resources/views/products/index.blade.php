@extends('layouts.template')


@section('title', 'Productos')

@section('content')
    <section class="pt-16 ml-0 lg:ml-64 ">
        <div class="h-full p-4 text-white sm:p-8">
            <div class="flex items-center gap-2 justify-left">
                <h1 class="font-bold uppercase text-1xl text-violet-600 sm:text-2xl">Inventario</h1>
            </div>
            <div class="mt-4">
                <div class="flex flex-col items-start justify-between gap-4 mb-5 sm:flex-row sm:items-center">
                    <h6 class="text-sm text-gray-400">Lista de productos</h6>
                    <a href="{{ route('products.create') }}"
                        class="flex items-center justify-center gap-2 px-4 py-2 text-sm text-white border rounded bg-violet-600 border-violet-600 hover:bg-violet-800 hover:text-white">
                        <x:svg-icon icon="add-circle" class="w-5 h-5 text-current" />
                        Nuevo producto
                    </a>
                </div>
                <div class="hidden w-full overflow-hidden overflow-x-auto rounded sm:block customScrollbar">
                    <table class="w-full text-left">
                        <thead class="text-white bg-zinc-900">
                            <tr>
                                <th class="px-6 py-6 text-sm font-medium leading-4">
                                    #
                                </th>
                                <th class="px-6 py-6 text-sm font-medium leading-4">
                                    Foto
                                </th>
                                <th class="px-6 py-6 text-sm font-medium leading-4">
                                    Nombre
                                </th>
                                <th class="px-6 py-6 text-sm font-medium leading-4">
                                    Descripción
                                </th>
                                <th class="px-6 py-6 text-sm font-medium leading-4">
                                    Precio
                                </th>
                                <th class="px-6 py-6 text-sm font-medium leading-4">
                                    Stock
                                </th>
                                <th class="px-6 py-6 text-sm font-medium leading-4">
                                    Estado
                                </th>
                                <th class="px-6 py-6 text-sm font-medium leading-4">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-white">
                            @forelse ($products as $product)
                                <tr class="border-t-4 border-black bg-zinc-950">
                                    <td class="px-6 py-2 text-sm border-b-4 border-black whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-2 text-sm border-b-4 border-black whitespace-nowrap">
                                        <div class="w-12 h-12 overflow-hidden rounded-full">
                                            <img src="{{ asset('images/products/' . $product->image) }}"
                                                alt="Image profile {{ $product->name }}" class="object-cover w-full h-full">
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 text-sm border-b-4 border-black whitespace-nowrap">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-2 text-sm border-b-4 border-black whitespace-nowrap">
                                        {{ $product->description }}
                                    </td>
                                    <td
                                        class="px-6 py-2 text-sm font-semibold border-b-4 border-black whitespace-nowrap text-violet-600">
                                        {{ "$" . $product->price }}
                                    </td>
                                    <td class="px-6 py-2 text-sm border-b-4 border-black whitespace-nowrap">
                                        {{ $product->stockCurrent }}
                                    </td>
                                    <td class="px-6 py-2 text-sm border-b-4 border-black whitespace-nowrap">
                                        @switch($product->status)
                                            @case('in_stock')
                                                <span
                                                    class="px-4 py-1 text-xs text-green-200 uppercase bg-green-600 bg-opacity-20 rounded-xl">
                                                    Disponible
                                                </span>
                                            @break

                                            @case('out_of_stock')
                                                <span
                                                    class="px-4 py-1 text-xs text-red-200 uppercase bg-red-600 bg-opacity-20 rounded-xl">
                                                    Agotado
                                                </span>
                                            @break

                                            @case('warning')
                                                <span
                                                    class="px-4 py-1 text-xs text-yellow-200 uppercase bg-yellow-600 bg-opacity-20 rounded-xl">
                                                    Por agotarse
                                                </span>

                                                @default
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-2 border-b-4 border-black">
                                            <div class="flex gap-2 text-sm">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="flex items-center justify-center gap-2 px-2 py-2 text-green-600 rounded hover:bg-zinc-900">
                                                    <x:svg-icon icon="edit" class="w-5 h-5 text-current" />
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                    id="formDeleteProduct">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="flex items-center justify-center gap-2 px-2 py-2 text-red-600 rounded btnDeleteProduct hover:bg-zinc-800">
                                                        <x:svg-icon icon="trash" class="w-5 h-5 text-current" />
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr class="text-center border-t-2 border-black bg-zinc-950">
                                            <td class="px-6 py-4 text-sm border-b-2 border-black" colspan="7">
                                                No hay productos registrados
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        @endsection
