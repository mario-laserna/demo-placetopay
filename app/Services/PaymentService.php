<?php


namespace App\Services;


use Dnetix\Redirection\Contracts\Gateway;
use Dnetix\Redirection\PlacetoPay;

class PaymentService
{
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
}
