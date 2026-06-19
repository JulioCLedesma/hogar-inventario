<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lista de compras</h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">{{ session('status') }}</div>
            @endif

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-500">Todo lo marcado como faltante aparece aqui.</p>
                    <p class="mt-1 text-sm font-medium text-gray-700">{{ $groupedItems->flatten(1)->count() }} pendientes</p>
                </div>

                @if ($groupedItems->isNotEmpty())
                    <form method="POST" action="{{ route('shopping-list.purchased-all') }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex min-h-12 w-full items-center justify-center rounded-md bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 sm:w-auto">
                            Marcar todo comprado
                        </button>
                    </form>
                @endif
            </div>

            <div class="mt-6 space-y-5">
                @forelse ($groupedItems as $category => $items)
                    <section>
                        <h3 class="mb-2 text-sm font-semibold uppercase text-gray-500">{{ $categories[$category] ?? 'Otro' }}</h3>
                        <div class="overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                            @foreach ($items as $item)
                                <div class="flex flex-col gap-3 border-b border-gray-100 p-4 last:border-b-0 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->nombre }}</p>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $item->ubicacion ? str_replace('_', ' ', $item->ubicacion) : 'Sin ubicacion' }}
                                            · {{ str_replace('_', ' ', $item->tipo) }}
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('shopping-list.purchased', $item) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex min-h-11 w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 sm:w-auto">
                                            Comprado
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @empty
                    <div class="rounded-md border border-gray-200 bg-white p-8 text-center shadow-sm">
                        <p class="text-sm text-gray-500">No hay articulos faltantes.</p>
                        <a href="{{ route('items.index') }}" class="mt-4 inline-flex min-h-12 items-center justify-center rounded-md bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700">Ver inventario</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
