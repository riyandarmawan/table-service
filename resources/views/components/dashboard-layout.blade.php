<x-base-layout :$title>
    <div x-data="{openSidebar: $persist(false), showModalLogout: false}">
        <header class="fixed left-0 right-0 top-0 flex h-16 justify-between border border-blue-600 bg-blue-500 px-3 z-10">
            <div class="flex items-center gap-4">
                <span @click="openSidebar = !openSidebar" class="i-mdi-hamburger-menu mt-1 cursor-pointer text-4xl text-white"></span>
                <h1 class="text-3xl font-bold text-white">Table Service</h1>
            </div>
            <div class="flex items-center">
                <form action="" method="POST">
                    <input type="text" name="search" id="search" placeholder="Cari data di sini"
                        class="rounded-full border border-gray-200 px-4 py-2 outline-none focus:ring focus:ring-blue-700">
                </form>
            </div>
        </header>
        <div>
            <aside :class="openSidebar ? 'w-72 px-2' : 'w-[3.4rem] px-2'"
                class="fixed left-0 top-16 flex flex-col duration-300 z-10 justify-between overflow-y-auto overflow-x-hidden bg-blue-500 py-4 text-white"
                style="height: calc(100vh - 4rem)">
                <ul class="grid gap-2">
                    <li>
                        <a href="/"
                            class="{{ Request::is('/') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-view-dashboard mt-1 text-3xl"></span>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/meja"
                            class="{{ Request::is('meja*') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-book-check mt-1 text-3xl"></span>
                            Meja
                        </a>
                    </li>
                    <li>
                        <a href="/menu"
                            class="{{ Request::is('menu*') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-food mt-1 text-3xl"></span>
                            Menu
                        </a>
                    </li>
                    <li>
                        <a href="/order"
                            class="{{ Request::is('order*') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-phone mt-1 text-3xl"></span>
                            Order
                        </a>
                    </li>
                    <li>
                        <a href="/transaksi"
                            class="{{ Request::is('transaksi*') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-cash mt-1 text-3xl"></span>
                            Transaksi
                        </a>
                    </li>
                </ul>
                <ul class="grid gap-2">
                    <li>
                        <a href="/profile"
                            class="{{ Request::is('profile*') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-account mt-1 text-3xl"></span>
                            {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li>
                        <button @click="showModalLogout = !showModalLogout" type="button"
                            class="flex w-full items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-logout mt-1 text-3xl"></span>
                            Keluar
                        </button>
                    </li>
                </ul>
            </aside>
            <main :class="openSidebar ? 'left-72' : 'left-[3.4rem]'" class="absolute right-0 top-16 bottom-0">
                {{ $slot }}
            </main>
        </div>

        <div x-cloak x-show="showModalLogout" class="bg-gray-500 bg-opacity-50 flex justify-center items-center absolute inset-0 z-20">
            <div @click.outside="showModalLogout = false" class="bg-gray-100 border border-gray-200 shadow-md rounded-md p-4">
                <h1 class="min-w-96 text-3xl font-bold mb-4">Peringatan</h1>
                <p class="mb-4">Apakah anda yakin ingin keluar dari akun ini?</p>
                <div class="flex justify-end gap-2">
                    <form action="/auth/logout" method="POST">
                        @csrf
                        <button class="py-2 px-4 bg-blue-500 text-white shadow rounded">Ya, saya ingin keluar</button>
                    </form>
                    <button @click="showModalLogout = false" class="py-2 px-4 bg-red-500 text-white shadow rounded">Tidak</button>
                </div>
            </div>
        </div>

        {{ $modal ?? '' }}
    </div>

    <script>
        @if (Session::get('success'))
            document.addEventListener('DOMContentLoaded', () => {
                const message = `{{ Session::get('success') }}`;
                window.successAlert(message);
            });
        @endif
    </script>
</x-base-layout>
