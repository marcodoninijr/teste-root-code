<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Altere para true. Se ficar false, o Laravel bloqueia o formulário com erro 403.
        return true; 
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date|before_or_equal:today',
            'destino' => 'required|string|in:NACIONAL,AMERICAS,EUROPA',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'bagagem' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Este campo é obrigatório.',
            'data_nascimento.before_or_equal' => 'A data de nascimento não pode ser uma data futura.',
            'destino.in' => 'Por favor, selecione um destino válido.',
            'data_fim.after_or_equal' => 'A data de fim não pode ser anterior à data de início.',
        ];
    }
}