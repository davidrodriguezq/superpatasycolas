<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class StoreCessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('surrenderer');
    }

    public function rules(): array
    {
        return [
            'animal_name'           => 'required|string|max:255',
            'animal_species'        => 'required|in:dog,cat',
            'animal_breed'          => 'nullable|string|max:255',
            'animal_sex'            => 'required|in:male,female',
            'animal_approximate_age'=> 'required|string|max:50',
            'animal_weight'         => 'nullable|numeric|min:0|max:200',
            'animal_description'    => 'nullable|string|max:2000',
            'animal_condition'      => 'required|in:good,fair,poor',
            'reason'                => 'required|string|min:20|max:2000',
            'urgency'               => 'required|in:normal,urgent',
        ];
    }

    public function messages(): array
    {
        return [
            'animal_name.required'           => 'El nombre del animal es obligatorio.',
            'animal_name.max'                => 'El nombre no puede exceder 255 caracteres.',
            'animal_species.required'        => 'La especie del animal es obligatoria.',
            'animal_species.in'              => 'La especie debe ser Perro o Gato.',
            'animal_breed.max'               => 'La raza no puede exceder 255 caracteres.',
            'animal_sex.required'            => 'El sexo del animal es obligatorio.',
            'animal_sex.in'                  => 'El sexo debe ser Macho o Hembra.',
            'animal_approximate_age.required'=> 'La edad aproximada es obligatoria.',
            'animal_approximate_age.max'     => 'La edad no puede exceder 50 caracteres.',
            'animal_weight.numeric'          => 'El peso debe ser un número.',
            'animal_weight.min'              => 'El peso no puede ser negativo.',
            'animal_weight.max'              => 'El peso no puede exceder 200 kg.',
            'animal_description.max'         => 'La descripción no puede exceder 2000 caracteres.',
            'animal_condition.required'      => 'El estado del animal es obligatorio.',
            'animal_condition.in'            => 'El estado del animal no es válido.',
            'reason.required'                => 'El motivo de la cesión es obligatorio.',
            'reason.min'                     => 'El motivo debe tener al menos 20 caracteres.',
            'reason.max'                     => 'El motivo no puede exceder 2000 caracteres.',
            'urgency.required'               => 'La urgencia es obligatoria.',
            'urgency.in'                     => 'La urgencia no es válida.',
        ];
    }
}
