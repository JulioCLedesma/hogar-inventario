<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $title }}</h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">{{ session('status') }}</div>
            @endif

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-500">{{ $description }}</p>
                    <p class="mt-1 text-sm font-medium text-gray-700">{{ $items->total() }} registros</p>
                </div>
                <a href="{{ route('items.create') }}" class="inline-flex min-h-12 items-center justify-center rounded-md bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700">
                    Agregar articulo
                </a>
            </div>

            <div class="mt-6 overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                @forelse ($items as $item)
                    <div class="border-b border-gray-100 p-4 last:border-b-0 sm:grid sm:grid-cols-12 sm:items-center sm:gap-4">
                        <div class="sm:col-span-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="font-semibold text-gray-900">{{ $item->nombre }}</p>
                                @if ($item->faltante)
                                    <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800">Faltante</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-gray-500">{{ $types[$item->tipo] ?? $item->tipo }}</p>
                        </div>

                        <div class="mt-3 grid grid-cols-2 gap-3 text-sm sm:col-span-5 sm:mt-0 sm:grid-cols-3">
                            <div>
                                <p class="text-gray-500">Categoria</p>
                                <p class="font-medium text-gray-800">{{ $categories[$item->categoria] ?? 'Sin categoria' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Ubicacion</p>
                                <p class="font-medium text-gray-800">{{ $locations[$item->ubicacion] ?? 'Sin ubicacion' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Estado</p>
                                <p class="font-medium text-gray-800">{{ $statuses[$item->estado] ?? $item->estado }}</p>
                            </div>
                        </div>

                        @if ($item->tipo === 'cocinado')
                            <div class="mt-3 text-sm sm:col-span-2 sm:mt-0">
                                <p class="font-semibold {{ $item->freshness() === 'Vencido' ? 'text-red-700' : ($item->freshness() === 'Consumir pronto' ? 'text-amber-700' : 'text-green-700') }}">
                                    {{ $item->freshness() }}
                                </p>
                                <p class="text-gray-500">
                                    {{ optional($item->fecha_preparacion)->format('d/m/Y') ?? 'Sin preparacion' }}
                                    @if ($item->consumir_antes)
                                        - {{ $item->consumir_antes->format('d/m/Y') }}
                                    @endif
                                </p>
                            </div>
                        @else
                            <div class="hidden sm:col-span-2 sm:block"></div>
                        @endif

                        <div class="mt-4 flex gap-2 sm:col-span-1 sm:mt-0 sm:justify-end">
                            <a href="{{ route('items.edit', $item) }}" class="inline-flex min-h-11 flex-1 items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 sm:flex-none">Editar</a>
                            <form method="POST" action="{{ route('items.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex min-h-11 items-center justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500" onclick="return confirm('Eliminar este articulo?')">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-sm text-gray-500">Todavia no hay articulos aqui.</p>
                        <a href="{{ route('items.create') }}" class="mt-4 inline-flex min-h-12 items-center justify-center rounded-md bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700">Crear primero</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
