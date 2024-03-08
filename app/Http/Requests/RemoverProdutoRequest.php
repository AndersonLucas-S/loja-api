<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemoverProdutoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'produto_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'produto_id.required' => 'O id do produto é obrigatório.',
        ];
    }
}
