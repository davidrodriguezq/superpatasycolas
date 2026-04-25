<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdoptionRequestStatus;
use App\Enums\AnimalStatus;
use App\Http\Controllers\Controller;
use App\Mail\AdoptionApproved;
use App\Mail\AdoptionRejected;
use App\Models\AdoptionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdoptionRequestController extends Controller
{
    public function index(Request $request): View
    {
        $query = AdoptionRequest::query()
            ->with(['user', 'animal'])
            ->recent();

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tracking_code', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', "%{$search}%"));
            });
        }

        $adoptionRequests = $query->paginate(15)->withQueryString();

        return view('admin.adoption-requests.index', compact('adoptionRequests'));
    }

    public function show(AdoptionRequest $adoptionRequest): View
    {
        $adoptionRequest->load([
            'user',
            'animal.photos'   => fn ($q) => $q->orderByDesc('is_primary')->orderBy('id'),
            'approvedBy',
            'followups'        => fn ($q) => $q->orderByDesc('visit_date'),
            'followups.photos',
        ]);

        return view('admin.adoption-requests.show', ['adoptionRequest' => $adoptionRequest]);
    }

    public function approve(AdoptionRequest $adoptionRequest): RedirectResponse
    {
        if ($adoptionRequest->status !== AdoptionRequestStatus::Pending) {
            return back()->with('error', 'Solo se pueden aprobar solicitudes en estado pendiente.');
        }

        DB::transaction(function () use ($adoptionRequest) {
            $adoptionRequest->update([
                'status'      => AdoptionRequestStatus::Approved,
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            $adoptionRequest->animal->update(['status' => AnimalStatus::Adopted]);

            AdoptionRequest::query()
                ->where('animal_id', $adoptionRequest->animal_id)
                ->where('id', '!=', $adoptionRequest->id)
                ->where('status', AdoptionRequestStatus::Pending->value)
                ->update([
                    'status'       => AdoptionRequestStatus::Rejected->value,
                    'rejected_at'  => now(),
                    'updated_at'   => now(),
                ]);
        });

        if ($adoptionRequest->user && $adoptionRequest->user->email) {
            Mail::to($adoptionRequest->user->email)
                ->send(new AdoptionApproved($adoptionRequest->fresh(['user', 'animal'])));
        }

        return redirect()
            ->route('admin.adoption-requests.show', $adoptionRequest)
            ->with('success', 'Solicitud aprobada. El animal ha sido marcado como adoptado.');
    }

    public function reject(AdoptionRequest $adoptionRequest): RedirectResponse
    {
        if ($adoptionRequest->status !== AdoptionRequestStatus::Pending) {
            return back()->with('error', 'Solo se pueden rechazar solicitudes en estado pendiente.');
        }

        DB::transaction(function () use ($adoptionRequest) {
            $adoptionRequest->update([
                'status'      => AdoptionRequestStatus::Rejected,
                'rejected_at' => now(),
            ]);

            $otherPending = AdoptionRequest::query()
                ->where('animal_id', $adoptionRequest->animal_id)
                ->where('id', '!=', $adoptionRequest->id)
                ->where('status', AdoptionRequestStatus::Pending->value)
                ->exists();

            if (! $otherPending && $adoptionRequest->animal->status === AnimalStatus::InProcess) {
                $adoptionRequest->animal->update(['status' => AnimalStatus::Available]);
            }
        });

        if ($adoptionRequest->user && $adoptionRequest->user->email) {
            Mail::to($adoptionRequest->user->email)
                ->send(new AdoptionRejected($adoptionRequest->fresh(['user', 'animal'])));
        }

        return redirect()
            ->route('admin.adoption-requests.show', $adoptionRequest)
            ->with('success', 'Solicitud rechazada.');
    }
}
