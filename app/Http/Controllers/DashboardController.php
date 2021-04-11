<?php

namespace App\Http\Controllers;


use App\Services\OrderService;

class DashboardController extends Controller
{
    private $orderService;

    public function __construct(OrderService $os)
    {
        $this->orderService = $os;
    }

    public function index(){
        $orders = $this->orderService->queryPaginate(15);
        return view('dashboard')->with([
            'orders' => $orders
        ]);
    }
}
