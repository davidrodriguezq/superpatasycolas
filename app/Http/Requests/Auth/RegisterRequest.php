<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'              => ['required', 'confirmed', Password::defaults()],
            'phone'                 => ['nullable', 'string', 'max:20'],
            'address'               => ['nullable', 'string', 'max:255'],
            'role_type'             => ['required', 'in:adopter,surrenderer'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'El nombre es obligatorio.',
            'name.max'              => 'El nombre no puede superar los 255 caracteres.',
            'email.required'        => 'El correo electrónico es obligatorio.',
            'email.email'           => 'Ingresa un correo electrónico válido.',
            'email.unique'          => 'Este correo electrónico ya está registrado.',
            'password.required'     => 'La contraseña es obligatoria.',
            'password.confirmed'    => 'La confirmación de contraseña no coincide.',
            'phone.max'             => 'El teléfono no puede superar los 20 caracteres.',
            'address.max'           => 'La dirección no puede superar los 255 caracteres.',
            'role_type.required'    => 'Debes indicar el motivo de tu registro.',
            'role_type.in'          => 'Selecciona una opción válida: adoptante o cedente.',
        ];
    }
}
