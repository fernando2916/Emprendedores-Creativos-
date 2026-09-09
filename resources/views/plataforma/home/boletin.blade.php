<div>
    <div class=" overflow-hidden bg-light-300 dark:bg-cont-100 py-16 sm:py-24 lg:py-32">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-2">
          <div class="max-w-xl lg:max-w-lg">
            <h2 class="text-4xl font-semibold tracking-tight text-white">Suscribete  Nuestro Boletín</h2>
            <p class="mt-4 text-lg text-gray-300"> Enterate de las últimas Noticias, Promociones, Avisos, etc. ¡Qué no te tome por sorpresa!.</p>
            @livewire('boletin')
          </div>
          <dl class="grid grid-cols-1 gap-x-8 gap-y-10 sm:grid-cols-2 lg:pt-2">
           <div class="flex flex-col items-start">
                <div class="rounded-md bg-btn-200 text-white dark:bg-btn-400 p-2 ring-link-500">
                  <i class="fa-solid fa-calendar"></i>
                </div>
                <dt class="mt-4 font-semibold text-xl ">Artículos Mensuales </dt>
                <dd class="mt-2 leading-7 text-slate-300 text-justify">
                  Nos importa mucho tu privacidad y tu tiempo, por lo tanto solo enviamos 5 correos por mes. 
                </dd>
              </div>
              <div class="flex flex-col items-start">
                <div class="rounded-md bg-btn-200 text-white dark:bg-btn-400 p-2 ring-link-500">
                  <i class="fa-solid fa-hand"></i>
                </div>
                <dt class="mt-4 font-semibold text-xl ">No spam</dt>
                <dd class="mt-2 leading-7 text-slate-300 text-justify">
                  De la misma manera, evitamos enviarte demasiados correo para asi evitar llenarte de spam. Nuestro compromiso es informarte no aburrirte.
                </dd>
              </div>
          </dl>
        </div>
      </div>
    </div>