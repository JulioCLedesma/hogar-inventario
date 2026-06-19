<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inicio
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Inventario de {{ Auth::user()->currentTeam->name }}</p>
                        <h3 class="mt-1 text-2xl font-semibold text-gray-900">Resumen de la casa</h3>
                    </div>
                    <a href="{{ route('items.create') }}" class="inline-flex min-h-12 items-center justify-center rounded-md bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700">
                        Agregar articulo
                    </a>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    @foreach ([
                        ['label' => 'Articulos registrados', 'value' => $totalItems],
                        ['label' => 'Articulos faltantes', 'value' => $missingItems],
                        ['label' => 'Cocinado pendiente', 'value' => $pendingCookedItems],
                        ['label' => 'Consumir pronto', 'value' => $soonCookedItems],
                        ['label' => 'Vencido o desechar', 'value' => $expiredCookedItems],
                    ] as $stat)
                        <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                            <p class="text-sm font-medium text-gray-500">{{ $stat['label'] }}</p>
                            <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $stat['value'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <a href="{{ route('items.cooked') }}" class="flex min-h-16 items-center justify-center rounded-md border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50">Cocinado</a>
                    <a href="{{ route('items.unprepared') }}" class="flex min-h-16 items-center justify-center rounded-md border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50">Sin preparar</a>
                    <a href="{{ route('items.general') }}" class="flex min-h-16 items-center justify-center rounded-md border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50">Articulos</a>
                    <a href="{{ route('shopping-list.index') }}" class="flex min-h-16 items-center justify-center rounded-md border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50">Lista de compras</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
