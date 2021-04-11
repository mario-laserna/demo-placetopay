<?php


namespace App\Services;


use App\Models\Order\Order;
use Dnetix\Redirection\Contracts\Gateway;
use Dnetix\Redirection\PlacetoPay;

class PaymentService
{
    /**
     * Crea un objeto PlacetoPay que usa la librería para establecer conexión y autenticación
     *
     * @return PlacetoPay
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    public function createPlacetopayObject(){
        return new PlacetoPay([
            'login' => config('placetopay.login'),
            'tranKey' => config('placetopay.trankey'),
            'url' => config('placetopay.url'),
            'rest' => [
                'timeout' => 45, // (optional) 15 by default
                'connect_timeout' => 30, // (optional) 5 by default
            ]
        ]);
    }

    /**
     * Crea arreglo con datos requeridos en el request a la pasarela de pagos
     *
     * @param Order $order
     * @return array
     */
    public function createRequestPlacetopay(Order $order){
        return [
            'payment' => [
                'reference' => $order->id,
                'description' => 'Compra ' . $order->product->name . ' (Cantidad: '. $order->quantity .')',
                'amount' => [
                    'currency' => 'COP',
                    'total' => $order->total_order,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => config('placetopay.url_return') . $order->id,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];
    }
}
