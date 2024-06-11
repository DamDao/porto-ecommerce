<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|unique:categories,name,' . $this->id,
            'status' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => ':attribute Tên không được để trống',
            'name.unique' => ':attribute Tên đã tồn tại',
            'status.required' => ':attribute status không được để trống',
        ];
    }
}
