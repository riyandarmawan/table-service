<x-base-layout :$title>
    <script>
        @if (Session::get('message'))
            document.addEventListener('DOMContentLoaded', () => {
                const message = `{{ Session::get('message') }}`;
                window.successAlert(message);
            });
        @endif
    </script>
</x-base-layout>