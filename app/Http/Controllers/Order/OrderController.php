<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Services\PaymentService;
use App\Services\ProductService;

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

    /**
     * Recibe los datos del formulario ya validados por el request y crea una nueva orden
     * en la base de datos
     *
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * A partir de la orden que llega como parametro muestra pantalla de resumen de la orden
     *
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function resume(Order $order){
        return view('order.resume')->with([
            'product' => $order->product,
            'order' => $order
        ]);
    }

    /**
     * Pantalla a la que llegan los usuarios cuando son redirigidos de la pasarela de pagos
     *
     * Valida el estado de la transacción y muestra resumen
     *
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function callback(Order $order){
        if($order->request_id){
            $placetopay = $this->paymentService->createPlacetopayObject();
            $response = $placetopay->query($order->request_id);

            if ($response->isSuccessful()) {
                if ($response->status()->isApproved()) {
                    // Pago aprobado
                    $order->request_error = '';
                    $order->status = Order::STATUS_PAYED;
                    $order->save();
                }else{
                    // Pago rechazado
                    $order->request_error = $response->status()->message();
                    $order->status = Order::STATUS_REJECTED;
                    $order->save();
                }
            } else {
                // Error en la transacción, se guarda detalle
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

    /**
     * A partir de la orden ya creada, define la comunicación con Placetopay, obtiene url dinámica y redirige al usuario
     * a esta url para que continúe le proceso de pago en Placetopay
     *
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    public function sendToPay(Order $order){
        //obtiene objeto de placetopay (datos de autenticación) y el request que se envía
        $placetopay = $this->paymentService->createPlacetopayObject();
        $request = $this->paymentService->createRequestPlacetopay($order);

        $response = $placetopay->request($request);
        if ($response->isSuccessful()) {
            /**
             * Se guardan detalles de la transaccion, id de la solicitud y url generada
             */
            $order->request_id = $response->requestId();
            $order->request_url = $response->processUrl();
            $order->save();

            //Redirige para continuar pago
            return redirect($response->processUrl());
        } else {
            /**
             * Error en la transacción, se guarda detalle
             */
            $order->request_error = $response->status()->message();
            $order->save();

            dd($response->status()->message());
        }
    }
}
