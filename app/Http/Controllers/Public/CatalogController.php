<?php

namespace App\Http\Controllers\Public;

use App\Enums\AnimalSpecies;
use App\Enums\AdoptionRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Animal::available()->with('photos');

        if ($request->filled('species')) {
            $species = AnimalSpecies::tryFrom($request->species);
            if ($species) {
                $query->bySpecies($species);
            }
        }

        if ($request->filled('sex') && in_array($request->sex, ['male', 'female'])) {
            $query->bySex($request->sex);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $animals = $query->latest('entry_date')->paginate(12);

        return view('public.catalog.index', compact('animals'));
    }

    public function show(Animal $animal)
    {
        $animal->load('photos');

        $suggestions = Animal::available()
            ->with('photos')
            ->where('id', '!=', $animal->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $hasPendingRequest = false;
        if (auth()->check() && auth()->user()->hasRole('adopter')) {
            $hasPendingRequest = $animal->adoptionRequests()
                ->where('user_id', auth()->id())
                ->whereIn('status', [
                    AdoptionRequestStatus::Pending->value,
                    AdoptionRequestStatus::Approved->value,
                ])
                ->exists();
        }

        return view('public.catalog.show', compact('animal', 'suggestions', 'hasPendingRequest'));
    }
}
