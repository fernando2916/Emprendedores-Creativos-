<footer class="bg-light-100 dark:bg-nav-900">
  <h2 class="sr-only">Footer</h2>
  <div class="mx-auto px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
    <div class="xl:grid xl:grid-cols-3 xl:gap-8">
      <div class="grid grid-cols-2 gap-8 xl:col-span-2">
        <div class="md:grid md:grid-cols-2 md:gap-8">
            <!-- MENU -->
            <div>
              <h3 class="text-sm font-semibold mb-4 uppercase text-link-100">Menu</h3>
              <ul class="space-y-2 text-sm">
                <li><a wire:navigate 
                  href=") }}" class="hover:text-link-100">Blog</a></li>
                <li><a wire:navigate 
                  href=") }}" class="hover:text-link-100">Tienda</a></li>
                <li><a wire:navigate 
                  href="" class="hover:text-link-100">Cursos</a></li>
              </ul>
            </div>

            <!-- SOPORTE -->
            <div class="mt-8 md:mt-0">
              <h3 class="text-sm font-semibold mb-4 uppercase text-link-100">Soporte</h3>
              <ul class="space-y-2 text-sm">
                <li><a wire:navigate 
                  href=") }}" class="hover:text-link-100">Contacto</a></li>
                <li><a wire:navigate 
                  href=""" class="hover:text-link-100">Preguntas Frecuentes</a></li>
              </ul>
            </div>

        </div>
        <div class="md:grid md:grid-cols-2 md:gap-8">
            <!-- EMPRESA -->
            <div>
              <h3 class="text-sm font-semibold mb-4 uppercase text-link-100">Empresa</h3>
              <ul class="space-y-2 text-sm">
                <li><a wire:navigate 
                  href="" class="hover:text-link-100">Quiénes Somos</a></li>
                <li><a wire:navigate 
                  href=") }}" class="hover:text-link-100">Recursos</a></li>
                <li><a wire:navigate 
                  href=") }}" class="hover:text-link-100">Vacantes</a></li>
              </ul>
            </div>

            <!-- LEGAL -->
            <div class="mt-8 md:mt-0">
              <h3 class="text-sm font-semibold mb-4 uppercase text-link-100">Legal</h3>
              <ul class="space-y-2 text-sm">
                <li><a wire:navigate 
                  href="" class="hover:text-link-100">Facturación</a></li>
                <li><a wire:navigate 
                  href="" class="hover:text-link-100">Aviso de Privacidad</a></li>
                <li><a wire:navigate 
                  href="" class="hover:text-link-100">Términos y Condiciones</a></li>
              </ul>
            </div>
        </div>
      </div>
      <div class="mt-8 xl:mt-0">
        <h3 class="text-sm font-bold text-link-100 tracking-wider uppercase ">
          Suscríbete a Nuestro Boletín
        </h3>
        <p class="mt-4 text-sm dark:text-gray-300">
          Nos importa mucho tu privacidad, por lo tanto solo enviamos 5
          correos por mes.
        </p>
        {{-- @livewire('boletin') --}}
      </div>
    </div>
    <div class="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
      <div class="flex space-x-6 md:order-2">
        <a href="https://www.facebook.com/CreadoresCreativos.MX" class="hover:text-link-100" target="_blank"
          rel="noopener noreferrer">
          <i class="fa-brands fa-facebook"></i>
        </a>
        <a href="https://www.twitter.com/Creadores_Creat" class="hover:text-link-100" target="_blank"
          rel="noopener noreferrer">
          <i class="fa-brands fa-x-twitter"></i>
        </a>
        <a href="https://www.instagram.com/creadores_creat" class="hover:text-link-100" target="_blank"
          rel="noopener noreferrer">
          <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://www.youtube.com/@emprendedorescreativos2018" class="hover:text-link-100" target="_blank"
          rel="noopener noreferrer">
          <i class="fa-brands fa-youtube"></i>
        </a>
        <a href="https://www.pinterest.com.mx/emprendedorescreativos2019/" class="hover:text-link-100" target="_blank"
          rel="noopener noreferrer">
          <i class="fa-brands fa-pinterest"></i>
        </a>
        <a href="https://www.tiktok.com/@emprendedores_creativos" class="hover:text-link-100" target="_blank"
          rel="noopener noreferrer">
          <i class="fa-brands fa-tiktok"></i>
        </a>
      </div>
      <p class="mt-8 text-base md:mt-0 md:order-1">
        <a href="/" class="text-md text-link-100 font-semibold">
          Emprendedores Creativos &copy;
        </a>
        <span class="text-md font-semibold"> {{ now()->year }} </span>
        Todos los derechos reservados.
      </p>
    </div>
  </div>
</footer>