<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Layout</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body>
<div class="container mx-auto">
    {{ $slot }}
</div>
@livewireScripts
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
