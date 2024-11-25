<div x-cloak x-show="showModal{{ $modalName }}" class="absolute inset-0 z-20 flex items-center justify-center bg-gray-500 bg-opacity-50">
    <div @click.outside="showModal{{ $modalName }} = false" class="rounded-md border border-gray-200 bg-white p-4 shadow-md">
        <h1 class="min-w-96 mb-4 text-3xl font-bold">Peringatan</h1>
        <p class="mb-4">{{ $bodyText }}</p>
        <div class="flex justify-end gap-2">
            <form action="{{ $href }}" method="POST">
                @csrf
                <button class="rounded bg-blue-500 px-4 py-2 text-white shadow">{{ $confirmText }}</button>
            </form>
            <button @click="showModal{{ $modalName }} = false"
                class="rounded bg-red-500 px-4 py-2 text-white shadow">{{ $cancelText }}</button>
        </div>
    </div>
</div>
