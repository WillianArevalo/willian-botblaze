@extends('layouts.template')

@section('title')
    APP | Editar producto
@endsection

@section('content')
    <section class="pt-16 text-sm lg:ml-64 sm:text-base">
        <div class="p-4 text-white bg-black rounded-md sm:p-8">
            <div class="flex items-center gap-2 justify-left">
                <h1 class="text-3xl font-bold text-violet-600">Editar producto</h1>
            </div>
            <div class="mt-4">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col gap-4 ">
                        <div class="flex flex-col w-full gap-2 md:flex-row">
                            <div class="flex flex-col gap-2 sm:flex-[1] lg:flex-[4]">
                                <label class="text-white after:content-['*'] after:ml-0.5 after:text-red-500"
                                    for="name">
                                    Nombre:
                                </label>
                                <div
                                    class="flex items-center w-full text-white border-2  rounded bg-zinc-900 focus-within:border-violet-600 @error('name') error @else border-zinc-800 @enderror">
                                    <input type="text" name="name" id="name"
                                        class="w-full p-3 pl-5 text-white bg-transparent border-none focus:outline-none placeholder:text-zinc-600"
                                        placeholder="Ingresa el nombre del producto" value="{{ $product->name }}">
                                    @error('name')
                                        <span class="flex items-center justify-center p-2 text-red-500">
                                            <x:svg-icon icon="warning" class="w-5 h-5 text-current" />
                                        </span>
                                    @enderror
                                </div>
                                @error('name')
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
                                        placeholder="Ingrese la descripción del producto">{{ $product->description }}</textarea>
                                    @error('description')
                                        <span class="flex items-center justify-center p-2 text-red-500">
                                            <x:svg-icon icon="warning" class="w-5 h-5 text-current" />
                                        </span>
                                    @enderror
                                </div>
                                @error('description')
                                    <span class="text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="flex flex-col w-full gap-2 sm:flex-row">
                            <div class="flex flex-col gap-2 flex-1 lg:flex-[2]">
                                <label class="text-white after:content-['*'] after:ml-0.5 after:text-red-500"
                                    for="price">
                                    Precio:
                                </label>
                                <div
                                    class="flex items-center w-full text-white border-2  rounded bg-zinc-900 focus-within:border-violet-600 @error('price') error @else border-zinc-800 
                                    @enderror">
                                    <span class="flex items-center justify-center p-2 text-violet-500">
                                        <x:svg-icon icon="dollar" class="w-5 h-5 text-current" />
                                    </span>
                                    <input type="number" name="price" id="price"
                                        class="w-full p-3 pl-5 text-white bg-transparent border-none focus:outline-none placeholder:text-zinc-600"
                                        step="0.01" placeholder="Ingrese el precio del producto"
                                        value="{{ $product->price }}">
                                    @error('price')
                                        <span class="flex items-center justify-center p-2 text-red-500">
                                            <x:svg-icon icon="warning" class="w-5 h-5 text-current" />
                                        </span>
                                    @enderror
                                </div>
                                @error('price')
                                    <span class="text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="flex flex-col flex-1 lg:flex-[2] gap-2">
                                <label class="text-white after:content-['*'] after:ml-0.5 after:text-red-500"
                                    for="stockInitial">
                                    Cantidad inicial:
                                </label>
                                <div
                                    class="flex items-center w-full text-white border-2  rounded bg-zinc-900 focus-within:border-violet-600 @error('stockInitial') error @else border-zinc-800 @enderror">
                                    <input type="number" name="stockInitial" id="stockInitial"
                                        class="w-full p-3 pl-5 text-white bg-transparent border-none focus:outline-none placeholder:text-zinc-600"
                                        placeholder="Ingrese el correo del usuario" value="{{ $product->stockInitial }}"
                                        @if ($searchMovement) readonly @endif>
                                    @error('stockInitial')
                                        <span class="flex items-center justify-center p-2 text-red-500">
                                            <x:svg-icon icon="warning" class="w-5 h-5 text-current" />
                                        </span>
                                    @enderror
                                </div>
                                @if ($searchMovement)
                                    <span class="flex items-center p-2 text-blue-500">
                                        No se puede editar la cantidad inicial, ya que existen movimientos registrados
                                    </span>
                                @endif
                                @error('stockInitial')
                                    <span class="text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-white after:content-['*'] after:ml-0.5 after:text-red-500" for="image">
                                Imagen:
                            </label>
                            <button
                                class="flex items-center justify-center gap-2 px-4 py-3 rounded w-max text-violet-400 bg-violet-800 bg-opacity-10 hover:bg-opacity-20"
                                type="button" id="uploadImage">
                                <x:svg-icon icon="add-image" class="w-5 h-5 text-current" />
                                Seleccionar imagen
                            </button>
                            <input type="file" class="hidden" name="image" id="image" accept=".jpg, .png, .jpeg">
                            <div
                                class="flex items-center justify-center w-full p-4 border-2  border-dashed rounded-md @error('image') error @else border-violet-600 @enderror">
                                <img src="{{ asset('images/products/' . $product->image) }}" alt="Not photo" width="350"
                                    height="350" class="object-cover rounded" id="previewImage">
                            </div>
                            @error('image')
                                <span class="text-red-500">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-center gap-2 mt-6 ">
                        <button type="submit"
                            class="flex items-center justify-center gap-2 p-3 px-5 text-green-100 bg-green-600 rounded bg-opacity-20 w-max hover:bg-opacity-40 hover:text-white focus:outline-none">
                            <x:svg-icon icon="edit" class="w-5 h-5 text-current" />
                            Editar
                        </button>
                        <a href="{{ route('products.index') }}"
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
