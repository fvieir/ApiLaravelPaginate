<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeiculoRequest extends FormRequest
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
            'marca' => 'required',
            'modelo' => 'required',
            'ano' => 'required|numeric|min:0',
            'preco' => 'required|numeric|min:0'
        ];
    }

   /*  public function message()
    {
        return [
            'marca.required' => "Preencha a marca do veiculo !"
        ];
    } */
}
