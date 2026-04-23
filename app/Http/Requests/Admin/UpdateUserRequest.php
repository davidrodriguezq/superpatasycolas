<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isOwnAccount = auth()->id() === $this->route('user')?->id;

        return [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'role'    => $isOwnAccount
                ? ['nullable']
                : ['required', Rule::in(['admin', 'collaborator', 'adopter', 'surrenderer'])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'El nombre es obligatorio.',
            'name.max'       => 'El nombre no puede superar los 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email'    => 'El correo electrónico no tiene un formato válido.',
            'email.unique'   => 'Este correo electrónico ya está registrado por otra cuenta.',
            'phone.max'      => 'El teléfono no puede superar los 20 caracteres.',
            'address.max'    => 'La dirección no puede superar los 255 caracteres.',
            'role.required'  => 'El rol es obligatorio.',
            'role.in'        => 'El rol seleccionado no es válido.',
        ];
    }
}
