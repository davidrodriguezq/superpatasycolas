<?php

namespace App\Http\Requests\Public;

use App\Enums\AdoptionRequestStatus;
use App\Enums\AnimalStatus;
use App\Models\Animal;
use App\Models\AdoptionRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdoptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->hasRole('adopter');
    }

    public function rules(): array
    {
        return [
            'housing_type'           => ['required', 'string', 'in:casa_propia,departamento,casa_alquilada,otro'],
            'household_members'      => ['required', 'integer', 'min:1', 'max:20'],
            'has_other_pets'         => ['required', 'boolean'],
            'other_pets_description' => ['nullable', 'required_if:has_other_pets,1', 'string', 'max:500'],
            'has_outdoor_space'      => ['required', 'boolean'],
            'motivation'             => ['required', 'string', 'min:50', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'housing_type.required'          => 'El tipo de vivienda es obligatorio.',
            'housing_type.in'                => 'El tipo de vivienda seleccionado no es válido.',
            'household_members.required'     => 'Indica cuántas personas viven en tu hogar.',
            'household_members.integer'      => 'El número de personas debe ser un número entero.',
            'household_members.min'          => 'Debe haber al menos 1 persona en el hogar.',
            'household_members.max'          => 'El número de personas no puede superar las 20.',
            'has_other_pets.required'        => 'Indica si tienes otras mascotas.',
            'has_other_pets.boolean'         => 'La respuesta sobre otras mascotas no es válida.',
            'other_pets_description.required_if' => 'Describe brevemente las mascotas que tienes actualmente.',
            'other_pets_description.max'     => 'La descripción no puede superar los 500 caracteres.',
            'has_outdoor_space.required'     => 'Indica si cuentas con espacio al aire libre.',
            'has_outdoor_space.boolean'      => 'La respuesta sobre espacio al aire libre no es válida.',
            'motivation.required'            => 'Cuéntanos por qué deseas adoptar.',
            'motivation.min'                 => 'La motivación debe tener al menos 50 caracteres.',
            'motivation.max'                 => 'La motivación no puede superar los 2000 caracteres.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $animal = $this->route('animal');

            if (! $animal instanceof Animal) {
                return;
            }

            if ($animal->status !== AnimalStatus::Available) {
                $validator->errors()->add('animal', 'Este animal ya no se encuentra disponible para adopción.');
                return;
            }

            $alreadyRequested = AdoptionRequest::query()
                ->where('user_id', $this->user()->id)
                ->where('animal_id', $animal->id)
                ->where('status', AdoptionRequestStatus::Pending->value)
                ->exists();

            if ($alreadyRequested) {
                $validator->errors()->add('animal', 'Ya tienes una solicitud pendiente para este animal.');
            }
        });
    }
}
