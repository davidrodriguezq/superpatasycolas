<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date'         => ['required', 'date', 'before_or_equal:today'],
            'type'         => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string', 'max:2000'],
            'veterinarian' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required'         => 'La fecha es obligatoria.',
            'date.date'             => 'La fecha no tiene un formato válido.',
            'date.before_or_equal'  => 'La fecha no puede ser posterior a hoy.',
            'type.required'         => 'El tipo de atención es obligatorio.',
            'type.max'              => 'El tipo no puede superar los 255 caracteres.',
            'description.required'  => 'La descripción es obligatoria.',
            'description.max'       => 'La descripción no puede superar los 2000 caracteres.',
            'veterinarian.max'      => 'El nombre del veterinario no puede superar los 255 caracteres.',
        ];
    }
}
