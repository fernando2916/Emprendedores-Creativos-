@extends('components.layouts.principal')

@section('titulo')
Resumen de Privacidad |
@endsection

@section('contenido')
<section class="relative w-full z-20">
  <div class="flex items-center justify-end max-w-7xl mx-5 md:mx-auto mt-5 gap-2">
    <i class="fa-solid fa-home"></i>
    <a href="{{ route('aviso.index') }}" wire:navigate>
      <h3 class="text-link-100">Ir al Centro de privacidad</h3>
    </a>
    <i class="fa-solid fa-angle-right"></i>
  </div>
  <div class="grid md:grid-cols-12 mx-5 max-w-7xl md:mx-auto">
    <div class="col-span-6 md:p-10 mt-5 space-y-3">
      <div class="">
        <h2 class="text-2xl md:text-3xl font-bold mb-3">
          Resumen Declaración de Privacidad
        </h2>
        <p class=" text-justify text-sm md:text-lg lg:text-xl">
          La Declaración de Privacidad es el documento legal que
          disponibilizamos para que conozcas cómo protegemos tus datos y
          cómo te ofrecemos una experiencia personalizada.
        </p>
      </div>
    </div>
    <div class="col-span-6">
     <img src="{{ asset('images/Hero.png') }}" alt="" class="p-10" />
    </div>
  </div>
</section>
{{-- {/* DATOS PERSONALES */} --}}
<section class="bg-slate-300 dark:bg-cont-100 p-5 my-10">
  <div class="grid grid-cols-1 md:grid-cols-12 max-w-7xl mx-5 md:mx-auto">
    <div class="col-span-10 space-y-5 ">
      <h2 class="text-2xl md:text-4xl font-semibold">
        ¿De dónde obtenemos tus datos personales?
      </h2>
      <p class="text-sm md:text-base text-justify">
        En algunos casos, los datos personales los das tú mismo al
        registrarte o al usar alguno de nuestros servicios. En otros, los
        recolectamos automáticamente al navegar en nuestras páginas o a
        través de fuentes confiables.
      </p>
      <p class="text-sm md:text-base text-justify">
        Ten en cuenta que no es obligatorio que nos des tus datos
        personales, pero es un requisito para usar nuestros servicios. Si
        la información que das no es precisa, no podemos brindarte la
        mejor experiencia. Si das información inexacta o falsa, podemos
        llegar a suspender los servicios que te brindamos o inhabilitar tu
        cuenta.
      </p>
    </div>
  </div>
</section>

{{-- {/* TIPOS DE DATOS */} --}}
<section class=" p-5 my-10">
  <div class="grid grid-cols-1 md:grid-cols-12 max-w-7xl mx-5 md:mx-auto space-y-5 ">
    <h2 class="text-2xl md:text-4xl font-semibold mb-3 col-span-full">
      ¿Qué tipos de datos recolectamos?
    </h2>
    <div class="col-span-full md:col-span-6 ">
      <ul class="space-y-5">
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Nombre elegido para operar en las plataformas de
              Emprendedores.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Número de documento o identificación válida.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Información y medios de pago.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Información transaccional y movimientos dentro de las
              plataformas.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Información sobre tu actividad y preferencias.
            </h3>
          </li>
        </div>
      </ul>
    </div>
    <div class="col-span-full md:col-span-6">
      <ul class="space-y-5">
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Nombre, imagen personal{" "}
              {`"foto personal de la identificación"`}.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-base md:text-lg">Datos de contacto.</h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-base md:text-lg">Datos biométricos.</h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Información sobre tu ubicación.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Dirección IP que utilizas al conectarte a nuestros
              servicios.
            </h3>
          </li>
        </div>
      </ul>
    </div>
  </div>
</section>
{{-- {/* QUE HACEMOS CON LOS DATOS */} --}}
<section class="bg-slate-300 dark:bg-cont-100 p-5 py-10">
  <div class="grid grid-cols-1 md:grid-cols-12 max-w-7xl mx-5 md:mx-auto place-items-center">
    <h2 class="text-2xl md:text-4xl font-semibold mb-5 col-span-full">
      ¿Qué hacemos con tus datos?
    </h2>
    <div class="col-span-11">
      <ul class="space-y-5">
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-home bg-btn-200 dark:bg-btn-600 text-white p-2 rounded-full text-[2.2rem]"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Brindarte los productos, servicios y/o beneficios que
              ofrecen las plataformas de Mercado Libre{" "}
              {`(Marketplace, Mercado Pago,
              Mercado Crédito, Mercado Envíos, Mercado Libre Clasificados,
              Mercado Libre Publicidad, etc)`}
              .
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-star bg-btn-200 dark:bg-btn-600 text-white p-2 rounded-full text-[2.2rem]"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Mejorar nuestros servicios, y desarrollar nuevos para
              ofrecerte una mejor experiencia.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-building-columns bg-btn-200 dark:bg-btn-600 text-white p-2 rounded-full text-[2.2rem]"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Cumplir con obligaciones legales y requerimientos de
              autoridades competentes.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-magnifying-glass bg-btn-200 dark:bg-btn-600 text-white p-2 rounded-full text-[2.2rem]"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Detectar y prevenir fraudes, para proteger la seguridad de
              nuestros usuarios y la sustentabilidad de las plataformas.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-shield-halved bg-btn-200 dark:bg-btn-600 text-white p-2 rounded-full text-[2.2rem]"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Proteger derechos de usuarios, de terceros o propios de
              Mercado Libre.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-handshake bg-btn-200 dark:bg-btn-600 text-white p-2 rounded-full text-[2.2rem]"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Colaborar con los titulares de propiedad intelectual en el
              ejercicio de sus derechos.
            </h3>
          </li>
        </div>
        <div>
          <li class="flex items-start gap-5">
            <div>
              <i class="fa-solid fa-tag bg-btn-200 dark:bg-btn-600 text-white p-2 rounded-full text-[2.2rem]"></i>
            </div>
            <h3 class="text-base md:text-lg">
              Efectuar anuncios, contactos publicitarios y promocionales.
            </h3>
          </li>
        </div>
      </ul>
    </div>
  </div>
</section>
{{-- {/* POR CUANTO TIEMPO */} --}}
<section class="p-5 grid md:grid-cols-12 mx-5 max-w-7xl md:mx-auto my-10">
  <div class="col-span-6 md:p-10 mt-5 space-y-3">
    <div class="">
      <h2 class="text-2xl md:text-3xl font-semibold mb-3">
        ¿Por cuánto tiempo almacenamos tus datos personales?
      </h2>
      <p class=" text-justify text-sm md:text-lg lg:text-xl">
        Podemos guardar algunos de los datos que nos pediste borrar para cumplir con alguna finalidad en la Declaración
        de Privacidad o un deber legal. Después de cumplir estos requisitos, los borraremos.
      </p>
    </div>
    <div class="">
      <h2 class="text-2xl md:text-3xl font-semibold mb-3">
        ¿A quiénes compartimos tus datos?
      </h2>
      <p class=" text-justify text-sm md:text-lg lg:text-xl">
        No vendemos ni comercializamos tus datos personales. Tampoco compartimos o transferimos tus datos personales a
        terceros, salvo que sean proveedores que contratamos para que actúen en nuestro nombre, Aliados comerciales,
        empresas del Grupo Mercado Libre, otros usuarios o visitantes de la plataforma, entre otros.
      </p>
    </div>
  </div>
  <div class="col-span-6 place-content-center">
    <img src="{{ asset('images/Hero.png') }}" alt="" class="p-10" />
  </div>
</section>

{{-- {/* FUNCIONES */} --}}
<section class="p-5 my-10 bg-slate-300 dark:bg-cont-100">
  <div class="grid grid-cols-1 md:grid-cols-12 max-w-7xl mx-5 md:mx-auto space-y-5 ">
    <h2 class="text-2xl md:text-4xl font-semibold mb-3 col-span-full">
      ¿Cómo funcionan los servicios de Mercado Libre para menores de edad?
    </h2>
    <p class="text-justify col-span-full">Lamentablemente los menores de edad, no tienen capacidad legal de contratar
      nuestro servicio, ya que de acuerdo a las leyes vigentes, no están autorizados para responder por transacciones
      comerciales.</p>
  </div>
</section>
{{-- {/* DERECHOS */} --}}
<section class="p-5 my-10">

  <div class="grid md:grid-cols-12 mx-5 max-w-7xl md:mx-auto">
    <div class="col-span-6 md:p-10 mt-5 space-y-3 md:order-1">
      <div class="">
        <h2 class="text-2xl md:text-3xl font-bold mb-3">
          ¿Cuáles son tus derechos?
        </h2>
        <p class=" text-justify text-sm md:text-lg lg:text-xl">
          Tienes derecho a acceder, actualizar, corregir y tener confidencialidad sobre tus datos. Así como a restringir
          el envío de publicidad, ofertas y promociones, revisar alguna decisión automatizada y oponerte a que usemos
          tus datos para una o varias finalidades.
        </p>
      </div>
      <div class="pt-5 place-content-center">
        <ul class="space-y-5">
          <div>
            <li class="flex items-start gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="text-base md:text-lg">
                Nombre elegido para operar en las plataformas de
                Emprendedores.
              </h3>
            </li>
          </div>
          <div>
            <li class="flex items-start gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="text-base md:text-lg">
                Nombre elegido para operar en las plataformas de
                Emprendedores.
              </h3>
            </li>
          </div>
          <div>
            <li class="flex items-start gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="text-base md:text-lg">
                Nombre elegido para operar en las plataformas de
                Emprendedores.
              </h3>
            </li>
          </div>
        </ul>
      </div>
    </div>
    <div class="col-span-6 place-content-center">
      <img src="{{ asset('images/Hero.png') }}" alt="" class="p-10" />
    </div>
  </div>
</section>
{{-- {/* COOKIES */} --}}
<section class="p-5 my-10 bg-slate-300 dark:bg-cont-100">
  <div class="grid grid-cols-1 md:grid-cols-12 max-w-7xl mx-5 md:mx-auto space-y-5 ">
    <h2 class="text-2xl md:text-4xl font-semibold mb-3 col-span-full">
      ¿Qué son las cookies?
    </h2>
    <p class="col-span-full">Son tecnologías que nos ayudan a conocer tus intereses.

    </p>
    <div class="col-span-full">
      <h3 class="text-lg md:text-xl font-semibold mb-3 col-span-full">
        ¿¿Para qué usamos la información que obtenemos de las cookies?
      </h3>
      <div>
        <ul class="space-y-5">
            <div>
            <li class="flex items-start gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="text-base md:text-lg">
                Mostrarte publicidad y oportunidades relevantes.
              </h3>
            </li>
          </div>
          <div>
            <li class="flex items-start gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="text-base md:text-lg">
               Mejorar nuestras ofertas y servicios.
              </h3>
            </li>
          </div>
          <div>
            <li class="flex items-start gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="text-base md:text-lg">
               Ayudarte a que no debas ingresar tu e-mail, contraseña o celular para ingresar a tu cuenta cada vez que nos visitas desde los mismos dispositivos que usas.
              </h3>
            </li>
          </div>
          <div>
            <li class="flex items-start gap-5">
              <div>
                <i class="fa-solid fa-check"></i>
              </div>
              <h3 class="text-base md:text-lg">
                Reforzar la seguridad de nuestros sitios.
              </h3>
            </li>
          </div>
        </ul>
        <p class="mt-5">
          En cualquier momento puedes eliminar las cookies almacenadas, configurar el navegador para que pida aprobación antes de almacenar las cookies o directamente evitar que se almacenen.
        </p>
      </div>
    </div>
  </div>
</section>
{{-- {/* CAMBIOS EN LA DECLARACIOÓN */} --}}
<section class="p-5 my-10 ">
  <div class="grid grid-cols-1 md:grid-cols-12 max-w-7xl mx-5 md:mx-auto space-y-5 place-content-center">
    <h2 class="text-2xl md:text-4xl font-semibold mb-3 col-span-full">
      Cambios en la Declaración de Privacidad
    </h2>
    <p class="text-justify col-span-full">Eventualmente podremos realizar actualizaciones en la Declaración de
      Privacidad. Ten presente que cualquier cambio importante, te notificaremos por nuestros canales habituales y en el
      caso que lo requiera pediremos nuevamente tu autorización.</p>
  </div>
</section>
@endsection