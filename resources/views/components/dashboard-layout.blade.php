<x-base-layout :$title>
    <div x-data="{openSidebar: false}">
        <header class="fixed left-0 right-0 top-0 flex h-16 justify-between border border-blue-600 bg-blue-500 px-6 z-10">
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
            <aside :class="openSidebar ? 'w-72 px-6' : 'w-[3.8rem] px-4'"
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
                            class="{{ Request::is('meja') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-book-check mt-1 text-3xl"></span>
                            Meja
                        </a>
                    </li>
                    <li>
                        <a href="/barang"
                            class="{{ Request::is('barang') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-food mt-1 text-3xl"></span>
                            Barang
                        </a>
                    </li>
                    <li>
                        <a href="/order"
                            class="{{ Request::is('order') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-phone mt-1 text-3xl"></span>
                            Order
                        </a>
                    </li>
                    <li>
                        <a href="/transaksi"
                            class="{{ Request::is('transaksi') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-cash mt-1 text-3xl"></span>
                            Transaksi
                        </a>
                    </li>
                </ul>
                <ul class="grid gap-2">
                    <li>
                        <a href="/profile"
                            class="{{ Request::is('profile') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-account mt-1 text-3xl"></span>
                            {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li>
                        <button type="button"
                            class="flex w-full items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-logout mt-1 text-3xl"></span>
                            Keluar
                        </button>
                    </li>
                </ul>
            </aside>
            <main :class="openSidebar ? 'left-72' : 'left-[3.8rem]'" class="absolute right-0 top-16 bottom-0">
                {{ $slot }}
            </main>
        </div>
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
