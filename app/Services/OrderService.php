<?php


namespace App\Services;


use App\Models\Order\Order;

class OrderService
{
    public function queryPaginate($ordersByPage=10){
        return Order::orderBy('created_at', 'desc')
            ->paginate($ordersByPage);
    }
}
