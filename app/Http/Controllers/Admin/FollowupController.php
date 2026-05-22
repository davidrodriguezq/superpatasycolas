<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdoptionRequestStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFollowupRequest;
use App\Models\AdoptionRequest;
use App\Models\PostAdoptionFollowup;
use App\Models\User;
use App\Notifications\CriticalFollowup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FollowupController extends Controller
{
    public function index(Request $request): View
    {
        $query = PostAdoptionFollowup::with([
            'adoptionRequest.animal.photos',
            'adoptionRequest.user',
        ]);

        if ($request->filled('animal_condition')) {
            $query->where('animal_condition', $request->animal_condition);
        }

        if ($request->filled('home_condition')) {
            $query->where('home_condition', $request->home_condition);
        }

        if ($request->filled('critical')) {
            $query->critical();
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('adoptionRequest', function ($q) use ($search) {
                $q->whereHas('animal', fn ($q2) => $q2->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('user', fn ($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }

        $followups = $query->latest('visit_date')->paginate(15)->withQueryString();

        return view('admin.followups.index', compact('followups'));
    }

    public function create(AdoptionRequest $adoptionRequest): View
    {
        abort_unless(
            $adoptionRequest->status === AdoptionRequestStatus::Approved,
            403,
            'Solo se pueden registrar seguimientos para adopciones aprobadas.'
        );

        $adoptionRequest->load(['animal.photos', 'user', 'followups']);

        return view('admin.followups.create', compact('adoptionRequest'));
    }

    public function store(StoreFollowupRequest $request, AdoptionRequest $adoptionRequest): RedirectResponse
    {
        abort_unless(
            $adoptionRequest->status === AdoptionRequestStatus::Approved,
            403,
            'Solo se pueden registrar seguimientos para adopciones aprobadas.'
        );

        $followup = $adoptionRequest->followups()->create([
            'visit_date'       => $request->visit_date,
            'animal_condition' => $request->animal_condition,
            'home_condition'   => $request->home_condition,
            'observations'     => $request->observations,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = Storage::disk('public')->putFile('followups', $photo);
                $followup->photos()->create(['path' => $path]);
            }
        }

        if ($followup->is_critical) {
            $followup->load(['adoptionRequest.animal', 'adoptionRequest.user']);
            $admins = User::role(['admin', 'collaborator'])->get();
            Notification::send($admins, new CriticalFollowup($followup));
        }

        return redirect()
            ->route('admin.followups.show', $followup)
            ->with('success', 'Seguimiento registrado correctamente.');
    }

    public function show(PostAdoptionFollowup $followup): View
    {
        $followup->load([
            'adoptionRequest.animal.photos',
            'adoptionRequest.user',
            'photos',
        ]);

        return view('admin.followups.show', compact('followup'));
    }

    public function destroy(PostAdoptionFollowup $followup): RedirectResponse
    {
        foreach ($followup->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }

        $followup->photos()->delete();
        $followup->delete();

        return redirect()
            ->route('admin.followups.index')
            ->with('success', 'Seguimiento eliminado correctamente.');
    }
}
