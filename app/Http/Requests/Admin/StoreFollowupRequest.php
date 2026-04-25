<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFollowupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'collaborator']);
    }

    public function rules(): array
    {
        return [
            'visit_date'       => ['required', 'date', 'before_or_equal:today'],
            'animal_condition' => ['required', 'in:good,fair,poor'],
            'home_condition'   => ['required', 'in:adequate,needs_improvement,inadequate'],
            'observations'     => ['required', 'string', 'min:10', 'max:2000'],
            'photos'           => ['nullable', 'array', 'max:5'],
            'photos.*'         => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'visit_date.required'        => 'La fecha de visita es obligatoria.',
            'visit_date.date'            => 'La fecha de visita no es válida.',
            'visit_date.before_or_equal' => 'La fecha de visita no puede ser en el futuro.',
            'animal_condition.required'  => 'El estado del animal es obligatorio.',
            'animal_condition.in'        => 'El estado del animal seleccionado no es válido.',
            'home_condition.required'    => 'La condición del hogar es obligatoria.',
            'home_condition.in'          => 'La condición del hogar seleccionada no es válida.',
            'observations.required'      => 'Las observaciones son obligatorias.',
            'observations.min'           => 'Las observaciones deben tener al menos :min caracteres.',
            'observations.max'           => 'Las observaciones no pueden exceder :max caracteres.',
            'photos.max'                 => 'No puedes subir más de 5 fotografías.',
            'photos.*.image'             => 'Cada archivo debe ser una imagen.',
            'photos.*.mimes'             => 'Las imágenes deben ser JPG, PNG o WebP.',
            'photos.*.max'               => 'Cada imagen no puede superar los 5 MB.',
        ];
    }
}
