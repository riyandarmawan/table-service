<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Table Service' }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/alert.js')
    @vite('resources/js/utils.js')
</head>

<body>
    {{ $slot }}
    
    @vite('resources/js/app.js')
</body>

</html>
