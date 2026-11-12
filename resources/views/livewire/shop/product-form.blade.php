<div>

    <form wire:submit="guardar" class="space-y-6">

        {{-- Información general --}}
        <div class="bg-light-200 dark:bg-cont-100 rounded-lg shadow-md">

            <div class="p-5 border-b border-gray-200 dark:border-gray-700">

                <h2 class="text-lg font-semibold ">
                    Información general
                </h2>

            </div>

            <div class="p-5 space-y-5">

                <div>

                    <label
                        for="nombre"
                        class="block mb-2 text-sm font-medium "
                    >
                        Nombre del producto
                    </label>

                    <input
                        type="text"
                        id="nombre"
                        wire:model="nombre"
                        placeholder="Ej. Playera Spider-Man"
                        class="disabled:bg-nav-900 disabled:border-nav-900 border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                    >

                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label
                        for="descripcion"
                        class="block mb-2 text-sm font-medium "
                    >
                        Descripción
                    </label>

                    <div
                        id="editor-producto"
                        wire:ignore
                        class="bg-white dark:bg-gray-900"
                        style="min-height: 250px;"
                    >
                    {!! $descripcion !!}
                    </div>

                    {{-- Campo oculto que recibe el contenido de Quill --}}
                    <input
                    type="hidden"
                    id="descripcion-producto"
                    wire:model="descripcion"
                >

                    @error('descripcion')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror


                </div>

            </div>

        </div>

        {{-- Imagen --}}
        <div class="mt-8">
            <h2 class="mb-4 text-lg font-semibold">
                Imágenes del producto
            </h2>
        
            <div
                class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-6"
            >
                <div class="flex flex-col items-center justify-center text-center">
        
                    <i class="fa-solid fa-images text-4xl text-gray-400 mb-3"></i>
        
                    <p class="mb-2 font-medium">
                        Selecciona las imágenes del producto
                    </p>
        
                    <p class="text-sm text-gray-500 mb-4">
                        JPG, PNG o WEBP. Máximo 5 MB por imagen.
                    </p>
        
                    <label
                        for="imagenes"
                        class="inline-flex items-center gap-2 px-4 py-2
                               bg-btn-600 hover:bg-btn-700
                               text-white rounded-lg cursor-pointer"
                    >
                        <i class="fa-solid fa-upload"></i>
                        Seleccionar imágenes
                    </label>
        
                    <input
                        id="imagenes"
                        type="file"
                        wire:model="imagenes"
                        multiple
                        accept="image/jpeg,image/png,image/webp"
                        class="hidden"
                    >
        
                </div>
        
                @error('imagenes.*')
                    <p class="mt-3 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            
          {{-- Imagnes actuales --}}
          {{-- @if ($imagenesExistentes->isNotEmpty()) --}}
          @if ($producto && $producto->images()->exists())

    <div class="mt-6">

        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
            Imágenes actuales
        </h3>

        <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
            Arrastra las imágenes para cambiar su orden.
        </p>

        <div
            wire:sort="actualizarOrdenImagen"
            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4"
        >

            @foreach ($producto->images()->orderBy('orden')->get() as $imagen)

                    <div
                        wire:key="imagen-{{ $imagen->id }}"
                        wire:sort:item="{{ $imagen->id }}"
                        class="relative group cursor-move"
                    >

                    <div
                        class="relative aspect-square overflow-hidden rounded-lg
                               border border-gray-200 dark:border-gray-700
                               bg-gray-100 dark:bg-gray-800"
                    >

                        <img
                            src="{{ Storage::disk('public')->url($imagen->imagen) }}"
                            alt="Imagen del producto"
                            class="w-full h-full object-cover"
                        >

                        {{-- Indicador de imagen principal --}}
                        @if ($imagen->principal)
                            <span
                                class="absolute bottom-2 left-2
                                       px-2 py-1 text-xs font-medium
                                       bg-btn-600 text-white rounded-md"
                            >
                                <i class="fa-solid fa-star mr-1"></i>
                                Principal
                            </span>
                        @endif

                        {{-- Botones --}}
                        <div
                        wire:sort:ignore
                        class="absolute top-2 right-2 flex gap-2"
                    >
                    
                        @if (!$imagen->principal)
                            <button
                                type="button"
                                wire:click="hacerPrincipal({{ $imagen->id }})"
                                class="w-8 h-8 flex items-center justify-center
                                       rounded-md bg-white/90
                                       text-yellow-500 hover:bg-white
                                       shadow"
                                title="Hacer imagen principal"
                            >
                                <i class="fa-solid fa-star"></i>
                            </button>
                        @endif
                    
                        <button
                            type="button"
                            wire:click="eliminarImagen({{ $imagen->id }})"
                            wire:confirm="¿Estás seguro de eliminar esta imagen?"
                            class="w-8 h-8 flex items-center justify-center
                                   rounded-md bg-white/90
                                   text-red-500 hover:bg-white
                                   shadow"
                            title="Eliminar imagen"
                        >
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    
                    </div>

                        {{-- Indicador de arrastre --}}
                        <div
                            class="absolute inset-0 flex items-center justify-center
                                   opacity-0 group-hover:opacity-100
                                   pointer-events-none transition"
                        >
                            <div
                                class="w-10 h-10 rounded-full
                                       bg-black/50 text-white
                                       flex items-center justify-center"
                            >
                                <i class="fa-solid fa-grip-vertical"></i>
                            </div>
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

@endif
          {{-- Nuevas Imagenes --}}
            @if (!empty($imagenes))
                    <div class="mt-6">
                        <h3 class="mb-4 font-semibold">
                            Nuevas imágenes
                        </h3>
                
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                
                            @foreach ($imagenes as $index => $imagen)
                                <div
                                    wire:key="imagen-preview-{{ $index }}"
                                    class="relative group"
                                >
                
                                    <div class="aspect-square overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                                        <img
                                            src="{{ $imagen->temporaryUrl() }}"
                                            class="w-full h-full object-cover"
                                            alt="Preview"
                                        >
                                    </div>
                
                                    <button
                                        type="button"
                                        wire:click="eliminarImagenTemporal({{ $index }})"
                                        class="absolute top-2 right-2 w-8 h-8
                                            flex items-center justify-center
                                            rounded-full bg-red-600 text-white
                                            opacity-0 group-hover:opacity-100
                                            transition"
                                    >
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                
                                    @if ($index === 0)
                                        <span
                                            class="absolute bottom-2 left-2
                                                px-2 py-1 text-xs font-medium
                                                bg-btn-600 text-white rounded-md"
                                        >
                                            Principal
                                        </span>
                                    @endif
                
                                </div>
                            @endforeach
                
                        </div>
                    </div>
            @endif

        </div>

        {{-- Clasificación --}}
        <div class="bg-light-200 dark:bg-cont-100 rounded-lg shadow-md">

            <div class="p-5 border-b border-gray-200 dark:border-gray-700">

                <h2 class="text-lg font-semibold ">
                    Clasificación
                </h2>

            </div>


            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">


                {{-- Categoría --}}
                <div>

                    <label
                        for="categoria_id"
                        class="block mb-2 text-sm font-medium "
                    >
                        Categoría
                    </label>

                    <select
                        id="categoria_id"
                        wire:model.live="categoria_id"
                        class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
                    >

                        <option value="">
                            Selecciona una categoría
                        </option>

                        @foreach ($categorias as $categoria)

                            <option value="{{ $categoria->id }}">
                                {{ $categoria->nombre }}
                            </option>

                        @endforeach

                    </select>

                    @error('categoria_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Subcategoría --}}
                <div>

                    <label
                        for="sub_categoria_id"
                        class="block mb-2 text-sm font-medium "
                    >
                        Subcategoría
                    </label>

                    <select
                        id="sub_categoria_id"
                        wire:model="sub_categoria_id"
                        @disabled(!$categoria_id)
                        class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
                    >

                        <option value="">
                            Selecciona una subcategoría
                        </option>

                        @foreach ($subcategorias as $subcategoria)

                            <option value="{{ $subcategoria->id }}">
                                {{ $subcategoria->nombre }}
                            </option>

                        @endforeach

                    </select>

                    @error('sub_categoria_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Marca --}}
                <div>

                    <label
                        for="brand_id"
                        class="block mb-2 text-sm font-medium "
                    >
                        Marca
                    </label>

                    <select
                        id="brand_id"
                        wire:model="brand_id"
                        class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
                    >

                        <option value="">
                            Sin marca
                        </option>

                        @foreach ($brands as $brand)

                            <option value="{{ $brand->id }}">
                                {{ $brand->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Licencia --}}
                <div>

                    <label
                        for="license_id"
                        class="block mb-2 text-sm font-medium "
                    >
                        Licencia
                    </label>

                    <select
                        id="license_id"
                        wire:model="license_id"
                        class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-link-500/50 focus:border-link-500 transition-all"
                    >

                        <option value="">
                            Sin licencia
                        </option>

                        @foreach ($licenses as $license)

                            <option value="{{ $license->id }}">
                                {{ $license->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Propietario del producto --}}
                @if (auth()->user()->hasRole('Super Admin'))

                    <div class="md:col-span-2">

                        <label
                            for="propietario_id"
                            class="block mb-2 text-sm font-medium"
                        >
                            Vendedor propietario
                        </label>

                        <select
                            id="propietario_id"
                            wire:model="propietario_id"
                            class="w-full pr-4 py-3 bg-link-800 border border-link-500 rounded-2xl focus:outline-none focus:ring-2 focus:ring-link-500/50 transition-all"
                        >

                            <option value="">
                                Selecciona un vendedor
                            </option>

                            @foreach ($vendedores as $vendedor)

                                <option value="{{ $vendedor->id }}">
                                    {{ $vendedor->nombre_completo }}
                                </option>

                            @endforeach

                        </select>

                        @error('propietario_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <p class="mt-1 text-xs text-gray-500">
                            Selecciona al vendedor responsable de este producto.
                        </p>

                    </div>

                @else

                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">
                            Este producto quedará asignado automáticamente a tu cuenta.
                        </p>
                    </div>

                @endif

            </div>

        </div>

        {{-- Atributos del producto --}}
        <div class="mt-6">

            <h2 class="mb-4 text-lg font-semibold ">
                Atributos del producto
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                @foreach ($atributos as $atributo)

                    <label
                        class="flex items-center gap-3 p-4 border rounded-md cursor-pointer
                            border-link-700
                            hover:bg-light-300 hover:text-white dark:hover:bg-gray-800"
                    >

                        <input
                            type="checkbox"
                            value="{{ $atributo->id }}"
                            wire:model.live="atributosSeleccionados"
                            class="w-4 h-4 text-btn-600 bg-gray-100 border-gray-300 rounded-md focus:ring-btn-600"
                        >

                        <div>

                            <p class="font-medium ">
                                {{ $atributo->nombre }}
                            </p>

                            <p class="text-xs ">
                                {{ $atributo->values->count() }} valores disponibles
                            </p>

                        </div>

                    </label>

                @endforeach

            </div>

            @if (!empty($atributosSeleccionados))
            
                <div class="mt-6 space-y-6">
            
                    <h3 class="text-lg font-semibold">
                        Valores de los atributos
                    </h3>
            
                    @foreach ($atributos as $atributo)
            
                        @if (in_array($atributo->id, $atributosSeleccionados ?? []))
            
                            <div class="p-5 border rounded-lg border-gray-200 dark:border-gray-700">
            
                                <div class="mb-4">
            
                                    <h4 class="font-semibold ">
                                        {{ $atributo->nombre }}
                                    </h4>
            
                                    <p class="text-sm ">
                                        Selecciona los valores que tendrá este producto.
                                    </p>
            
                                </div>
            
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            
                                    @foreach ($atributo->values as $valor)
            
                                        <label
                                        wire:key="atributo-{{ $atributo->id }}-valor-{{ $valor->id }}"
                                            class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer
                                            border-link-700
                                            hover:bg-light-300 hover:text-white dark:hover:bg-gray-800"
                                        >
            
                                            <input
                                                type="checkbox"
                                                value="{{ $valor->id }}"                                        
                                                wire:model.live="valoresSeleccionados.{{ $atributo->id }}.{{ $valor->id }}"
                                                class="w-4 h-4 text-btn-600 rounded-md"
                                            >
            
                                            <span class="text-sm ">
                                                {{ $valor->valor }}
                                            </span>
            
                                        </label>
            
                                    @endforeach
            
                                </div>
            
                            </div>
            
                        @endif
            
                    @endforeach
            
                </div>
            
            @endif
        </div>

        {{-- Variantes del producto --}}
        @if (!empty($variantes))

            <div class="mt-8 bg-light-200 dark:bg-cont-100 rounded-lg shadow-md">

                <div class="p-5 border-b border-gray-200 dark:border-gray-700">

                    <h2 class="text-lg font-semibold">
                        Variantes del producto
                    </h2>

                    <p class="text-sm mt-1">
                        Define el SKU, precio y stock de cada variante.
                    </p>

                </div>

                <div class="p-5 overflow-x-auto">

                    <table class="w-full min-w-212.5 text-left table-auto">

                        <thead>
                            <tr class="border-b border-gray-300 dark:border-gray-700 gap-3">

                                <th class="px-4 py-3 min-w-55">
                                    Variante
                                </th>

                                <th class="px-4 py-3 min-w-55">
                                    SKU 
                                </th>

                                <th class="px-4 py-3 min-w-55">
                                    Precio 
                                </th>

                                <th class="px-4 py-3 min-w-55">
                                    Stock 
                                </th>

                                <th class="px-4 py-3 min-w-55 text-center">
                                    Estado
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($variantes as $indice => $variante)

                                <tr
                                    wire:key="variante-{{ $indice }}"
                                    class="border-b border-gray-200 dark:border-gray-700 gap-3"
                                >

                                    {{-- Combinación --}}
                                    <td class="px-4 py-4 align-top min-w-55">

                                        <div class="flex flex-wrap ">

                                            @foreach ($variante['valores'] as $seleccion)

                                                @php
                                                    $atributo = $atributos->firstWhere(
                                                        'id',
                                                        $seleccion['atributo_id']
                                                    );

                                                    $valor = $atributo?->values
                                                        ->firstWhere(
                                                            'id',
                                                            $seleccion['valor_id']
                                                        );
                                                @endphp

                                                @if ($atributo && $valor)

                                                    <span
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded-md bg-gray-100 dark:bg-gray-800"
                                                    >
                                                        <span class="font-semibold">
                                                            {{ $atributo->nombre }}:
                                                        </span>

                                                        <span>
                                                            {{ $valor->valor }}
                                                        </span>
                                                    </span>

                                                @endif

                                            @endforeach

                                        </div>

                                    </td>

                                    {{-- SKU --}}
                                    <td class="px-4 py-4 align-top min-w-55">

                                        <input
                                            type="text"
                                            wire:model="variantes.{{ $indice }}.sku"
                                            placeholder="Ej. PLA-CH-NEG"
                                            class="border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                                        >

                                    </td>

                                    {{-- Precio --}}
                                    <td class="px-4 py-4 align-top min-w-55">

                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            wire:model="variantes.{{ $indice }}.precio"
                                            placeholder="0.00"
                                            class="border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                                        >

                                    </td>

                                    {{-- Stock --}}
                                    <td class="px-4 py-4 align-top min-w-55">

                                        <input
                                            type="number"
                                            min="0"
                                            wire:model="variantes.{{ $indice }}.stock"
                                            placeholder="0"
                                            class="border-link-100 focus:shadow-link-200 w-full rounded-md border-2 bg-transparent p-2 outline-none focus:shadow-md placeholder:text-slate-300 dark:placeholder:text-slate-400 mt-2"
                                        >

                                    </td>

                                    {{-- Estado --}}
                                    <td class="px-4 py-4 align-top min-w-55 text-center">

                                        <input
                                            type="checkbox"
                                            wire:model="variantes.{{ $indice }}.estado"
                                            class="w-5 h-5 rounded-md text-btn-600"
                                        >

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        @endif


        {{-- Etiquetas --}}
        <div class="bg-light-200 dark:bg-cont-100 rounded-lg shadow-md">

            <div class="p-5 border-b border-gray-200 dark:border-gray-700">

                <h2 class="text-lg font-semibold ">
                    Etiquetas
                </h2>

            </div>


            <div class="p-5">

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">

                    @foreach ($tagsDisponibles as $tag)

                        <label
                            class="flex items-center gap-3 p-3 rounded-md border dark:border-gray-700 cursor-pointer border-link-700
                            hover:bg-light-300 hover:text-white dark:hover:bg-gray-800"
                        >

                            <input
                                type="checkbox"
                                value="{{ $tag->id }}"
                                wire:model="tags"
                                class="rounded-md border-gray-300 text-btn-600 focus:ring-btn-600"
                            >

                            <span class="text-sm ">
                                {{ $tag->nombre }}
                            </span>

                        </label>

                    @endforeach

                </div>

            </div>

        </div>


        {{-- Estado --}}
        <div class="bg-light-200 dark:bg-cont-100 rounded-lg shadow-md">

            <div class="p-5 border-b border-gray-200 dark:border-gray-700">

                <h2 class="text-lg font-semibold">
                    Configuración
                </h2>

            </div>


            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">

                <label class="flex items-center gap-3">

                    <input
                        type="checkbox"
                        wire:model="estado"
                        class="rounded-md border-gray-300 text-btn-600 focus:ring-btn-600"
                    >

                    <span class="text-sm font-semibold">
                        Producto activo
                    </span>

                </label>


                <label class="flex items-center gap-3">

                    <input
                        type="checkbox"
                        wire:model="destacado"
                        class="rounded-md border-gray-300 text-btn-600 focus:ring-btn-600"
                    >

                    <span class="text-sm font-semibold">
                        Producto destacado
                    </span>

                </label>

            </div>

        </div>


        {{-- Botones --}}
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.producto.index') }}"
                wire:navigate
                class="bg-red-600 hover:bg-red-800 dark:bg-red-500 text-white dark:hover:bg-red-700 duration-300 transition-colors rounded-md px-3 py-2 mt-5 cursor-pointer"
            >
                Cancelar
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 text-white dark:hover:bg-btn-600 duration-300 transition-colors rounded-md px-3 py-2 mt-5 cursor-pointer"
            >

                <span wire:loading.remove>
                    <i class="fa-solid fa-save mr-1"></i>
                    Guardar producto
                </span>

                <span wire:loading>
                    <i class="fa-solid fa-circle-notch animate-spin mr-1"></i>
                    Guardando...
                </span>

            </button>

        </div>

    </form>

    {{-- @push('scripts')
    <script>
      document.querySelectorAll('.delete-form').forEach(form => {
          form.addEventListener('submit', (e) => {
            e.preventDefault();
            Swal.fire({
                      title: "¿Estás seguro?",
                      text: "¡No podrás revertir esto!",
                      icon: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      confirmButtonText: "Sí, eliminar",
                      cancelButtonText: "Cancelar",
                      background: "#120024",
                      color: "#ffffff",
                    }).then((result) => {
                      if(result.isConfirmed) {
                        form.submit();
                      }
                    })
          })
        })
    </script>
    @endpush --}}

</div>