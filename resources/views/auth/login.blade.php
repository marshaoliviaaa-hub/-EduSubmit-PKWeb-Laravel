<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang!</h2>
        <p class="text-sm text-gray-500 mt-1">Masuk ke akun EduSubmit kamu</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4 text-sm">
            <a class="underline text-gray-500 hover:text-pink-600" href="{{ route('register') }}">
                Daftar akun baru
            </a>
            @if (Route::has('password.request'))
                <a class="underline text-gray-500 hover:text-pink-600" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="mt-5">
            <button type="submit"
                class="w-full py-2.5 px-4 bg-gradient-to-r from-pink-500 to-rose-400 text-white font-semibold rounded-xl shadow hover:from-pink-600 hover:to-rose-500 transition duration-200">
                Masuk
            </button>
        </div>
    </form>
</x-guest-layout>