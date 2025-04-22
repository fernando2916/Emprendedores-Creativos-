<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bienvenido</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
  <script src="https://kit.fontawesome.com/255bc8dd2c.js" crossorigin="anonymous"></script>
</head>
<body class="bg-slate-300 dark:bg-fondo-100 dark:text-white selection:bg-selec-100 selection:text-white">
  <x-header/>
  <main class="pt-16"></main>
  <h2>Hola mundo</h2>
  <x-footer/>
  @livewireScripts
</body>
</html>