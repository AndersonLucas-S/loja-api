<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CadastrarNovosProdutosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'celulares' => 'required|array',
            'celulares.*.id' => 'required|exists:celulares,id',
            'celulares.*.quantidade' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'celulares.required' => 'A lista de celulares é obrigatória.',
            'celulares.array' => 'A lista de celulares deve ser um array.',
            'celulares.*.id.required' => 'O id do celular é obrigatório.',
            'celulares.*.id.exists' => 'O celular com o id fornecido não existe.',
            'celulares.*.quantidade.required' => 'A quantidade é obrigatória.',
            'celulares.*.quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'celulares.*.quantidade.min' => 'A quantidade deve ser pelo menos 1.'
        ];
    }
}
