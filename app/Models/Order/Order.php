<?php

namespace App\Models\Order;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_CREATED = 'CREATED';
    const STATUS_PAYED = 'PAYED';
    const STATUS_REJECTED = 'REJECTED';

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_mobile',
        'quantity',
        'total_order',
        'product_id',
        'request_id',
        'request_url',
        'status'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
