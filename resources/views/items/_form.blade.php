@php
    $selectedType = old('tipo', $item->tipo);
@endphp

<div x-data="{ tipo: @js($selectedType) }" class="space-y-6">
    <div>
        <x-label for="nombre" value="Nombre" />
        <x-input id="nombre" name="nombre" type="text" class="mt-1 block min-h-12 w-full" value="{{ old('nombre', $item->nombre) }}" required autofocus />
        <x-input-error for="nombre" class="mt-2" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-label for="tipo" value="Tipo" />
            <select id="tipo" name="tipo" x-model="tipo" class="mt-1 block min-h-12 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach ($types as $value => $label)
                    <option value="{{ $value }}" @selected(old('tipo', $item->tipo) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error for="tipo" class="mt-2" />
        </div>

        <div>
            <x-label for="estado" value="Estado" />
            <select id="estado" name="estado" class="mt-1 block min-h-12 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(old('estado', $item->estado) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error for="estado" class="mt-2" />
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-label for="categoria" value="Categoria" />
            <select id="categoria" name="categoria" class="mt-1 block min-h-12 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Sin categoria</option>
                @foreach ($categories as $value => $label)
                    <option value="{{ $value }}" @selected(old('categoria', $item->categoria) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error for="categoria" class="mt-2" />
        </div>

        <div>
            <x-label for="ubicacion" value="Ubicacion" />
            <select id="ubicacion" name="ubicacion" class="mt-1 block min-h-12 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Sin ubicacion</option>
                @foreach ($locations as $value => $label)
                    <option value="{{ $value }}" @selected(old('ubicacion', $item->ubicacion) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error for="ubicacion" class="mt-2" />
        </div>
    </div>

    <div x-show="tipo === 'cocinado'" class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-label for="fecha_preparacion" value="Fecha de preparacion" />
            <x-input id="fecha_preparacion" name="fecha_preparacion" type="date" class="mt-1 block min-h-12 w-full" value="{{ old('fecha_preparacion', optional($item->fecha_preparacion)->format('Y-m-d')) }}" />
            <x-input-error for="fecha_preparacion" class="mt-2" />
        </div>

        <div>
            <x-label for="consumir_antes" value="Consumir antes de" />
            <x-input id="consumir_antes" name="consumir_antes" type="date" class="mt-1 block min-h-12 w-full" value="{{ old('consumir_antes', optional($item->consumir_antes)->format('Y-m-d')) }}" />
            <x-input-error for="consumir_antes" class="mt-2" />
        </div>
    </div>

    <label class="flex min-h-12 items-center gap-3 rounded-md border border-gray-200 bg-white px-4 py-3">
        <x-checkbox name="faltante" value="1" :checked="old('faltante', $item->faltante)" />
        <span class="text-sm font-medium text-gray-700">Agregar a lista de compras</span>
    </label>

    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        <a href="{{ route('items.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">Cancelar</a>
        <x-button class="min-h-12 justify-center">Guardar</x-button>
    </div>
</div>
