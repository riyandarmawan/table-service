<x-base-layout :$title>
    <div x-data="{ openSidebar: $persist(false), showModalLogout: false }">
        <header
            class="fixed left-0 right-0 top-0 z-10 flex h-16 justify-between border border-blue-600 bg-blue-500 px-3">
            <div class="flex items-center gap-4">
                <span @click="openSidebar = !openSidebar"
                    class="i-mdi-hamburger-menu mt-1 cursor-pointer text-4xl text-white"></span>
                <h1 class="text-3xl font-bold text-white">Table Service</h1>
            </div>
            <div class="flex items-center">
                <form action="" method="GET">
                    <input type="text" name="search" id="search" placeholder="Cari data di sini"
                        value="{{ request('search') ?? '' }}"
                        class="rounded-full border border-gray-200 px-4 py-2 outline-none focus:ring focus:ring-blue-700">
                </form>
            </div>
        </header>
        <div>
            <aside :class="openSidebar ? 'w-72 px-2' : 'w-[3.4rem] px-2'"
                class="fixed left-0 top-16 z-10 flex flex-col justify-between overflow-y-auto overflow-x-hidden bg-blue-500 py-4 text-white duration-300"
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
                        <a href="/pelanggan"
                            class="{{ Request::is('pelanggan*') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-people mt-1 text-3xl"></span>
                            Pelanggan
                        </a>
                    </li>
                    <li>
                        <a href="/meja"
                            class="{{ Request::is('meja*') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-table-furniture mt-1 text-3xl"></span>
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
                        <a href="/pesanan"
                            class="{{ Request::is('pesanan*') ? 'sidebar-active' : '' }} flex items-center gap-2 rounded px-2 py-1 text-2xl font-semibold hover:bg-blue-600">
                            <span class="i-mdi-list-box mt-1 text-3xl"></span>
                            Pesanan
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
            <main :class="openSidebar ? 'left-72' : 'left-[3.4rem]'" class="absolute bottom-0 right-0 top-16">
                {{ $slot }}
            </main>
        </div>

        <x-modal modalName="Logout" bodyText="Peringatan apakah anda yakin ingin keluar dari akun ini?"
            href="/auth/logout" confirmText="Ya, saya ingin keluar" cancelText="Tidak"></x-modal>

        {{ $modal ?? '' }}
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        @if ($errors->any())
            const errors = @json($errors->all());
            errors.forEach(error => {
                window.errorAlert(error); // Display each error using your error notification system
            });
        @elseif (Session::get('success'))
            const message = `{{ Session::get('success') }}`;
            window.successAlert(message);
        @elseif (Session::get('error'))
            const message = `{{ Session::get('error') }}`;
            window.errorAlert(message);
        @endif
    });
</script>
</x-base-layout>
