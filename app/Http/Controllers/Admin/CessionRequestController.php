<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AnimalCondition;
use App\Enums\CessionRequestStatus;
use App\Enums\EntryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AcceptCessionRequest;
use App\Models\Animal;
use App\Models\CessionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CessionRequestController extends Controller
{
    public function index(Request $request): View
    {
        $query = CessionRequest::query()
            ->with(['user', 'animal'])
            ->recent();

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhere('animal_name', 'like', "%{$search}%");
            });
        }

        $cessionRequests = $query->paginate(15)->withQueryString();

        return view('admin.cession-requests.index', compact('cessionRequests'));
    }

    public function show(CessionRequest $cessionRequest): View
    {
        $cessionRequest->load(['user', 'animal']);

        return view('admin.cession-requests.show', compact('cessionRequest'));
    }

    public function accept(AcceptCessionRequest $request, CessionRequest $cessionRequest): RedirectResponse
    {
        if ($cessionRequest->status !== CessionRequestStatus::Pending) {
            return back()->with('error', 'Solo se pueden aceptar solicitudes pendientes.');
        }

        if (! $cessionRequest->animal_name) {
            return back()->with('error', 'Esta solicitud no tiene datos del animal y no puede ser aceptada automáticamente.');
        }

        $healthStatusMap = [
            AnimalCondition::Good->value => 'Buen estado general',
            AnimalCondition::Fair->value => 'Requiere evaluación',
            AnimalCondition::Poor->value => 'Requiere atención veterinaria',
        ];

        $animalName = $cessionRequest->animal_name;

        DB::transaction(function () use ($request, $cessionRequest, $healthStatusMap) {
            $animal = Animal::create([
                'name'            => $cessionRequest->animal_name,
                'species'         => $cessionRequest->animal_species,
                'breed'           => $cessionRequest->animal_breed,
                'sex'             => $cessionRequest->animal_sex,
                'approximate_age' => $cessionRequest->animal_approximate_age,
                'weight'          => $cessionRequest->animal_weight,
                'description'     => $cessionRequest->animal_description,
                'health_status'   => $healthStatusMap[$cessionRequest->animal_condition?->value ?? ''] ?? 'Sin información',
                'status'          => $request->initial_status,
                'entry_type'      => EntryType::Cession->value,
                'entry_date'      => now(),
                'user_id'         => $cessionRequest->user_id,
            ]);

            $cessionRequest->update([
                'status'    => CessionRequestStatus::Accepted->value,
                'animal_id' => $animal->id,
            ]);
        });

        return redirect()
            ->route('admin.cession-requests.show', $cessionRequest)
            ->with('success', "Cesión aceptada. Se ha registrado el animal \"{$animalName}\" en el sistema.");
    }

    public function reject(CessionRequest $cessionRequest): RedirectResponse
    {
        if ($cessionRequest->status !== CessionRequestStatus::Pending) {
            return back()->with('error', 'Solo se pueden rechazar solicitudes pendientes.');
        }

        $cessionRequest->update(['status' => CessionRequestStatus::Rejected->value]);

        return redirect()
            ->route('admin.cession-requests.show', $cessionRequest)
            ->with('success', 'Solicitud de cesión rechazada.');
    }
}
