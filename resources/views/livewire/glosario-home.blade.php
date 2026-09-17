
<div>
    <div class="max-w-7xl mx-10 mt-10 flex flex-col justify-center space-y-2">
            <h2 class="text-center text-3xl font-bold">Glosario Gráfico</h2>
            <div>
                <p class="text-center">Ahora es más fácil entender el significado de una palabra del mundo grafíco.</p>
            </div>
    <livewire:filtrar-palabras />
    </div>
    <div class="m-10 grid md:grid-cols-3 gap-3 max-w-7xl mx-10">
    @forelse ($glosarios as $glosario )
        <div class="dark:bg-cont-100 bg-light-300 flex flex-col gap-6 rounded-xl py-6 shadow-md">
        <div class="px-6">
            <h2 class="text-2xl font-bold">{{ $glosario->titulo }}</h2>
            <p class="pt-3 text-justify text-slate-200">{{ $glosario->descripcion }}</p>
        </div>
        </div>
    @empty
        <div class="">
        <p class="font-semibold text-2xl">No hay Definiciones aún.</p>
        </div>
        @endforelse
    </div>
</div>
