<?php

namespace App\Http\Controllers\Public;

use App\Enums\AdoptionRequestStatus;
use App\Enums\AnimalStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreAdoptionRequest;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Models\User;
use App\Notifications\NewAdoptionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class AdoptionController extends Controller
{
    public function create(Animal $animal): View|RedirectResponse
    {
        $hasPending = AdoptionRequest::query()
            ->where('user_id', auth()->id())
            ->where('animal_id', $animal->id)
            ->where('status', AdoptionRequestStatus::Pending->value)
            ->exists();

        if ($hasPending) {
            return redirect()
                ->route('adoption.my-requests')
                ->with('warning', 'Ya tienes una solicitud pendiente para este animal.');
        }

        if ($animal->status !== AnimalStatus::Available) {
            return redirect()
                ->route('adoption.my-requests')
                ->with('error', 'Este animal ya no se encuentra disponible para adopción.');
        }

        $animal->load(['photos' => fn ($q) => $q->orderByDesc('is_primary')->orderBy('id')]);

        return view('public.adoption.create', compact('animal'));
    }

    public function store(StoreAdoptionRequest $request, Animal $animal): RedirectResponse
    {
        $data = $request->safe()->all();

        $adoptionRequest = AdoptionRequest::create([
            'user_id'                => auth()->id(),
            'animal_id'              => $animal->id,
            'housing_type'           => $data['housing_type'],
            'household_members'      => $data['household_members'],
            'previous_pets'          => (bool) $data['has_other_pets'],
            'other_pets_description' => $data['has_other_pets'] ? ($data['other_pets_description'] ?? null) : null,
            'has_outdoor_space'      => (bool) $data['has_outdoor_space'],
            'motivation'             => $data['motivation'],
            'status'                 => AdoptionRequestStatus::Pending->value,
            'tracking_code'          => $this->generateTrackingCode(),
        ]);

        $animal->update(['status' => AnimalStatus::InProcess]);

        $admins = User::role(['admin', 'collaborator'])->get();
        Notification::send($admins, new NewAdoptionRequest($adoptionRequest->load(['user', 'animal'])));

        return redirect()
            ->route('adoption.my-requests')
            ->with('success', "¡Solicitud enviada! Tu código de seguimiento es {$adoptionRequest->tracking_code}.");
    }

    public function myRequests(): View
    {
        $requests = AdoptionRequest::query()
            ->with(['animal.photos' => fn ($q) => $q->orderByDesc('is_primary')->orderBy('id')])
            ->byUser(auth()->id())
            ->recent()
            ->get();

        return view('public.adoption.my-requests', compact('requests'));
    }

    private function generateTrackingCode(): string
    {
        do {
            $code = 'SPC-' . now()->format('Ymd') . '-' . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            $exists = AdoptionRequest::where('tracking_code', $code)->exists();
        } while ($exists);

        return $code;
    }
}
