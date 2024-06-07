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
                <img src="{{ asset('images/products/' . $product->image) }}" alt="" class="w-40 h-40">
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
            <div class="flex justify-between p-3 rounded items center bg-zinc-900">
                <span class="font-semibold text-violet-600">No se encontro ningún producto</span>
            </div>
        </div>
    @endforelse
