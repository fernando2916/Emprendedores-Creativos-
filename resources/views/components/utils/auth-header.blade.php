@props([
    'title',
    'descripcion'
])

<div class="flex w-full flex-col text-center">
    <h2 class="text-xl font-semibold">{{ $title}}</h2>
    <p class="mt-3 text-slate-300">{{ $descripcion}}</p>
</div>