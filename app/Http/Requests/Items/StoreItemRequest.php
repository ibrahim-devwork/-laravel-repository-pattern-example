<?php

namespace App\Http\Requests\Items;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends BaseRequest
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
            "name"      => ['bail', 'required', 'max:250'],
            "price"     => ['bail', 'required', 'numeric'],
            "quantity"  => ['bail', 'required', 'integer'],
        ];
    }
}
