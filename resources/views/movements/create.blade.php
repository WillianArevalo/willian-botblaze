@extends('layouts.template')

@section('title')
    APP | Nuevo producto
@endsection

@section('content')
    <section class="pt-16 ml-64">
        <div class="text-white bg-black rounded-md sm:p-8">
            <div class="flex items-center gap-2 justify-left">
                <h1 class="font-bold text-1xl text-violet-600 sm:text-3xl">
                    Registrar @if ($type == 'input')
                        entrada
                    @else
                        salida
                    @endif
                </h1>
            </div>
            <div class="mt-4">
                <form action="{{ route('movements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="typeMovement" id="typetypeMovement" value="{{ $type }}">
                    <div class="flex flex-col gap-4 text-base">
                        <div class="flex flex-col w-full gap-2 md:flex-row">
                            <div class="flex flex-col gap-2 sm:flex-1 lg:flex-[4]">
                                <label class="text-white after:content-['*'] after:ml-0.5 after:text-red-500"
                                    for="product_id">
                                    Producto:
                                </label>
                                <input type="hidden" name="product_id" id="product_id">
                                <div class="relative flex flex-col gap-2 custom-select">
                                    <div
                                        class=" text-base flex justify-between p-3 pl-5 text-white border-2 rounded selected bg-zinc-900 @error('product_id') error @else border-zinc-800 @enderror">
                                        <span class="flex items-center gap-3 item-selected">
                                            Selecciona un producto
                                        </span>
                                        <span class="flex items-center gap-2">
                                            <x:svg-icon icon="arrow-down" class="w-5 h-5 text-white arrow-select" />
                                            @error('product_id')
                                                <x:svg-icon icon="warning" class="w-5 h-5 text-red-500" />
                                            @enderror
                                        </span>
                                    </div>
                                    <div
                                        class="absolute z-20 flex flex-col w-full overflow-hidden text-black border-2 rounded bg-zinc-100 items-selected top-14 border-zinc-800">
                                        @forelse ($products as $product)
                                            <span class="flex items-center gap-3 p-3 pl-5 hover:bg-zinc-300"
                                                data-value="{{ $product->id }}" data-input="product_id">
                                                <img src="{{ asset('images/products/' . $product->image) }}"
                                                    alt="Imagen producto {{ $product->name }}"
                                                    class="object-cover w-6 h-6 rounded-full">
                                                {{ $product->name }}
                                                <span class="font-bold text-violet-600">
                                                    ({{ 'Disponible: ' . $product->stockCurrent }})
                                                </span>
                                            </span>
                                        @empty
                                            <span class="p-3 pl-5 border-b border-zinc-800 hover:bg-zinc-800">
                                                No hay productos registrados
                                            </span>
                                        @endforelse
                                    </div>
                                    @error('product_id')
                                        <span class="text-red-500">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex flex-col flex-1 lg:flex-[2] gap-2">
                                <label class="text-white after:content-['*'] after:ml-0.5 after:text-red-500"
                                    for="quantity">
                                    Cantidad:
                                </label>
                                <div
                                    class="flex items-center w-full text-white border-2  rounded bg-zinc-900 focus-within:border-violet-600 @error('quantity') error @else border-zinc-800 @enderror">
                                    <input type="number" name="quantity" id="quantity"
                                        class="w-full p-3 pl-5 text-white bg-transparent border-none focus:outline-none placeholder:text-zinc-600"
                                        placeholder="Ingrese el correo del usuario" value="{{ old('quantity') }}">
                                    @error('quantity')
                                        <span class="flex items-center justify-center p-2 text-red-500">
                                            <x:svg-icon icon="warning" class="w-5 h-5 text-current" />
                                        </span>
                                    @enderror
                                </div>
                                @error('quantity')
                                    <span class="text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-col w-full gap-2 sm:flex-row">
                            <div class="flex flex-col gap-2 flex-1 lg:flex-[2]">
                                <label class="text-white after:content-['*'] after:ml-0.5 after:text-red-500"
                                    for="date">
                                    Fecha:
                                </label>
                                <div
                                    class="flex items-center w-full text-white border-2  rounded bg-zinc-900 focus-within:border-violet-600 @error('date') error @else border-zinc-800 
                                    @enderror">
                                    <input type="date" name="date" id="date"
                                        class="w-full p-3 pl-5 text-white bg-transparent border-none focus:outline-none placeholder:text-zinc-600"
                                        value="{{ old('date') }}">
                                    @error('date')
                                        <span class="flex items-center justify-center p-2 text-red-500">
                                            <x:svg-icon icon="warning" class="w-5 h-5 text-current" />
                                        </span>
                                    @enderror
                                </div>
                                @error('date')
                                    <span class="text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-col w-full gap-2 sm:flex-row">
                            <div class="flex flex-col flex-1 gap-2">
                                <label class="text-white after:content-['*'] after:ml-0.5 after:text-red-500"
                                    for="description">
                                    Descripción:
                                </label>
                                <div
                                    class="flex items-center w-full text-white border-2  rounded bg-zinc-900 focus-within:border-violet-600 @error('description') error @else border-zinc-800 @enderror">
                                    <textarea name="description" id="description" cols="30" rows="10"
                                        class="w-full p-3 pl-5 text-white bg-transparent border-none resize-none focus:outline-none placeholder:text-zinc-600"
                                        placeholder="Ingrese la descripción del producto">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <span class="text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="flex justify-center gap-2 mt-6 text-base">
                        <button type="submit"
                            class="flex items-center justify-center gap-2 p-3 px-5 rounded w-max text-violet-400 bg-violet-800 bg-opacity-10 hover:bg-opacity-20">
                            <x:svg-icon icon="add-circle" class="w-5 h-5 text-current" />
                            Agregar
                        </button>
                        <a href="{{ route('movements.index') }}"
                            class="flex items-center justify-center gap-2 p-3 px-5 text-white rounded bg-zinc-950">
                            <x:svg-icon icon="arrow-turn" class="w-5 h-5 text-current" />
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
