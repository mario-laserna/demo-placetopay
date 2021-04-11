<?php


namespace App\Services;


use App\Models\Product\Product;

class ProductService
{
    public function all(){
        return Product::all();
    }

    public function id($id){
        return Product::find($id);
    }
}
