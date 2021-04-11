<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $ps){
        $this->productService = $ps;
    }

    public function index() {
        $products = $this->productService->all();

        return view('welcome')->with([
            'products' => $products
        ]);
    }
}
