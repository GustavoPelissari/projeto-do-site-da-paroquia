<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Users who can create news can also create events
        return $this->user()->canCreateNews();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048', // 2MB máximo
            ],
            'status' => ['required', 'in:scheduled,cancelled,completed'],
            'max_participants' => ['nullable', 'integer', 'min:1'],
            'requirements' => ['nullable', 'string'],
            'group_id' => ['nullable', 'exists:groups,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.max' => 'O título não pode ter mais de 255 caracteres.',
            'description.required' => 'A descrição é obrigatória.',
            'location.required' => 'O local é obrigatório.',
            'location.max' => 'O local não pode ter mais de 255 caracteres.',
            'start_date.required' => 'A data de início é obrigatória.',
            'start_date.after_or_equal' => 'A data de início deve ser hoje ou uma data futura.',
            'end_date.required' => 'A data de término é obrigatória.',
            'end_date.after_or_equal' => 'A data de término deve ser igual ou posterior à data de início.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, jpg, png ou webp.',
            'image.max' => 'A imagem não pode ser maior que 2MB.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser "agendado", "cancelado" ou "concluído".',
            'max_participants.integer' => 'O número máximo de participantes deve ser um número inteiro.',
            'max_participants.min' => 'O número máximo de participantes deve ser pelo menos 1.',
            'group_id.exists' => 'O grupo selecionado não existe.',
        ];
    }
}
