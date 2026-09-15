@extends('components.layouts.principal')

@section('titulo')
Fotografía |
@endsection

@section('contenido')
<div class="relative bg-cover md:h-180 lg:h-260">
  <img src="{{ asset('images/backgroundfoto.webp') }}" alt="" class="opacity-70 h-full object-cover w-full">
  <div class="absolute w-full h-full flex flex-col top-0 items-center justify-center ">
    <div class="text-center p-3 space-y-3 md:space-y-7 relative lg:-top-24">
      <span class=" font-bold text-sm md:text-3xl">
        Agencia de fotografía
      </span>
      <h3 class="text-2xl text-link-300 dark:text-link-100 md:text-7xl xl:text-9xl font-extrabold">
        <span id="typewriter-foto"></span>
      </h3>
      <p class="text-lg md:text-4xl">
        Dominando la fotografía de la A a la Z!
      </p>
    </div>
  </div>
</div>

{{-- EL ESTUDIO --}}
<section class="max-w-7xl justify-center mx-auto">
  <div class="grid grid-cols-12">
    <div class="col-span-full md:col-span-6">
      <img src="{{ asset('images/sorpresa.jpg') }}" alt="">
    </div>
    <div class="col-span-full md:col-span-6">
      <div class="p-10 text-left">
        <h2 class="uppercase font-bold text-4xl">El estudio</h2>
        <div class="w-full pl-16 mb-4">
          <div class="py-2.5 text-left">
            <span class="border w-[60%] border-amber-600 inline-block box-border"></span>
          </div>
        </div>
        <div class="mb-8 box-border">
          <p class="uppercase font-bold text-2xl">Books fotografícos para modelos en cdmx.</p>
        </div>
        <div class="space-y-5">
          <p>
            Cada fotografía de Retrato esta destinada a representar la personalidad del protagonista de una manera fiel,
            elegante y exquisita. Mi estilo está inspirado en la fotografía contemporánea y fashion. El resultado final
            es conformado como una imagen en un book.
          </p>
          <p>
            Me apasiona capturar algo más que momentos... personalizarlos y redefinir conceptos es parte de lo que
            conforman las fotografías de Retrato Fine Art. Mi equipo y yo nos encargaremos de hacerte sentir cómoda/o,
            un factor clave para obtener excelentes fotografías. Así mismo, serás parte del proceso creativo y juntos
            trabajaremos para obtener las tomas perfectas. Puedes pensar que no es fotogénica/o. Te sorprenderás de que
            esto no sea cierto. La belleza existe en todos y nuestro trabajo y promesa es probarla a través de las
            mejores fotografías que haya visto de ti misma/o. No es cuestión de apariencias, físico ni nada parecido. Un
            gran retrato es resultado de todo el trabajo previo al hacer click, y por mi dirección en la pose.
          </p>
          <p>
            Aunque la verdadera magia ocurre en la sesión, me aseguro de que cada imagen tenga la presencia para estar
            en una revista de moda. Cuidando hasta el ultimo detalle.
          </p>
          <p>
            Te enseñaré cómo posar hermosamente y cómo lucir genial en tus fotos. ¡Solo disfruta tu día y si tienes algo
            planeado ¡serás lista/o para salir después la sesión!
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
{{-- AGENCIA --}}
<section class="max-w-7xl justify-center mx-auto">
  <div class="grid grid-cols-12">
    <div class="col-span-full md:col-span-6 order-last md:order-first">
      <div class="p-10 space-y-5">
        <p class="text-slate-400">
          Quieres...
        </p>
        <p class="uppercase text-5xl font-semibold">buscamos</p>
        <p class="uppercase text-xl font-semibold">tú personalidad y estilo</p>
        <div class="text-left">
          <h2 class="uppercase font-bold text-4xl">modelos. creativos. influencers.</h2>
          <div class="w-full pl-16 mb-4">
            <div class="py-2.5 text-left">
              <span class="border w-[60%] border-amber-600 inline-block box-border"></span>
            </div>
          </div>
          <div class="space-y-5 text-justify">
            <p>
              Sí,
              <span class="font-bold">
                Emprendedores Foto
              </span>
              es una agencia relativamente nueva. Contamos con un equipo de profesionales experimentados de la industria
              que lo guiarán en cada paso del camino, desde ayudarlo a crear un portafolio hasta encontrar las
              audiciones y oportunidades de casting adecuadas. Con nosotros, tendrá acceso a una amplia red de contactos
              del medio y le brindaremos el apoyo y la orientación que necesita para tener éxito. No pierdas esta
              oportunidad de impulsar tu carrera..
            </p>
            <span class="text-slate-400">Eres...</span>
            <p>
              Un/a modelo, creativo o influencer que busca darse a conocer con contenidos de interes. … Entonces estas
              en el lugar correcto. … Entonces se parte de Emprendedores Foto.
            </p>
            <p>
              Mientras que otras agencias de modelos pueden adoptar un enfoque disperso para promocionarte como modelo,
              en Emprendedores Foto preferimos profundizar más y encontrar tu book. Es un estilo de proyección de
              cazador de talentos en modelos, reuniendo a clientes y modelos talentosos. Y es por eso que los grandes
              clientes acuden a nosotros para satisfacer sus necesidades de fotografía publicitaria, moda. Saben que no
              sólo creamos sus books para las modelos si no que encontramos tu personalidad al interpretar tu estilo en
              una sesión de fotos.
            </p>
            <p>Gracias por ser parte de Emprendedores Foto México.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-span-full md:col-span-6">
      <img src="{{ asset('images/fashion.jpg') }}"" alt="" class="">
    </div>
  </div>
</section>
{{-- TESTIMONIOS --}}
<section class="bg-light-300 dark:bg-cont-100 p-5">
    <div class="max-w-7xl justify-center mx-auto">
      <h2 class="text-4xl font-semibold text-center">
        Lo que nuestros clientes dicen:
      </h2>
      <div class="swiper mySwiper-slider-foto relative">
        <div class="swiper-wrapper">
          <!-- Slides -->
          @forelse ($testimonios as $testimonio )

          <div class="swiper-slide mt-5 flex flex-col justify-center">
            <p class="flex p-5 gap-2 items-center justify-center md:text-3xl font-semibold">
              <i class="fa-solid fa-quote-left text-5xl font-bold text-link-100"></i>
              {{ $testimonio->testimonio}}
              <i class="fa-solid fa-quote-right text-5xl font-bold text-link-100"></i>
            </p>
            <p class="text-xl">{{ $testimonio->autor }}</p>
            <p class="text-link-300">{{ $testimonio->red_social }}</p>
          </div>
          @empty
          <div class=" mt-5 justify-center flex mx-auto">
            <p class="font-semibold">No hay Opiniones todavía.</p>
          </div>
          @endforelse
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination absolute -bottom-8 w-full text-center z-10"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    <div>
</section>
{{-- QUE HACEMOS --}}
<section class="max-w-7xl justify-center mx-auto">
  <div class="p-10 flex flex-col justify-center mx-auto">
    <h2 class="uppercase font-bold text-5xl text-center">Lo que hacemos</h2>
    <div class="w-full pl-16 mb-4">
      <div class="py-2.5 text-center">
        <span class="border w-[23%] border-amber-600 inline-block box-border"></span>
      </div>
    </div>
    <div class="mb-8 box-border">
      <p class="uppercase font-bold text-2xl">Fotografía de Moda, Retrato, Producto, Corporativa, En estudio.</p>
    </div>
  </div>
  <div class="grid grid-cols-12">
    {{-- Retrato --}}
    <div class="col-span-full md:col-span-6">
      <img src="{{ asset('images/atardecer.jpg') }}" alt="" class="w-239.75">
    </div>
    <div class="col-span-full md:col-span-6 p-5">
      <div class="space-y-3">
        <h2 class="uppercase font-bold text-5xl text-left">Retrato</h2>
        <p class="text-sm md:text-lg">Porque capturar la esencia de una persona en una imagen tiene algo fascinante.</p>
      </div>
    <div class="w-full mb-4">
      <div class="py-2.5 text-left">
        <span class="border w-[68%] border-amber-600 inline-block box-border"></span>
      </div>
    </div>
    </div>
  </div>
  <div class="grid grid-cols-12">
    {{-- Producto --}}
    <div class="col-span-full md:col-span-6 order-last md:order-first p-5">
      <div class="space-y-3">

        <h2 class="uppercase font-bold text-5xl text-left">Producto</h2>
        <p class="text-sm md:text-lg">La buena fotografía del producto incrementa la probabilidad de compra. </p>
      </div>
    <div class="w-full mb-4">
      <div class="py-2.5 text-left">
        <span class="border w-[68%] border-amber-600 inline-block box-border"></span>
      </div>
    </div>
    </div>
    <div class="col-span-full md:col-span-6">
      <img src="{{ asset('images/producto.jpg') }}" alt="">
    </div>
  </div>
  <div class="grid grid-cols-12">
    {{-- Estudio --}}
    <div class="col-span-full md:col-span-6">
      <img src="{{ asset('images/studio.jpg') }}" alt="">
    </div>
    <div class="col-span-full md:col-span-6 p-5">
      <div >
        <div class="space-y-3">
          <h2 class="uppercase font-bold text-5xl text-left">Estudio</h2>
          <p class="text-sm md:text-lg">Te guiaré en la búsqueda de tu mejor ángulo y expresiones, hasta capturar tu verdadera personalidad.</p>
        </div>
        <div class="w-full mb-4">
          <div class="py-2.5 text-left">
            <span class="border w-[68%] border-amber-600 inline-block box-border"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="grid grid-cols-12">
    {{-- Corporativo --}}
    <div class="col-span-full md:col-span-6 order-last md:order-first p-5">
      <div class="space-y-3">
        <h2 class="uppercase font-bold text-5xl text-left">Corporativo</h2>
        <p class="text-sm md:text-lg">La primera impresión es lo que más importa y nosotros logramos que lo transmitas. </p>
      </div>
    <div class="w-full mb-4">
      <div class="py-2.5 text-left">
        <span class="border w-[68%] border-amber-600 inline-block box-border"></span>
      </div>
    </div>
    </div>
    <div class="col-span-full md:col-span-6">
      <img src="{{ asset('images/abogada.jpg') }}" alt="">
    </div>
  </div>
</section>
{{-- NUESTRO TRABAJO --}}
<section class="bg-light-300 dark:bg-cont-100 p-5">
    <div class="max-w-7xl justify-center mx-auto">

        <h2 class="text-4xl font-semibold text-center">
            Nuestro trabajo
        </h2>
        <div class="max-w-7xl mx-auto mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
      @forelse ($sesiones as $sesion )
      <div class="relative group w-full max-w-md overflow-hidden rounded-md shadow-lg ">
        <img src="{{ Storage::url($sesion->imagen_foto) }}" 
          class="w-full object-cover transition-transform duration-300 group-hover:scale-125">

        <div
          class="absolute inset-0 bg-black/60 flex justify-center items-end opacity-0 group-hover:opacity-100 transition-opacity duration-300">
          <div
          class="text-center p-4 transform translate-y-10 group-hover:translate-y-0 transition-all duration-500 ease-in-out">
          <h3 class="text-white text-lg font-semibold">{{ $sesion->tipo }}</h3>
        </div>
    </div>
</div>
@empty
<div class=" mt-5 grid col-span-3 justify-items-center">
    No hay registro aún.
</div>
@endforelse
</div>
</div>
</section>
{{-- PAQUETES --}}
<section class="max-w-7xl justify-center mx-autopy-10 px-8 mx-auto items-center">
    <div class=" text-center max-w-4xl mx-auto">
    <p class="mt-2 font-bold tracking-tight text-5xl leading-none">
      Paquetes de fotografía.
    </p>
  </div>
   <p class="mx-auto mt-6 max-w-2xl text-center text-xl leading-8 text-slate-200 dark:text-slate-100">
    Hemos distintos paquetes que puedes cumplpir con tun intereses.
  </p>
  <div class="grid my-10 gap-9 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-max-7xl container mx-auto">
    @foreach ($paquetes as $paquete)
    <div class="rounded-3xl ring-1 ring-link-100">
      <div class=" flex flex-col items-center justify-center mt-5">
        <h3 class="text-3xl font-semibold leading-8 text-link-100 ">{{ $paquete->titulo }}</h3>
        <p class="mt-2 leading-6 text-sm text-center p-3">
          {{ $paquete->descripcion}}
        </p>
      </div>
      <p class="flex justify-center p-2 items-baseline my-3 text-center bg-btn-400">
        <span class="text-4xl font-bold tracking-tight">
          ${{ $paquete->precio }}
        </span>
        <span class="text-xs font-semibold leading-6"> MXN</span>
      </p>

      <div class="plan-content mb-4">
        {!! $paquete->contenido !!}
      </div>
    </div>
    @endforeach
  </div>
   <div class="text-center justify-center mx-auto">
    <p class="text-xl">Los precios antes mencionados, pueden o no ser por hora y pueden cambiar sin previo aviso.</p>
    <div class="flex items-center gap-2 justify-center mx-auto mt-5">
     @livewire('agendar-cita')
      
    </div>
  </div>
</section>

@endsection