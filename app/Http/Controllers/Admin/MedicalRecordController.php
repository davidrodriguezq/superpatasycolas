<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedicalRecordRequest;
use App\Models\Animal;
use App\Models\MedicalRecord;
use Illuminate\Http\RedirectResponse;

class MedicalRecordController extends Controller
{
    public function store(StoreMedicalRecordRequest $request, Animal $animal): RedirectResponse
    {
        $animal->medicalRecords()->create($request->validated());

        return redirect()
            ->route('admin.animals.show', $animal)
            ->with('success', 'Registro clínico agregado correctamente.');
    }

    public function destroy(Animal $animal, MedicalRecord $medicalRecord): RedirectResponse
    {
        if ($medicalRecord->animal_id !== $animal->id) {
            abort(404);
        }

        $medicalRecord->delete();

        return redirect()
            ->route('admin.animals.show', $animal)
            ->with('success', 'Registro clínico eliminado correctamente.');
    }
}
