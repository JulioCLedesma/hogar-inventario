<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar articulo</h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                <form method="POST" action="{{ route('items.update', $item) }}">
                    @csrf
                    @method('PUT')
                    @include('items._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
