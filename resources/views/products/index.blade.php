@extends('layouts.template')


@section('title', 'Productos')

@section('content')
    <section class="text-sm sm:text-base">
        <div class="p-4 text-white sm:p-8">
            <div class="flex items-center gap-2 justify-left">
                <h1 class="text-2xl font-bold uppercase text-violet-600 sm:text-3xl">Inventario</h1>
            </div>
            <div class="mt-4">
                <div class="flex flex-col items-start justify-between gap-4 mb-5 sm:flex-row sm:items-center">
                    <h6 class="text-gray-400 ">Lista de productos</h6>
                    <a href="{{ route('products.create') }}"
                        class="flex items-center justify-center gap-2 px-4 py-3 rounded text-violet-400 bg-violet-800 bg-opacity-10 hover:bg-opacity-20">
                        <x:svg-icon icon="add-circle" class="w-5 h-5 text-current" />
                        Nuevo producto
                    </a>
                </div>
                <div class="mb-4">
                    <div class="flex flex-col justify-between flex-1 gap-2 sm:flex-row">
                        <div
                            class="flex items-center w-full text-white border-2 rounded bg-zinc-900 focus-within:border-violet-600 border-zinc-800 flex-[2]">
                            <span class="flex items-center justify-center p-2 text-violet-500">
                                <x:svg-icon icon="search" class="w-5 h-5 text-current" />
                            </span>
                            <form action="{{ route('products.search') }}" method="POST" id="formSearch" class="w-full">
                                @csrf
                                <input type="text" name="searchProduct"
                                    class="w-full p-3 pl-5 text-white bg-transparent border-none focus:outline-none placeholder:text-zinc-600"
                                    placeholder="Buscar producto..." id="inputSearchProduct">
                                <input type="hidden" class="window" name="window">
                            </form>
                        </div>
                        <div class="relative flex flex-col flex-1 gap-2 custom-select" id="filtrerStatus">
                            <form action="{{ route('products.search') }}" method="POST" id="formSearchStatus"
                                class="hidden">
                                @csrf
                                <input type="hidden" name="searchStatus" id="searchStatus">
                                <input type="hidden" class="window" name="window">
                            </form>
                            <div
                                class="flex justify-between p-3 pl-5 text-white border-2 rounded selected bg-zinc-900 border-zinc-800">
                                <span class="flex items-center item-selected">
                                    Filtrar por
                                </span>
                                <span class="flex items-center gap-2 ">
                                    <x:svg-icon icon="arrow-down" class="w-5 h-5 text-white arrow-select" />
                                </span>
                            </div>
                            <div
                                class="absolute z-20 flex flex-col w-full overflow-hidden text-black border-2 rounded bg-zinc-100 items-selected top-14 border-zinc-800">
                                <span class="p-3 pl-5 border-b border-zinc-400 hover:bg-zinc-300" data-value="in_stock"
                                    data-input="searchStatus">
                                    Disponible
                                </span>
                                <span class="p-3 pl-5 border-b border-zinc-400 hover:bg-zinc-300" data-value="warning"
                                    data-input="searchStatus">
                                    Por agotarse
                                </span>
                                <span class="p-3 pl-5 border-b border-zinc-400 hover:bg-zinc-300" data-value="out_of_stock"
                                    data-input="searchStatus">
                                    Agotado
                                </span>
                            </div>
                        </div>
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
                                    Foto
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Nombre
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Precio
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Stock inicial
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Stock actual
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Estado
                                </th>
                                <th class="px-6 py-6 font-medium leading-4">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-white" id="tableProduct">
                            @forelse ($products as $product)
                                <tr class="border-t-4 border-black bg-zinc-950">
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        <div class="w-12 h-12 overflow-hidden rounded-full">
                                            <img src="{{ asset('images/products/' . $product->image) }}"
                                                alt="Image profile {{ $product->name }}" class="object-cover w-full h-full">
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        {{ $product->name }}
                                    </td>
                                    <td
                                        class="px-6 py-2 font-semibold border-b-4 border-black whitespace-nowrap text-violet-600">
                                        {{ "$" . $product->price }}
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        {{ $product->stockInitial }}
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        {{ $product->stockCurrent }}
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black whitespace-nowrap">
                                        @switch($product->status)
                                            @case('in_stock')
                                                <span class="px-4 py-1 text-green-200 bg-green-600 bg-opacity-20 rounded-3xl">
                                                    Disponible
                                                </span>
                                            @break

                                            @case('out_of_stock')
                                                <span class="px-4 py-1 text-red-200 bg-red-600 bg-opacity-20 rounded-3xl">
                                                    Agotado
                                                </span>
                                            @break

                                            @case('warning')
                                                <span class="px-4 py-1 text-yellow-200 bg-yellow-600 bg-opacity-20 rounded-3xl">
                                                    Por agotarse
                                                </span>
                                            @break

                                            @default
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-2 border-b-4 border-black">
                                        <div class="flex gap-2 ">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="flex items-center justify-center gap-2 px-2 py-2 text-green-500 rounded hover:bg-green-700 hover:bg-opacity-10">
                                                <x:svg-icon icon="edit" class="w-6 h-6 text-current" />
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="flex items-center justify-center gap-2 px-2 py-2 text-red-600 rounded btnDeleteProduct hover:bg-red-700 hover:bg-opacity-10">
                                                    <x:svg-icon icon="trash" class="w-6 h-6 text-current" />
                                                </button>
                                            </form>
                                            <a href="{{ route('products.show', $product->id) }}"
                                                class="flex items-center justify-center gap-2 px-2 py-2 text-yellow-500 rounded hover:bg-yellow-700 hover:bg-opacity-10">
                                                <x:svg-icon icon="eye" class="w-6 h-6 text-current" />
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr class="text-center border-t-2 border-black bg-zinc-950">
                                        <td class="px-6 py-4 border-b-2 border-black" colspan="8">
                                            No hay productos registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
                <div class="flex sm:hidden">
                    <div class="flex flex-col w-full gap-4" id="cardsProduct">
                        @forelse ($products as $product)
                            <div class="flex flex-col gap-2 rounded bg-zinc-950">
                                <div class="flex items-center justify-between gap-2 p-3 rounded-t bg-zinc-900 headerProduct">
                                    <span>
                                        Nombre:
                                        <span class="text-base font-semibold text-violet-600">
                                            {{ $product->name }}
                                        </span>
                                    </span>
                                    @switch($product->status)
                                        @case('in_stock')
                                            <span class="px-4 py-1 text-green-200 bg-green-600 bg-opacity-20 rounded-3xl">
                                                Disponible
                                            </span>
                                        @break

                                        @case('out_of_stock')
                                            <span class="px-4 py-1 text-red-200 bg-red-600 bg-opacity-20 rounded-3xl">
                                                Agotado
                                            </span>
                                        @break

                                        @case('warning')
                                            <span class="px-4 py-1 text-yellow-200 bg-yellow-600 bg-opacity-20 rounded-3xl">
                                                Por agotarse
                                            </span>
                                        @break

                                        @default
                                    @endswitch
                                </div>
                                <div class="flex bodyProduct">
                                    <div class="flex items-center justify-center flex-1 p-2">
                                        <img src="{{ asset('images/products/' . $product->image) }}" alt=""
                                            class="w-40 h-40">
                                    </div>
                                    <div class="flex flex-col flex-[1] p-3 gap-2 w-full">
                                        <div class="flex flex-col gap-1">
                                            <label for="">Precio</label>
                                            <span class="text-base font-medium text-violet-600">
                                                {{ "$" . $product->price }}
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <div class="flex flex-col p-3 rounded ga-2 bg-zinc-900">
                                                <label for="stockInitial" class="text-zinc-300">Stock inicial</label>
                                                <span>
                                                    {{ $product->stockInitial }}
                                                </span>
                                            </div>
                                            <div class="flex flex-col p-3 rounded ga-2 bg-zinc-900">
                                                <label for="stockCurrent" class="text-zinc-300">Stock actual</label>
                                                <span>
                                                    {{ $product->stockCurrent }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2 p-3 rounded-b bg-zinc-900">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="flex items-center justify-center gap-2 px-2 py-2 text-green-500 bg-green-700 rounded bg-opacity-10 hover:bg-opacity-20">
                                        <x:svg-icon icon="edit" class="w-5 h-5 text-current" />
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="flex items-center justify-center gap-2 px-2 py-2 text-red-600 bg-red-700 rounded btnDeleteProduct bg-opacity-10 hover:bg-opacity-20">
                                            <x:svg-icon icon="trash" class="w-5 h-5 text-current" />
                                        </button>
                                    </form>
                                    <a href="{{ route('products.show', $product->id) }}"
                                        class="flex items-center justify-center gap-2 px-2 py-2 text-yellow-500 bg-yellow-700 rounded hover:bg-opacity-20 bg-opacity-10">
                                        <x:svg-icon icon="eye" class="w-5 h-5 text-current" />
                                    </a>
                                </div>
                            </div>
                            @empty
                                <div class="flex flex-col gap-2 rounded bg-zinc-950">
                                    <div class="flex justify-between p-2 rounded-t items center bg-zinc-900">
                                        <span class="font-semibold text-violet-600">No hay productos registrados</span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        {{ $products->links() }}
                    </div>
                </div>
            </section>
        @endsection
