<x-guest-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="grid min-h-screen lg:grid-cols-2">
            <section class="flex items-center justify-center px-6 py-10 sm:px-8">
                <div class="w-full max-w-md">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-gray-950">
                        <span class="flex size-10 items-center justify-center rounded-md bg-emerald-500 text-lg font-semibold text-white">IH</span>
                        <span class="text-lg font-semibold">Inventario Hogar</span>
                    </a>

                    <div class="mt-10">
                        <p class="text-sm font-semibold text-emerald-700">Bienvenido de vuelta</p>
                        <h1 class="mt-2 text-3xl font-semibold text-gray-950">Entra a tu casa</h1>
                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            Revisa lo disponible, lo faltante y la lista de compras compartida con tu familia.
                        </p>
                    </div>

                    <div class="mt-8 rounded-md border border-gray-200 bg-white p-6 shadow-sm">
                        <x-validation-errors class="mb-4" />

                        @session('status')
                            <div class="mb-4 rounded-md bg-green-50 p-3 text-sm font-medium text-green-700">
                                {{ $value }}
                            </div>
                        @endsession

                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
                            @csrf

                            <div>
                                <x-label for="email" value="Correo electronico" />
                                <x-input id="email" class="mt-1 block min-h-12 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <x-label for="password" value="Contrasena" />

                                    @if (Route::has('password.request'))
                                        <a class="text-sm font-medium text-emerald-700 hover:text-emerald-900" href="{{ route('password.request') }}">
                                            Olvide mi contrasena
                                        </a>
                                    @endif
                                </div>
                                <x-input id="password" class="mt-1 block min-h-12 w-full" type="password" name="password" required autocomplete="current-password" />
                            </div>

                            <label for="remember_me" class="flex min-h-11 items-center gap-3">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="text-sm text-gray-600">Mantener sesion iniciada</span>
                            </label>

                            <button type="submit" class="inline-flex min-h-12 w-full items-center justify-center rounded-md bg-gray-950 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                Entrar
                            </button>
                        </form>
                    </div>

                    @if (Route::has('register'))
                        <p class="mt-6 text-center text-sm text-gray-600">
                            No tienes cuenta?
                            <a href="{{ route('register') }}" class="font-semibold text-emerald-700 hover:text-emerald-900">
                                Crear una cuenta
                            </a>
                        </p>
                    @endif
                </div>
            </section>

            <section class="relative hidden overflow-hidden bg-gray-950 lg:block">
                <img
                    src="{{ asset('images/home-inventory-hero.png') }}"
                    alt="Despensa organizada para inventario familiar"
                    class="absolute inset-0 h-full w-full object-cover"
                >
                <div class="absolute inset-0 bg-gray-950/58"></div>

                <div class="relative flex h-full items-end p-10">
                    <div class="max-w-md rounded-md border border-white/15 bg-white/10 p-6 text-white backdrop-blur">
                        <p class="text-sm font-semibold text-emerald-200">Inventario compartido</p>
                        <p class="mt-3 text-2xl font-semibold leading-snug">
                            Cocina, alacena y compras en un solo lugar.
                        </p>
                        <div class="mt-5 grid grid-cols-3 gap-3 text-sm">
                            <div class="rounded-md bg-white/12 p-3">
                                <p class="font-semibold">Cocinado</p>
                            </div>
                            <div class="rounded-md bg-white/12 p-3">
                                <p class="font-semibold">Faltantes</p>
                            </div>
                            <div class="rounded-md bg-white/12 p-3">
                                <p class="font-semibold">Compras</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>
