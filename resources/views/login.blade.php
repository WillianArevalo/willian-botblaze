@extends('layouts.template')

@section('title', 'Iniciar sesión')

@section('content')
    <section>
        <div class="flex items-center justify-center w-full h-screen text-sm bg-black sm:text-base">
            <div class="w-full p-6 bg-transparent rounded 2xl:w-1/4 xl:w-1/3 lg:w-1/3 md:w-1/2 sm:w-3/4">
                <h1 class="text-3xl font-bold text-center uppercase text-violet-600">Iniciar sesión</h1>
                <div class="flex flex-col mt-4">
                    <form action="{{ route('login.validate') }}" class="flex flex-col justify-center w-full gap-4"
                        method="POST">
                        @csrf
                        <div class="flex flex-col gap-2">
                            <label for="email" class="text-white">Correo</label>
                            <div
                                class="flex items-center w-full text-white border-2  rounded bg-zinc-900 focus-within:border-violet-600 @error('email') error @else border-zinc-800 @enderror">
                                <input type="email" name="email" id="email"
                                    class="w-full p-3 pl-5 text-current bg-transparent border-2 border-transparent placeholder:text-zinc-600 focus:outline-none"
                                    placeholder="example@example.com" value="{{ old('email') }}">
                                @error('email')
                                    <span class="flex items-center justify-center p-2 text-red-500">
                                        <x:svg-icon icon="warning" class="w-5 h-5 text-current" />
                                    </span>
                                @enderror
                            </div>
                            @error('email')
                                <span class="text-red-500">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="password" class="text-white">Contraseña</label>
                            <div
                                class="flex items-center w-full text-white border-2  rounded bg-zinc-900 focus-within:border-violet-600 @error('password') error @else border-zinc-800  @enderror">
                                <input type="password" name="password" id="password"
                                    class="w-full p-3 pl-5 text-current bg-transparent border-2 border-transparent placeholder:text-zinc-600 focus:outline-none"
                                    placeholder="Ingrese su contraseña">
                                @error('password')
                                    <span class="flex items-center justify-center p-2 text-red-500">
                                        <x:svg-icon icon="warning" class="w-5 h-5 text-current" />
                                    </span>
                                @enderror
                            </div>
                            @error('password')
                                <span class="text-red-500">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-2 mt-2">
                            <button type="submit"
                                class="flex items-center justify-center gap-2 p-3 px-10 m-auto text-white border rounded bg-violet-600 border-violet-600 w-max hover:bg-violet-800 focus:outline-none hover:text-white">
                                <x:svg-icon icon="login" class="w-5 h-5 text-current" />
                                Iniciar sesión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
