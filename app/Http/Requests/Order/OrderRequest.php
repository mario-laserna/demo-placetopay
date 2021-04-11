<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:80',
            'email' => 'required|string|email|max:120',
            'mobile' => 'required|string|max:40',
            'quantity' => 'required|integer|min:1|max:9',
        ];
    }
}
