<x-base-layout :$title>
    <div class="container flex h-screen w-screen items-center justify-center">
        <div class="min-w-64 sm:min-w-96 rounded-lg border border-gray-200 bg-gray-100 p-4 shadow-lg">
            <h1 class="mb-4 text-lg font-bold sm:text-xl lg:text-2xl">Masuk untuk melanjutkan</h1>
            <form action="" method="POST">
                @csrf
                <div class="mb-3 grid gap-2">
                    <label for="username" class="font-medium lg:text-lg">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username"
                        value="{{ $errors->has('username') ? '' : old('username') }}"
                        {{ $errors->has('username') ? 'autofocus' : '' }} required
<<<<<<< HEAD
                        class="{{ $errors->has('username') ? 'input-invalid' : 'input-valid' }} block w-full rounded-md border-2 px-4 py-2 shadow outline-none focus:ring lg:text-lg">
                    @error('username')
                        <p class="pl-2 font-medium text-red-500">{{ $message }}</p>
=======
                        class="{{ $errors->has('username') ? 'input-invalid' : 'input-valid' }} block w-full rounded-md border px-4 py-2 shadow outline-none focus:ring lg:text-lg">
                    @error('username')
                        <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
>>>>>>> e42989ef17adaa41842e66ed7d981743c3911528
                    @enderror
                </div>
                <div class="mb-3 grid gap-2">
                    <label for="password" class="font-medium lg:text-lg">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password"
                        {{ $errors->has('password') ? 'autofocus' : '' }} required
<<<<<<< HEAD
                        class="{{ $errors->has('password') ? 'input-invalid' : 'input-valid' }} block w-full rounded-md border-2 px-4 py-2 shadow outline-none focus:ring lg:text-lg">
                    @error('password')
                        <p class="pl-2 font-medium text-red-500">{{ $message }}</p>
=======
                        class="{{ $errors->has('password') ? 'input-invalid' : 'input-valid' }} block w-full rounded-md border px-4 py-2 shadow outline-none focus:ring lg:text-lg">
                    @error('password')
                        <p class="pl-4 pt-1 text-sm font-semibold text-red-500">{{ $message }}</p>
>>>>>>> e42989ef17adaa41842e66ed7d981743c3911528
                    @enderror
                </div>
                <button type="submit"
                    class="mt-2 w-full rounded-md bg-blue-500 px-4 py-2 font-semibold text-white shadow-md hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80 lg:text-lg">Masuk</button>
            </form>
        </div>
    </div>

    <script>
        @if (Session::get('message'))
            document.addEventListener('DOMContentLoaded', () => {
                const message = `{{ Session::get('message') }}`;
                window.successAlert(message);
            });
        @endif
    </script>
</x-base-layout>
