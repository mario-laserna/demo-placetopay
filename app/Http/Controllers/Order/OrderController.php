<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Services\PaymentService;
use App\Services\ProductService;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Request;

class OrderController extends Controller
{
    private $productService;
    private $paymentService;

    public function __construct(ProductService $ps, PaymentService $paymentService){
        $this->productService = $ps;
        $this->paymentService = $paymentService;
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

        return redirect()->route('order.resume', ['order' => $order->id]);
    }

    public function resume(Order $order){
        return view('order.resume')->with([
            'product' => $order->product,
            'order' => $order
        ]);
    }

    public function callback(Order $order){
        if($order->request_id){
            $placetopay = $this->paymentService->createPlacetopayObject();
            $response = $placetopay->query($order->request_id);

            //dd($response);
            //dd($response->isSuccessful());
            if ($response->isSuccessful()) {
                if ($response->status()->isApproved()) {
                    // The payment has been approved
                    $order->request_error = '';
                    $order->status = Order::STATUS_PAYED;
                    $order->save();
                }else{
                    $order->request_error = $response->status()->message();
                    $order->status = Order::STATUS_REJECTED;
                    $order->save();
                }
            } else {
                // There was some error with the connection so check the message
                //dd($response->status()->message());
                $order->request_error = $response->status()->message();
                $order->status = Order::STATUS_REJECTED;
                $order->save();
            }
        }else{
            dd('No order');
        }

        return view('order.resume')->with([
            'product' => $order->product,
            'order' => $order
        ]);
    }

    public function sendToPay(Order $order){
        $placetopay = $this->paymentService->createPlacetopayObject();

        $reference = $order->id;
        $request = [
            'payment' => [
                'reference' => $reference,
                'description' => 'Compra ' . $order->product->name . ' (Cantidad: '. $order->quantity .')',
                'amount' => [
                    'currency' => 'COP',
                    'total' => $order->total_order,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => config('placetopay.url_return') . $reference,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        $response = $placetopay->request($request);
        //dd($response);
        if ($response->isSuccessful()) {
            // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
            // Redirect the client to the processUrl or display it on the JS extension

            //header('Location: ' . $response->processUrl());

            /**
             * Se guardan detalles de la transaccion, id de la solicitud y url generada
             */
            $order->request_id = $response->requestId();
            $order->request_url = $response->processUrl();
            $order->save();

            //Redirige para continuar pago
            return redirect($response->processUrl());
        } else {
            // There was some error so check the message and log it

            $order->request_error = $response->status()->message();
            $order->save();

            dd($response->status()->message());
        }
    }
}
