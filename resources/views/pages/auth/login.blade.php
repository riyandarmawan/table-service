<x-base-layout :$title>
    <div class="container flex h-screen w-screen items-center justify-center">
        <div class="min-w-64 sm:min-w-96 rounded-lg border border-gray-200 bg-gray-100 p-4 shadow-lg">
            <h1 class="mb-4 text-lg font-bold sm:text-xl lg:text-2xl">Masuk untuk melanjutkan</h1>
            <form action="" method="POST">
                @csrf
                <div class="mb-3 grid gap-1">
                    <label for="username" class="font-medium lg:text-lg">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username"
                        class="block w-full rounded-md border-gray-200 px-4 py-2 shadow outline-none focus:ring focus:ring-blue-500 lg:text-lg">
                </div>
                <div class="mb-3 grid gap-1">
                    <label for="password" class="font-medium lg:text-lg">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password"
                        class="block w-full rounded-md border-gray-200 px-4 py-2 shadow outline-none focus:ring focus:ring-blue-500 lg:text-lg">
                </div>
                <button type="submit"
                    class="mt-2 w-full rounded-md bg-blue-500 px-4 py-2 font-semibold text-white shadow hover:bg-opacity-90 focus:bg-opacity-70 active:bg-opacity-80 lg:text-lg">Masuk</button>
            </form>
        </div>
    </div>
</x-base-layout>
