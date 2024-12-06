<x-base-layout :$title>
    <div x-data="{ showPassword: false }" class="container flex h-screen w-screen items-center justify-center">
        <div class="min-w-64 sm:min-w-96 rounded-lg border border-gray-200 bg-gray-100 p-4 shadow-lg">
            <h1 class="mb-4 text-lg font-bold sm:text-xl lg:text-2xl">Masuk untuk melanjutkan</h1>
            <form action="" method="POST">
                @csrf
                <div class="mb-3 grid gap-2">
                    <label for="username" class="font-medium lg:text-lg">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username"
                        value="{{ $errors->has('username') ? '' : old('username') }}"
                        {{ $errors->has('username') ? 'autofocus' : '' }} required
                        class="{{ $errors->has('username') ? 'input-invalid' : 'input-valid' }} block w-full rounded-md border px-4 py-2 shadow outline-none focus:ring lg:text-lg">
                    @error('username')
                        <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3 grid gap-2">
                    <label for="password" class="font-medium lg:text-lg">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                            placeholder="Masukkan password" {{ $errors->has('password') ? 'autofocus' : '' }} required
                            class="{{ $errors->has('password') ? 'input-invalid' : 'input-valid' }} block w-full rounded-md border px-4 py-2 shadow outline-none focus:ring lg:text-lg">
                        <div
                            class="absolute right-0 top-0 flex h-full items-center justify-center rounded-br-md rounded-tr-md bg-gray-200 px-4">
                            <span @click="showPassword = !showPassword"
                                :class="showPassword ? 'i-mdi-eye-off' : 'i-mdi-eye'"
                                class="cursor-pointer text-xl"></span>
                        </div>
                    </div>
                    @error('password')
                        <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="mt-2 w-full rounded-md bg-blue-500 px-4 py-2 font-semibold text-white shadow-md hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80 lg:text-lg">Masuk</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        @if (Session::get('success'))
            const message = `{{ Session::get('success') }}`;
            window.successAlert(message);
        @elseif (Session::get('error'))
            const message = `{{ Session::get('error') }}`;
            window.errorAlert(message);
        @endif
    });
    </script>
</x-base-layout>
