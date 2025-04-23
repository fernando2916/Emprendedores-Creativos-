<footer class="bg-slate-200 dark:bg-nav-900">
  <h2 class="sr-only">Footer</h2>
  <div class="mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
    <div class="xl:grid xl:grid-cols-3 xl:gap-8">
       <div class="mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-8">
        <!-- MENU -->
        <div>
          <h3 class="text-sm font-semibold mb-4 uppercase">Menu</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="/blog" class="hover:text-link-100">Blog</a></li>
            <li><a href="/tienda" class="hover:text-link-100">Tienda</a></li>
            <li><a href="/cursos" class="hover:text-link-100">Cursos</a></li>
          </ul>
        </div>
    
        <!-- SOPORTE -->
        <div>
          <h3 class="text-sm font-semibold mb-4 uppercase">Soporte</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="/contacto" class="hover:text-link-100">Contacto</a></li>
            <li><a href="/envios" class="hover:text-link-100">Envíos</a></li>
            <li><a href="/preguntas-freceuntes" class="hover:text-link-100">Preguntas Frecuentes</a></li>
          </ul>
        </div>
    
        <!-- EMPRESA -->
        <div>
          <h3 class="text-sm font-semibold mb-4 uppercase">Empresa</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="/quienes-somos" class="hover:text-link-100">Quiénes Somos</a></li>
            <li><a href="/recursos" class="hover:text-link-100">Recursos</a></li>
            <li><a href="/vacantes" class="hover:text-link-100">Vacantes</a></li>
          </ul>
        </div>
    
        <!-- LEGAL -->
        <div>
          <h3 class="text-sm font-semibold mb-4 uppercase">Legal</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="/facturacion" class="hover:text-link-100">Facturación</a></li>
            <li><a href="/aviso-de-privacidad" class="hover:text-link-100">Aviso de Privacidad</a></li>
            <li><a href="/terminos-y-condiciones" class="hover:text-link-100">Términos y Condiciones</a></li>
          </ul>
        </div>
      </div>
      <div class="mt-8 xl:mt-0">
        <h3 class="text-sm font-bold text-link-100 tracking-wider uppercase">
          Suscríbete a Nuestro Boletín
        </h3>
        <p class="mt-4 text-sm dark:text-gray-300">
          Nos importa mucho tu privacidad, por lo tanto solo enviamos 5
          correos por mes.
        </p>
        <form class="mt-4">
          <label
            htmlFor="correo"
            // name="correo electronico"
            class="text-link-100 font-semibold text-md"
          >
            Correo Electrónico
          </label>
          <div class="md:flex gap-2">
            <input
              id="correo"
              required
              type="email"
              placeholder="Ingresa tu Correo Electrónico"
              class="bg-transparent border-2 placeholder:text-black placeholder:font-semibold dark:placeholder:font-semibold dark:placeholder:text-gray-400 border-link-100 p-2 focus:shadow-md focus:shadow-link-200 rounded-md mt-3 md:mt-2 outline-none w-full md:w-[70%]"
            />
            <button class="bg-btn-200 hover:bg-btn-400 text-white dark:bg-btn-400 dark:hover:bg-btn-600 transition-all flex gap-1 items-center p-2 rounded-md mt-3 md:mt-2 text-md font-medium justify-center w-full md:w-[30%]">
              <i class="fa-solid fa-envelope"></i>
              Suscríbete
            </button>
          </div>
        </form>
      </div>
    </div>
    <div class="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
      <div class="flex space-x-6 md:order-2">
        <a href="https://www.facebook.com/CreadoresCreativos.MX" class="hover:text-link-100" target="_blank" rel="noopener noreferrer">
          <i class="fa-brands fa-facebook"></i>
        </a>
        <a href="https://www.twitter.com/Creadores_Creat" class="hover:text-link-100" target="_blank" rel="noopener noreferrer">
          <i class="fa-brands fa-x-twitter"></i>
        </a>
        <a href="https://www.instagram.com/creadores_creat" class="hover:text-link-100" target="_blank" rel="noopener noreferrer">
          <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://www.youtube.com/@emprendedorescreativos2018" class="hover:text-link-100" target="_blank" rel="noopener noreferrer">
          <i class="fa-brands fa-youtube"></i>
        </a>
        <a href="https://t.me/+8q0-Zd0_u3kzYWU5" class="hover:text-link-100" target="_blank" rel="noopener noreferrer">
          <i class="fa-brands fa-telegram"></i>
        </a>
        <a href="https://www.pinterest.com.mx/emprendedorescreativos2019/" class="hover:text-link-100" target="_blank" rel="noopener noreferrer">
          <i class="fa-brands fa-pinterest"></i>
        </a>
        <a href="https://www.tiktok.com/@emprendedores_creativos" class="hover:text-link-100" target="_blank" rel="noopener noreferrer">
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