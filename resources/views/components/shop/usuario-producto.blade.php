@props(['usuario'])

@php
    $nombre = $usuario?->nombre_completo ?? 'Usuario';

    $avatar = $usuario?->profile?->avatar
        ? Storage::url($usuario->profile->avatar)
        : null;

    $partes = preg_split('/\s+/', trim($nombre));

    $iniciales = collect($partes)
        ->filter()
        ->take(2)
        ->map(fn ($parte) => mb_strtoupper(mb_substr($parte, 0, 1)))
        ->implode('');

    $roles = $usuario?->getRoleNames() ?? collect();

    $rol = null;

    foreach ([
        'Super Admin' => 'Administrador',
        'Vendedor Instructor' => 'Vendedor instructor',
        'Vendedor' => 'Vendedor',
    ] as $nombreRol => $etiqueta) {
        if ($roles->contains($nombreRol)) {
            $rol = $etiqueta;
            break;
        }
    }

    // Si tiene otro rol real, mostrar su nombre.
    if ($rol === null && $roles->isNotEmpty()) {
        $rol = $roles->first();
    }
@endphp

<div class="flex items-center gap-3 min-w-0">

    @if ($avatar)

        <img
            src="{{ $avatar }}"
            alt="Foto de {{ $nombre }}"
            class="w-11 h-11 rounded-full object-cover shrink-0"
        >

    @else

        <div class="w-11 h-11 rounded-full shrink-0
            flex items-center justify-center
            bg-light-300 dark:bg-cont-400
            text-link-100 font-bold text-sm">

            {{ $iniciales ?: 'U' }}

        </div>

    @endif

    <div class="min-w-0">

        <div class="flex flex-wrap items-center gap-2">

            <span class="font-semibold text-sm">
                {{ $nombre }}
            </span>

            @if ($rol)
                <span class="text-xs px-2 py-0.5 rounded-full
                    bg-link-100/10 text-link-100">
                    {{ $rol }}
                </span>
            @endif

        </div>

    </div>

</div>