<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultarVendaEspecificaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'venda_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'venda_id.required' => 'O campo venda_id é obrigatório',
        ];
    }
}
