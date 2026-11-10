<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tiempo de reserva de los pedidos
    |--------------------------------------------------------------------------
    |
    | Minutos durante los que un pedido pendiente puede conservar
    | el inventario y un cupón reservado.
    |
    */

    'reserva_minutos_orden' => (int) env('ORDEN_RESERVA_MINUTOS', 30),
];