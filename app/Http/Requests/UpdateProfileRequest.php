<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(auth()->id())],
            'phone'            => ['nullable', 'string', 'max:20'],
            'address'          => ['nullable', 'string', 'max:255'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password'         => ['nullable', 'confirmed', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                      => 'El nombre es obligatorio.',
            'name.max'                           => 'El nombre no puede superar los 255 caracteres.',
            'email.required'                     => 'El correo electrónico es obligatorio.',
            'email.email'                        => 'El correo electrónico no tiene un formato válido.',
            'email.unique'                       => 'Este correo electrónico ya está en uso por otra cuenta.',
            'phone.max'                          => 'El teléfono no puede superar los 20 caracteres.',
            'address.max'                        => 'La dirección no puede superar los 255 caracteres.',
            'current_password.required_with'     => 'Debes ingresar tu contraseña actual para poder cambiarla.',
            'current_password.current_password'  => 'La contraseña actual no es correcta.',
            'password.confirmed'                 => 'La confirmación de contraseña no coincide.',
            'password.min'                       => 'La nueva contraseña debe tener al menos 8 caracteres.',
        ];
    }
}
