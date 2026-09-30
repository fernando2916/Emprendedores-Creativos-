<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Restablecer contraseña</title>
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

            .boton-contenedor {
                margin-top: 28px;
                margin-bottom: 28px;
            }

            .boton {
                display: inline-block;
                padding: 12px 24px;
                background-color: #6e004c;
                color: #ffffff !important;
                text-decoration: none;
                border-radius: 8px;
                font-size: 14px;
                font-weight: bold;
            }

            .aviso {
                margin-top: 28px;
                padding-top: 24px;
                border-top: 1px solid #e5e7eb;
            }

            .aviso-titulo {
                color: #374151;
                font-size: 16px;
                font-weight: bold;
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
                        <p> Recibimos tu solicitud para cambiar la contraseña de tu cuenta de <strong>Emprendedores
                                Creativos</strong>. </p>
                        <p> Para continuar con el proceso, haz clic en el siguiente botón: </p>
                        <div class="boton-contenedor"> <a class="boton"
                                href="{{ env('APP_URL') . '/auth/nueva-contraseña/' . $user->verification_id }}">
                                Cambiar contraseña </a> </div>
                        <div class="aviso">
                            <p class="aviso-titulo"> ¿No solicitaste esto? </p>
                            <p> Si recibiste este correo electrónico, pero no estás intentando restablecer tu
                                contraseña, puedes ignorarlo. No se ha realizado ningún cambio en tu cuenta. </p>
                        </div>
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
