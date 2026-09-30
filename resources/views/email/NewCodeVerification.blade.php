<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Nuevo código de verificación</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                background-color: #f3f4f6;
                font-family: Arial, Helvetica, sans-serif;
            }

            .contenedor {
                width: 100%;
                padding: 40px 0;
            }

            .correo {
                width: 100%;
                max-width: 672px;
                margin: 0 auto;
                background-color: #ffffff;
            }

            .contenido {
                padding: 32px;
            }

            .logo {
                display: block;
                height: 40px;
                width: auto;
                margin-bottom: 32px;
            }

            h2 {
                margin: 0;
                color: #374151;
                font-size: 24px;
                line-height: 32px;
            }

            p {
                color: #4b5563;
                font-size: 16px;
                line-height: 26px;
                margin: 12px 0 0;
            }

            .codigo-contenedor {
                margin-top: 24px;
            }

            .codigo {
                display: inline-block;
                width: 42px;
                height: 42px;
                line-height: 42px;
                margin-right: 6px;
                text-align: center;
                border: 1px solid #6e004c;
                border-radius: 8px;
                color: #6e004c;
                background-color: #ffffff;
                font-size: 24px;
                font-weight: bold;
            }

            .aviso {
                margin-top: 20px;
            }

            .despedida {
                margin-top: 32px;
            }

            .footer {
                padding: 24px 32px 32px;
            }

            .footer p {
                color: #6b7280;
                font-size: 13px;
                line-height: 20px;
            }

            .footer a {
                color: #6e004c;
                text-decoration: none;
            }

            @media only screen and (max-width: 600px) {

                .contenido,
                .footer {
                    padding-left: 20px;
                    padding-right: 20px;
                }

                .codigo {
                    width: 38px;
                    height: 38px;
                    line-height: 38px;
                    font-size: 21px;
                }
            }
        </style>
    </head>

    <body>
        <div class="contenedor">
            <div class="correo">
                <div class="contenido"> <!-- Logo --> <img src="{{ $message->embed(public_path('images/icono.png')) }}"
                        alt="Emprendedores Creativos" class="logo">
                    <main>
                        <h2> Hola {{ $user->nombre_completo }}, </h2>
                        <p> Al parecer tu código de verificación anterior ha expirado. No te preocupes, hemos generado
                            uno nuevo para ti. </p>
                        <p> Utiliza el siguiente código para verificar e iniciar sesión en tu cuenta de
                            <strong>Emprendedores Creativos</strong>. </p> <!-- Código -->
                        <div class="codigo-contenedor">
                            @foreach (str_split($user->verification_code) as $numero)
                                <span class="codigo"> {{ $numero }} </span>
                            @endforeach
                        </div>
                        <p class="aviso"> Este código será válido durante los próximos <strong>15 minutos</strong>.
                        </p>
                        <p class="despedida"> Gracias,<br> <strong>Equipo de Emprendedores Creativos</strong> </p>
                    </main>
                </div>
                <footer class="footer">
                    <p> Este correo fue enviado a <a href="mailto:{{ $user->email }}"> {{ $user->email }} </a>. </p>
                    <p> © {{ date('Y') }} Emprendedores Creativos. Todos los derechos reservados. </p>
                </footer>
            </div>
        </div>
    </body>

</html>
