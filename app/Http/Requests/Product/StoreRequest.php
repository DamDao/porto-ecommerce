<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric|min:1',
            'sale_price' => 'numeric|lte:price', //lte là viết tắt của "less than or equal" (nhỏ hơn hoặc bằng).
            'image' => 'required',
            'description' => 'required',
            'is_trending' => 'required',
            'stock_quantity' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ko được để trống name',
            'name.unique' => $this->name . 'đã tồn tại',
            'price.required' => 'ko được để trống price',
            'price.numeric' => 'để số >0',
            'sale_price.numeric' => 'sale_price để số 0<= x <=price',
            'sale_price.lte' => 'sale_price để số 0<= x <price',
            'image.required' => 'ko được để trống image',
            'description.required' => 'ko được để trống description',
            'is_trending.required' => 'ko được để trống is_trending',
            'stock_quantity.required' => 'ko được để trống stock_quantity',
            'stock_quantity.numeric' => 'để số >=0',
        ];
    }
}
