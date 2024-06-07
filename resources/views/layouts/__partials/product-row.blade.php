@forelse ($products as $product)
    <tr class="border-t-4 border-black bg-zinc-950">
        <td class="px-6 py-2 text-base border-b-4 border-black whitespace-nowrap">
            {{ $loop->iteration }}
        </td>
        <td class="px-6 py-2 text-base border-b-4 border-black whitespace-nowrap">
            <div class="w-12 h-12 overflow-hidden rounded-full">
                <img src="{{ asset('images/products/' . $product->image) }}" alt="Image profile {{ $product->name }}"
                    class="object-cover w-full h-full">
            </div>
        </td>
        <td class="px-6 py-2 text-base border-b-4 border-black whitespace-nowrap">
            {{ $product->name }}
        </td>
        <td class="px-6 py-2 text-base font-semibold border-b-4 border-black whitespace-nowrap text-violet-600">
            {{ "$" . $product->price }}
        </td>
        <td class="px-6 py-2 text-base border-b-4 border-black whitespace-nowrap">
            {{ $product->stockInitial }}
        </td>
        <td class="px-6 py-2 text-base border-b-4 border-black whitespace-nowrap">
            {{ $product->stockCurrent }}
        </td>
        <td class="px-6 py-2 text-base border-b-4 border-black whitespace-nowrap">
            @switch($product->status)
                @case('in_stock')
                    <span class="px-4 py-1 text-base text-green-200 bg-green-600 bg-opacity-20 rounded-3xl">
                        Disponible
                    </span>
                @break

                @case('out_of_stock')
                    <span class="px-4 py-1 text-base text-red-200 bg-red-600 bg-opacity-20 rounded-3xl">
                        Agotado
                    </span>
                @break

                @case('warning')
                    <span class="px-4 py-1 text-base text-yellow-200 bg-yellow-600 bg-opacity-20 rounded-3xl">
                        Por agotarse
                    </span>
                @break

                @default
            @endswitch
        </td>
        <td class="px-6 py-2 border-b-4 border-black">
            <div class="flex gap-2 text-base">
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
        <tr class="border-t-4 border-black bg-zinc-950">
            <td class="px-6 py-3 text-base text-center border-b-4 border-black whitespace-nowrap" colspan="8">
                No se encontro ningun producto
            </td>
        </tr>
    @endforelse
