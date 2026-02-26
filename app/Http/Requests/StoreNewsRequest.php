<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048', // 2MB máximo
            ],
            'status' => ['required', 'in:draft,published'],
            'featured' => ['nullable', 'boolean'],
            'parish_group_id' => ['nullable', 'exists:groups,id'],
            'published_at' => ['nullable', 'date'],
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
            'content.required' => 'O conteúdo é obrigatório.',
            'featured_image.image' => 'O arquivo deve ser uma imagem.',
            'featured_image.mimes' => 'A imagem deve ser do tipo: jpeg, jpg, png ou webp.',
            'featured_image.max' => 'A imagem não pode ser maior que 2MB.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser "rascunho" ou "publicado".',
            'parish_group_id.exists' => 'O grupo selecionado não existe.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox to boolean
        if ($this->has('featured')) {
            $this->merge([
                'featured' => $this->boolean('featured'),
            ]);
        }

        // Set status based on action button
        if ($this->has('action')) {
            $this->merge([
                'status' => $this->action === 'publish' ? 'published' : 'draft',
            ]);
        }
    }
}
