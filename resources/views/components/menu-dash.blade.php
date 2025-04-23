<ul className="p-3 border-b">
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a href="/" className="flex items-center gap-3 p-3 text-lg">
      <FaHome />
      Inicio
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a href='/' className="flex items-center gap-3 p-3 text-lg">
      <FaUserShield />
      Panel Administrativo
    </a>
  </li>
  <li
    @click="showMenu = false"
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
  >
    <a href="/blog" className="flex items-center gap-3 p-3 text-xl">
      <FaBook />
      Blog
    </a>
  </li>
  <li
    @click="showMenu = false"
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
  >
    <a href="/tienda" className="flex items-center gap-3 p-3 text-xl">
      <FaShoppingBag />
      Tienda
    </a>
  </li>
  <li
    @click="showMenu = false"
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
  >
    <a href="/cursos" className="flex items-center gap-3 p-3 text-xl">
      <FaVideo />
      Cursos
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="notificaciones"
      className="flex items-center justify-between gap-3 p-3 text-lg"
    >
      <div className="flex items-center gap-3">
        <FaBell />
        Notificaciones
      </div>
      <div className=" flex text-alerts-500 items-center pr-3 justify-center text-3xl relative">
        <FaCircle />
        <span className="text-sm absolute mx-auto text-white">5</span>
      </div>
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/mi-cuenta/mis-cursos"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaLaptopCode />
      Mi aprendizaje
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/mi-cuenta/mis-compras"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaShoppingBag />
      Mis compras
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/mi-cuenta/mis-deseos"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaHeart />
      Lista de deseos
    </a>
  </li>

  {/* <li
      className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
      @click="showMenu = false"
    >
      <a href="mi-cuenta" className="flex items-center gap-3 p-3 text-lg">
        <FaUserCircle />
        Mi cuenta
      </a>
    </li> */}
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/facturacion"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaFileAlt />
      Facturación
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a href="/soporte" className="flex items-center gap-3 p-3 text-lg">
      <FaCog />
      Soporte técnico
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
    method='post'
      href={route('logout')}
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaSignOutAlt />
      Salir
    </a>
  </li>
</ul>
<ul className="p-3 border-b">
  <div className="flex items-center justify-start pl-7 text-a-500 font-semibold dark:text-slate-400 gap-3">
    <span className="">Nuestros Servicios</span>
  </div>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/diseno-grafico"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaPen />
      Diseño Gráfico
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/fotografia"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaCamera />
      Fotografía
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/diseno-y-desarrollo-web"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaLaptopCode />
      Diseño y Desarrollo Web
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/impresion"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaPrint />
      Impresión
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/asesorias"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaChalkboardTeacher />
      Asesorias
    </a>
  </li>
</ul>
<ul className="p-3 border-b">
  <div className="flex items-center justify-start pl-7 text-a-500 font-semibold dark:text-slate-400 gap-3">
    <span className="">Más de Emprendedores</span>
  </div>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/nosotros/sobre-nosotros"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaInfoCircle />
      Sobre Nosotros
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/contacto"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaMailBulk />
      Contacto
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/recursos"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaDownload />
      Recursos
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/bolsa-de-trabajo"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaBriefcase />
      Vacantes
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/nosotros/responsabilidad-social"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaNewspaper />
      Responsabilidad Social
    </a>
  </li>
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a
      href="/nosotros/politica-medioambiente"
      className="flex items-center gap-3 p-3 text-lg"
    >
      <FaEarthAmericas />
      Política de medio ambiente
    </a>
  </li>
</ul>
<ul className="p-2">
  <li
    className="hover:bg-slate-400 dark:hover:bg-nav-700 pl-3 rounded-lg transition-all"
    @click="showMenu = false"
  >
    <a href="/" className="text-sm text-a-100 font-semibold">
      Emprendedores Creativos &copy; 
    </a>
    <span className="text-sm font-semibold">
      {{ now()->year }} Todos los derechos reservados.
    </span>
  </li>
</ul>