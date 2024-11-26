<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Table Service' }}</title>
    @vite('resources/css/app.css')
</head>

<body>
    {{ $slot }}
    
    @vite('public/js/utils.js')
    @vite('public/js/alert.js')
    @vite('resources/js/app.js')
</body>

</html>
