<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
<style>
    body {
    background-color: #000c1f;
    color: white;
  }

  main {
    height: 100vh;
  }

  .contenedor {
    display: flex;
    flex-direction: column;
    padding: 2.5rem;
  }

  .fondo {
    background-color: #00122e;
    justify-content: center;
    border-radius: 1rem;
    padding: 2rem;
  }

  .imagen {
    justify-content: center;
    align-items: center;
    display: flex;
    margin-inline: auto;
    margin: .75rem;
  }
  img {
    max-width: 100%;
    height: auto;
    width: 4rem;
  }
  .contenedor-saludo {
    margin: 0.75rem;
    
  }

  p {
    font-size: 1.125rem;
    line-height: 1.5rem;
  }

  .saludo {
    font-size: 18px;
    line-height: 20px;
    font-weight: 800;
  }

  .codigo {
    font-size: 1.5rem;
    font-weight: 800;
    margin: .5rem;
    background-color: #6e004c;
    padding: .5rem;
    border-radius: .5rem;
  }

  .prec {
    font-size: 15px;
    margin: .5rem;
  }

  .btn {
    margin: 1.25rem 0;
    margin-inline: auto;
    display: flex;
    align-items: center;
  }

  .link {
    color: white;
    text-decoration: none;
    font-weight: 600;
    background-color: #6e004c;
    border-radius: 6px;
    padding: 0.75rem 0.5rem;
    width: 100%;
    cursor: pointer;
    text-align: center;
    font-size: 1.25rem;
  }
  
  .centro {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: auto;
  }

</style>

</head>
<body>
  <main>
    <div class="contenedor">
      <div class="fondo">

        <div class="imagen">
          <img src="{{ asset('images/icono.png')}} " alt="icono de la empresa">
        </div>
        <div class="contenedor-saludo">

          <p >Hola
            <span class="saludo">{{$user->nombre_completo}}</span>,
            te has registrado satisfactioriamente en Emprendedores Creativos, ya casi esta todo listo, solo debes
            confirmar tu cuenta.
          </p>
          <div class="">

            <p class="">Utiliza el siguiente código para iniciar sesión en tu cuenta de Emprendedores Creativos
            </p>
            <div class="centro">

              <p class="text-lg font-medium">
                Este código expira en 15 minutos.
              </p>
              <span class="codigo">
                {{ $user->verification_code }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    </div>
  </main>

</body>
</html>