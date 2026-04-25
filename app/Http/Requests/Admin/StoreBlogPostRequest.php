<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'          => ['required', 'string', 'max:255'],
            'content'        => ['required', 'string', 'min:50'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_published'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'El título es obligatorio.',
            'title.max'            => 'El título no puede superar los 255 caracteres.',
            'content.required'     => 'El contenido es obligatorio.',
            'content.min'          => 'El contenido debe tener al menos 50 caracteres.',
            'featured_image.image' => 'El archivo debe ser una imagen.',
            'featured_image.mimes' => 'La imagen debe ser jpg, jpeg, png o webp.',
            'featured_image.max'   => 'La imagen no puede superar los 5 MB.',
        ];
    }
}
