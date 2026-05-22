<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AnimalSpecies;
use App\Enums\AnimalStatus;
use App\Enums\EntryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAnimalRequest;
use App\Http\Requests\Admin\UpdateAnimalRequest;
use App\Models\Animal;
use App\Models\AnimalPhoto;
use App\Models\User;
use App\Notifications\AnimalStatusChanged;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AnimalController extends Controller
{
    public function index(Request $request): View
    {
        $query = Animal::query()->with(['photos' => fn ($q) => $q->orderByDesc('is_primary')])->latest();

        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
        }

        if ($request->filled('entry_type')) {
            $query->where('entry_type', $request->entry_type);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $animals = $query->paginate(12);

        return view('admin.animals.index', compact('animals'));
    }

    public function create(): View
    {
        return view('admin.animals.create');
    }

    public function store(StoreAnimalRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['photos', 'primary_photo']);

        $animal = Animal::create($data);

        $this->uploadPhotos(
            $animal,
            $request->file('photos', []),
            (int) $request->input('primary_photo', 0),
            markPrimary: true,
        );

        return redirect()
            ->route('admin.animals.show', $animal)
            ->with('success', 'Animal registrado correctamente.');
    }

    public function show(Animal $animal): View
    {
        $animal->load([
            'photos'                           => fn ($q) => $q->orderByDesc('is_primary')->orderBy('id'),
            'medicalRecords'                   => fn ($q) => $q->orderByDesc('date')->orderByDesc('id'),
            'cedente',
            'adoptionRequests.user',
            'adoptionRequests.followups'       => fn ($q) => $q->orderByDesc('visit_date'),
            'adoptionRequests.followups.photos',
        ]);

        return view('admin.animals.show', compact('animal'));
    }

    public function edit(Animal $animal): View
    {
        $animal->load(['photos' => fn ($q) => $q->orderByDesc('is_primary')->orderBy('id')]);

        return view('admin.animals.edit', compact('animal'));
    }

    public function update(UpdateAnimalRequest $request, Animal $animal): RedirectResponse
    {
        $newStatus  = AnimalStatus::from($request->input('status'));
        $oldStatus  = $animal->status;

        if (! $animal->canTransitionTo($newStatus)) {
            return back()
                ->withInput()
                ->with('error', "No se permite cambiar el estado de \"{$animal->status->label()}\" a \"{$newStatus->label()}\".");
        }

        $animal->update($request->safe()->except(['photos']));

        $this->uploadPhotos($animal, $request->file('photos', []));

        if ($oldStatus !== $newStatus && in_array($newStatus, [AnimalStatus::Adopted, AnimalStatus::Deceased], true)) {
            $admins = User::role(['admin', 'collaborator'])->get();
            Notification::send($admins, new AnimalStatusChanged($animal, $newStatus->value));
        }

        return redirect()
            ->route('admin.animals.show', $animal)
            ->with('success', 'Animal actualizado correctamente.');
    }

    public function destroy(Animal $animal): RedirectResponse
    {
        if ($animal->status === AnimalStatus::Adopted) {
            return back()->with('error', 'No se puede eliminar un animal en estado "Adoptado".');
        }

        if ($animal->hasActiveAdoptionRequests()) {
            return back()->with('error', 'No se puede eliminar: el animal tiene solicitudes de adopción activas.');
        }

        foreach ($animal->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }

        $animal->delete();

        return redirect()
            ->route('admin.animals.index')
            ->with('success', 'Animal eliminado correctamente.');
    }

    public function destroyPhoto(Animal $animal, AnimalPhoto $photo): RedirectResponse
    {
        if ($photo->animal_id !== $animal->id) {
            abort(404);
        }

        Storage::disk('public')->delete($photo->path);
        $wasPrimary = $photo->is_primary;
        $photo->delete();

        if ($wasPrimary) {
            $first = $animal->photos()->orderBy('id')->first();
            if ($first) {
                $first->update(['is_primary' => true]);
            }
        }

        return back()->with('success', 'Fotografía eliminada correctamente.');
    }

    public function setPrimaryPhoto(Animal $animal, AnimalPhoto $photo): RedirectResponse
    {
        if ($photo->animal_id !== $animal->id) {
            abort(404);
        }

        $animal->photos()->update(['is_primary' => false]);
        $photo->update(['is_primary' => true]);

        return back()->with('success', 'Fotografía principal actualizada.');
    }

    /**
     * @param  array<int, \Illuminate\Http\UploadedFile>  $files
     */
    private function uploadPhotos(Animal $animal, array $files, int $primaryIndex = 0, bool $markPrimary = false): void
    {
        if (empty($files)) {
            return;
        }

        $existingCount = $animal->photos()->count();
        $hasPrimary    = $animal->photos()->where('is_primary', true)->exists();

        foreach ($files as $index => $file) {
            $path = $file->store('animals', 'public');

            $isPrimary = false;
            if ($markPrimary && $existingCount === 0 && $index === $primaryIndex) {
                $isPrimary = true;
            } elseif (! $hasPrimary && $existingCount === 0 && $index === 0) {
                $isPrimary = true;
            }

            AnimalPhoto::create([
                'animal_id'  => $animal->id,
                'path'       => $path,
                'is_primary' => $isPrimary,
            ]);

            if ($isPrimary) {
                $hasPrimary = true;
            }
        }
    }
}
