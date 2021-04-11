<?php

/***
 * Archivo de configuración de variables asociadas a pasarela de pagos PlacetoPay
 *
 * Los valores se toman de las variables de entorno, deben existir en .env
 */

return [
    'url' => env('PLACETOPAY_URL', 'NODATA'),
    'login' => env('PLACETOPAY_LOGIN', 'NODATA'),
    'trankey' => env('PLACETOPAY_TRANKEY', 'NODATA'),
    'url_return' => env('PLACETOPAY_URL_RETURN', 'NODATA'),
];
