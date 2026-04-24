<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AcceptCessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['admin', 'collaborator']);
    }

    public function rules(): array
    {
        return [
            'initial_status' => 'required|in:available,quarantine',
        ];
    }

    public function messages(): array
    {
        return [
            'initial_status.required' => 'Debes seleccionar el estado inicial del animal.',
            'initial_status.in'       => 'El estado inicial debe ser "Disponible" o "En cuarentena".',
        ];
    }
}
