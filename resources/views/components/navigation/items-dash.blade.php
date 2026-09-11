<div class="h-full px-3 pb-4 overflow-y-auto bg-light-100 dark:bg-nav-900 pt-5">
    <ul class="space-y-2 font-medium">
      <li>
        <a wire:navigate href="{{ route('dashboard') }}"
        wire:current.exact="bg-light-200 dark:bg-purple-700"
          class="flex items-center p-2 rounded-lg dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
          <i class="fa-solid fa-home"></i>
          <span class="ms-3">Inicio</span>
        </a>
      </li>
      {{-- @can('usuarios index')
  
      <li>
        <a wire:navigate href="{{ route('admin.users.index') }}"
          class="flex items-center p-2 rounded-lg dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
          <i class="fa-solid fa-users"></i>
          <span class="ms-3">Usuarios</span>
        </a>
      </li>
      @endcan
      @can('roles index')
  
      <li>
        <a href="{{ route('admin.roles.index') }}" wire:navigate
          class="flex items-center p-2 rounded-lg dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
          <i class="fa-solid fa-user-gear"></i>
          <span class="ms-3">
            Roles
          </span>
        </a>
      </li>
      @endcan
      @can('permisos index')
  
      <li>
        <a href="{{ route('admin.permissions.index') }}" wire:navigate
          class="flex items-center p-2 rounded-lg dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
          <i class="fa-solid fa-user-shield"></i>
          <span class="ms-3">
            Permisos
          </span>
        </a>
      </li>
      @endcan --}}
      @can('ver legales')
      <div>
          <p class="text-gray-400 ml-2">Legales</p>
        @can('avisoPriv index')
    
        <li>
          <a href="{{ route('admin.privacy.index') }}" wire:navigate wire:current.exact="bg-light-200 dark:bg-purple-700"
            class="flex items-center p-2 rounded-md dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
            <i class="fa-solid fa-file"></i>
            <span class="ms-3">
              Aviso de privacidad
            </span>
          </a>
        </li>
        @endcan
        @can('terminsCon index')
    
        <li>
          <a href="{{ route('admin.terminos.index') }}" wire:navigate wire:current.exact="bg-light-200 dark:bg-purple-700"
            class="flex items-center p-2 rounded-md dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
            <i class="fa-solid fa-file-lines"></i>
            <span class="ms-3">
              Terminos y condiciones
            </span>
          </a>
        </li>
        @endcan
      </div>
      @endcan
      @can('ver empresa')
      <div>
         <p class="text-gray-400 ml-2">Empresa</p>
        {{-- @can('contacto index')
    
        <li>
          <a href="{{ route('admin.contacto.index') }}" wire:navigate
            class="flex items-center p-2 rounded-lg dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
            <i class="fa-solid fa-envelope"></i>
            <span class="ms-3">
              Contacto
            </span>
          </a>
        </li>
        @endcan --}}
        @can('boletin index')
    
        <li>
          <a href="{{ route('admin.boletin.index') }}" wire:navigate
          wire:current.exact="bg-light-200 dark:bg-purple-700"
            class="flex items-center p-2 rounded-lg dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
            <i class="fa-solid fa-envelope-open"></i>
            <span class="ms-3">
              Boletin
            </span>
          </a>
        </li>
        @endcan
        {{-- @can('vacante index')
    
        <li>
          <a href="{{ route('admin.vacante.index') }}" wire:navigate
            class="flex items-center p-2 rounded-lg dark:text-white hover:bg-light-200 dark:hover:bg-nav-700 group">
            <i class="fa-solid fa-briefcase"></i>
            <span class="ms-3">
              Vacantes
            </span>
          </a>
        </li>
        @endcan --}}
      </div>
      @endcan
      @can('ver promo')
  
      <div>
        <p class="text-gray-400 ml-2">Promo</p>
        @can('banner index')
  
        <li>
          <a href="{{ route('admin.banner.index') }}" wire:navigate
          wire:current.exact="bg-light-200 dark:bg-purple-700"
            class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-image"></i>
            Diapositivas
          </a>
        </li>
        @endcan
        {{-- @can('aviso index')
  
        <li>
          <a href="{{ route('admin.aviso.index') }}" wire:navigate
            class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-bullhorn"></i>
            Avisos
          </a>
        </li>
        @endcan --}}
  
      </div>
      @endcan
      {{-- @can('ver glosario')
      <div>
        <p class="text-gray-400 ml-2">Recursos</p>
        @can('glosario index')
        
        <li>
          <a href="{{ route('admin.glosario.index') }}" wire:navigate
          class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
          <i class="fa-brands fa-glide-g"></i>
          Glosario
        </a>
      </li>
      @endcan
        @can('recurso index')
        
        <li>
          <a href="{{ route('admin.recursos.index') }}" wire:navigate
          class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
          <i class="fa-solid fa-download"></i>
      Recursos
        </a>
      </li>
      @endcan
    </div>
      @endcan
      @can('ver tienda')
        <div>
        <p class="text-gray-400 ml-2">Productos</p>
        @can('producto index')
  
        <li>
          <a href="{{ route('admin.producto.index') }}" wire:navigate
            class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-store"></i>
            Productos
          </a>
        </li>
        @endcan
        @can('categoria producto index')
  
        <li>
          <a href="{{ route('admin.categorias.index') }}" wire:navigate
            class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-tag"></i>
            Categorias Curso
          </a>
        </li>
        @endcan
        @can('subCategoria producto index')
        <li>
          <a href="{{ route('admin.subcategorias.index') }}" wire:navigate
            class="flex items-center w-full p-2 transition duration-75 rounded-lg gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-tags"></i>
            Sub Categorias Curso
          </a>
        </li>
        @endcan
        @can('especialidad producto index')
        <li>
          <a href="{{ route('admin.especialidad.index') }}" wire:navigate
            class="flex items-center w-full p-2 transition duration-75 rounded-lg gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-school"></i>
            Especialidad Curso
          </a>
        </li>
        @endcan
  
      </div>
      @endcan
  
      @can('ver curso')
        <div>
        <p class="text-gray-400 ml-2">Cursos</p>
        @can('curso index')
  
        <li>
          <a href="{{ route('admin.cursos.index') }}" wire:navigate
            class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-book"></i>
            Cursos
          </a>
        </li>
        @endcan
        @can('categoria curso index')
  
        <li>
          <a href="{{ route('admin.categorias.index') }}" wire:navigate
            class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-tag"></i>
            Categorias Curso
          </a>
        </li>
        @endcan
        @can('subCategoria curso index')
        <li>
          <a href="{{ route('admin.subcategorias.index') }}" wire:navigate
            class="flex items-center w-full p-2 transition duration-75 rounded-lg gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-tags"></i>
            Sub Categorias Curso
          </a>
        </li>
        @endcan
        @can('especialidad curso index')
        <li>
          <a href="{{ route('admin.especialidad.index') }}" wire:navigate
            class="flex items-center w-full p-2 transition duration-75 rounded-lg gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-school"></i>
            Especialidad Curso
          </a>
        </li>
        @endcan
  
      </div>
      @endcan --}}
  
      @can('ver blog')
  
      <div>
        <p class="text-gray-400 ml-2">Blog</p>
        @can('blog index')
  
        <li>
          <a href="{{ route('admin.blogs.index') }}" wire:navigate wire:current.exact="bg-light-200 dark:bg-purple-700"
            class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-book"></i>
            Publicaciones
          </a>
        </li>
        @endcan
        @can('categoria post index')
        <li>
          <a href="{{ route('admin.categories.index') }}" wire:navigate
          wire:current.exact="bg-light-200 dark:bg-purple-700"
            class="flex items-center w-full p-2 transition duration-75 rounded-lg gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
            <i class="fa-solid fa-tag"></i>
            Categorias Post
          </a>
        </li>
        @endcan
  
      </div>
      @endcan
      {{-- @can('ver diseño')
  
        <div>
            <p class="text-gray-400 ml-2">Diseño</p>
            @can('plan desing index')
  
              <li>
                <a href="{{ route('admin.plans.index') }}" wire:navigate
                  class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
                  <i class="fa-solid fa-dollar-sign"></i>
                  Planes Diseño
                </a>
              </li>
            @endcan
            @can('cotizacion desing index')
  
            <li>
              <a href="{{ route('admin.cotizacion.index') }}" wire:navigate
                class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
                <i class="fa-solid fa-folder-tree"></i>
                Cotizaciones Diseño
              </a>
            </li>
            @endcan
            @can('proyectos index')
  
            <li>
              <a href="{{ route('admin.proyecto.index') }}" wire:navigate
                class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
                <i class="fa-solid fa-briefcase"></i>
                Proyectos Diseño
              </a>
            </li>
            @endcan
            @can('opinion desing index')
            <li>
              <a href="{{ route('admin.opinion.index') }}" wire:navigate
                class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
                <i class="fa-solid fa-message"></i>
                Opiniones Diseño
              </a>
            </li>
            @endcan
        </div>
      @endcan
  
      @can('ver foto')
  
        <div>
            <p class="text-gray-400 ml-2">Fotografía</p>
            @can('paquete foto index')
  
              <li>
                <a href="{{ route('admin.paquete.index') }}" wire:navigate
                  class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
                  <i class="fa-solid fa-dollar-sign"></i>
                  Paquetes Foto
                </a>
              </li>
            @endcan
            @can('cotizacion foto index')
  
            <li>
              <a href="{{ route('admin.foto.index') }}" wire:navigate
                class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
                <i class="fa-solid fa-folder-tree"></i>
                Cotizaciones Foto
              </a>
            </li>
            @endcan
            @can('sesiones foto index')
  
            <li>
              <a href="{{ route('admin.sesion.index') }}" wire:navigate
                class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
                <i class="fa-solid fa-folder"></i>
                Portafolio
              </a>
            </li>
            @endcan
            @can('testimonio foto index')
            <li>
              <a href="{{ route('admin.testimonio.index') }}" wire:navigate
                class="flex items-center w-full p-2 transition duration-75 rounded-lg  gap-3 group hover:bg-light-300 dark:hover:bg-nav-700">
                <i class="fa-solid fa-message"></i>
                Testimonios Fotografía
              </a>
            </li>
            @endcan --}}
        </div>
      {{-- @endcan --}}
    </ul>
  </div>