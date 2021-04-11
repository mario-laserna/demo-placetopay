<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Services\ProductService;

class OrderController extends Controller
{
    private $productService;

    public function __construct(ProductService $ps){
        $this->productService = $ps;
    }

    /**
     * Show form page
     *
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Product $product){
        return view('order.create')->with([
            'product' => $product
        ]);
    }

    public function store(OrderRequest $request){
        $product = $this->productService->id($request->get('product_id'));

        $order = Order::create([
            'customer_name' => $request->get('name'),
            'customer_email' => $request->get('email'),
            'customer_mobile' => $request->get('mobile'),
            'product_id' => $product->id,
            'quantity' => $request->get('quantity'),
            'total_order' => ($product->price * $request->get('quantity')),
            'status' => Order::STATUS_CREATED
        ]);

        return redirect()->route('order.resume', ['id' => $order->id]);
    }

    public function resume(Order $order){
        return view('order.resume')->with([
            'product' => $order->product,
            'order' => $order
        ]);
    }
}
