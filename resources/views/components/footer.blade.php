<footer class="bg-slate-200 dark:bg-nav-900">
  <h2 class="sr-only">Footer</h2>
  <div class="mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
    <div class="xl:grid xl:grid-cols-3 xl:gap-8">
       <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-8">
        <!-- MENU -->
        <div>
          <h3 class="text-sm font-semibold mb-4 uppercase">Menu</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:underline">Blog</a></li>
            <li><a href="#" class="hover:underline">Tienda</a></li>
            <li><a href="#" class="hover:underline">Cursos</a></li>
          </ul>
        </div>
    
        <!-- SOPORTE -->
        <div>
          <h3 class="text-sm font-semibold mb-4 uppercase">Soporte</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:underline">Contacto</a></li>
            <li><a href="#" class="hover:underline">Envíos</a></li>
            <li><a href="#" class="hover:underline">Preguntas Frecuentes</a></li>
          </ul>
        </div>
    
        <!-- EMPRESA -->
        <div>
          <h3 class="text-sm font-semibold mb-4 uppercase">Empresa</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:underline">Quiénes Somos</a></li>
            <li><a href="#" class="hover:underline">Recursos</a></li>
            <li><a href="#" class="hover:underline">Vacantes</a></li>
          </ul>
        </div>
    
        <!-- LEGAL -->
        <div>
          <h3 class="text-sm font-semibold mb-4 uppercase">Legal</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:underline">Facturación</a></li>
            <li><a href="#" class="hover:underline">Aviso de Privacidad</a></li>
            <li><a href="#" class="hover:underline">Términos y Condiciones</a></li>
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
              <FaEnvelope />
              Suscríbete
            </button>
          </div>
        </form>
      </div>
    </div>
    <div class="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
      <div class="flex space-x-6 md:order-2">
        social
      </div>
      <p class="mt-8 text-base md:mt-0 md:order-1">
        <Link href="/" class="text-md text-link-100 font-semibold">
          Emprendedores Creativos &copy; {""}
        </Link>
        <span class="text-md font-semibold">{{now}} </span>
        Todos los derechos reservados.
      </p>
    </div>
  </div>
  </footer>