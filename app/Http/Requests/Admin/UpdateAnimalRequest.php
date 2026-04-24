<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'species'         => ['required', 'in:dog,cat'],
            'breed'           => ['nullable', 'string', 'max:255'],
            'sex'             => ['required', 'in:male,female'],
            'approximate_age' => ['required', 'string', 'max:50'],
            'weight'          => ['nullable', 'numeric', 'min:0', 'max:200'],
            'health_status'   => ['nullable', 'string', 'max:500'],
            'description'     => ['nullable', 'string', 'max:2000'],
            'status'          => ['required', 'in:available,in_process,adopted,quarantine,deceased'],
            'entry_type'      => ['required', 'in:rescue,cession'],
            'entry_date'      => ['required', 'date', 'before_or_equal:today'],
            'photos'          => ['nullable', 'array', 'max:5'],
            'photos.*'        => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'            => 'El nombre es obligatorio.',
            'name.max'                 => 'El nombre no puede superar los 255 caracteres.',
            'species.required'         => 'La especie es obligatoria.',
            'species.in'               => 'La especie seleccionada no es válida.',
            'breed.max'                => 'La raza no puede superar los 255 caracteres.',
            'sex.required'             => 'El sexo es obligatorio.',
            'sex.in'                   => 'El sexo seleccionado no es válido.',
            'approximate_age.required' => 'La edad aproximada es obligatoria.',
            'approximate_age.max'      => 'La edad aproximada no puede superar los 50 caracteres.',
            'weight.numeric'           => 'El peso debe ser un número.',
            'weight.min'               => 'El peso no puede ser negativo.',
            'weight.max'               => 'El peso no puede superar los 200 kg.',
            'health_status.max'        => 'El estado de salud no puede superar los 500 caracteres.',
            'description.max'          => 'La descripción no puede superar los 2000 caracteres.',
            'status.required'          => 'El estado es obligatorio.',
            'status.in'                => 'El estado seleccionado no es válido.',
            'entry_type.required'      => 'El tipo de ingreso es obligatorio.',
            'entry_type.in'            => 'El tipo de ingreso seleccionado no es válido.',
            'entry_date.required'      => 'La fecha de ingreso es obligatoria.',
            'entry_date.date'          => 'La fecha de ingreso no tiene un formato válido.',
            'entry_date.before_or_equal' => 'La fecha de ingreso no puede ser posterior a hoy.',
            'photos.array'             => 'Las fotografías deben enviarse como un conjunto de archivos.',
            'photos.max'               => 'No puedes subir más de 5 fotografías.',
            'photos.*.image'           => 'Cada archivo debe ser una imagen válida.',
            'photos.*.mimes'           => 'Las imágenes deben ser JPG, JPEG, PNG o WEBP.',
            'photos.*.max'             => 'Cada imagen no puede superar los 5 MB.',
        ];
    }
}
