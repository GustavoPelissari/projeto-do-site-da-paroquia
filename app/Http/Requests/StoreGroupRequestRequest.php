<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->hasVerifiedEmail();
    }

    public function rules(): array
    {
        return [
            'group_id' => 'required|integer|exists:groups,id',
            'message' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'group_id.required' => 'Selecione um grupo para solicitar ingresso.',
            'group_id.exists' => 'O grupo selecionado não existe.',
            'message.max' => 'A mensagem não pode ter mais de 500 caracteres.',
        ];
    }
}
