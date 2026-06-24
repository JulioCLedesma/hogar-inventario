<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>{{ config('app.name', 'Inventario del hogar') }}</title>

        @include('partials.pwa-meta')

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-white text-gray-900 antialiased">
        <main class="min-h-screen">
            <section class="relative min-h-[92vh] overflow-hidden bg-gray-950">
                <img
                    src="{{ asset('images/home-inventory-hero.png') }}"
                    alt="Despensa y refrigerador organizados para inventario del hogar"
                    class="absolute inset-0 h-full w-full object-cover"
                >
                <div class="absolute inset-0 bg-gray-950/68"></div>

                <div class="relative mx-auto flex min-h-[92vh] max-w-7xl flex-col px-6 py-6 sm:px-8 lg:px-10">
                    <header class="flex items-center justify-between">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-white">
                            Inventario Hogar
                        </a>

                        @if (Route::has('login'))
                            <nav class="flex items-center gap-3">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-950 shadow-sm hover:bg-gray-100">
                                        Ir al inicio
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="rounded-md px-4 py-2 text-sm font-semibold text-white hover:bg-white/10">
                                        Entrar
                                    </a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-950 shadow-sm hover:bg-gray-100">
                                            Crear cuenta
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <div class="flex flex-1 items-center py-14">
                        <div class="max-w-2xl">
                            <p class="text-sm font-semibold uppercase tracking-normal text-emerald-300">
                                Inventario familiar simple
                            </p>
                            <h1 class="mt-5 text-4xl font-semibold leading-tight text-white sm:text-5xl lg:text-6xl">
                                Lo que hay en casa, claro antes de comprar.
                            </h1>
                            <p class="mt-6 max-w-xl text-base leading-7 text-gray-200 sm:text-lg">
                                Organiza comida preparada, alimentos sin preparar y artículos generales por familia o casa. Marca faltantes y arma tu lista de compras automáticamente.
                            </p>

                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                @auth
                                    <a href="{{ route('items.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-md bg-emerald-400 px-5 py-3 text-sm font-semibold text-gray-950 shadow-sm hover:bg-emerald-300">
                                        Ver inventario
                                    </a>
                                    <a href="{{ route('shopping-list.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-md border border-white/30 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10">
                                        Lista de compras
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" class="inline-flex min-h-12 items-center justify-center rounded-md bg-emerald-400 px-5 py-3 text-sm font-semibold text-gray-950 shadow-sm hover:bg-emerald-300">
                                        Empezar ahora
                                    </a>
                                    <a href="{{ route('login') }}" class="inline-flex min-h-12 items-center justify-center rounded-md border border-white/30 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10">
                                        Ya tengo cuenta
                                    </a>
                                @endauth
                            </div>

                            <div class="mt-10 grid max-w-xl gap-3 sm:grid-cols-3">
                                <div class="rounded-md border border-white/15 bg-white/10 p-4 backdrop-blur">
                                    <p class="text-2xl font-semibold text-white">3</p>
                                    <p class="mt-1 text-sm text-gray-200">tipos de artículos</p>
                                </div>
                                <div class="rounded-md border border-white/15 bg-white/10 p-4 backdrop-blur">
                                    <p class="text-2xl font-semibold text-white">1</p>
                                    <p class="mt-1 text-sm text-gray-200">lista automática</p>
                                </div>
                                <div class="rounded-md border border-white/15 bg-white/10 p-4 backdrop-blur">
                                    <p class="text-2xl font-semibold text-white">Teams</p>
                                    <p class="mt-1 text-sm text-gray-200">para familia o casa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-gray-50 py-14 sm:py-18">
                <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-10">
                    <div class="grid gap-5 md:grid-cols-3">
                        <article class="rounded-md border border-gray-200 bg-white p-6 shadow-sm">
                            <p class="text-sm font-semibold text-emerald-700">Cocinado</p>
                            <h2 class="mt-3 text-xl font-semibold text-gray-950">Evita olvidar comida preparada</h2>
                            <p class="mt-3 text-sm leading-6 text-gray-600">
                                Registra refrigerador o congelador, fecha de preparación y cuándo conviene consumirlo.
                            </p>
                        </article>

                        <article class="rounded-md border border-gray-200 bg-white p-6 shadow-sm">
                            <p class="text-sm font-semibold text-amber-700">Inventario</p>
                            <h2 class="mt-3 text-xl font-semibold text-gray-950">Busca rápido desde el celular</h2>
                            <p class="mt-3 text-sm leading-6 text-gray-600">
                                Filtra por categoría, ubicación, estado o faltantes para saber qué hay sin revisar cada repisa.
                            </p>
                        </article>

                        <article class="rounded-md border border-gray-200 bg-white p-6 shadow-sm">
                            <p class="text-sm font-semibold text-sky-700">Compras</p>
                            <h2 class="mt-3 text-xl font-semibold text-gray-950">De faltante a comprado</h2>
                            <p class="mt-3 text-sm leading-6 text-gray-600">
                                Todo faltante entra a compras; al marcarlo comprado vuelve a estar disponible.
                            </p>
                        </article>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
