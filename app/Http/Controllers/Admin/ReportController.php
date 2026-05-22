<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdoptionRequestStatus;
use App\Enums\AnimalStatus;
use App\Http\Controllers\Controller;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Models\PostAdoptionFollowup;
use App\Models\Setting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function animalMedicalReport(Animal $animal): Response
    {
        $animal->load([
            'photos'         => fn ($q) => $q->orderByDesc('is_primary')->orderBy('id'),
            'medicalRecords' => fn ($q) => $q->orderByDesc('date')->orderByDesc('id'),
            'cedente',
        ]);

        $settings = Setting::pluck('value', 'key')->toArray();
        $pdf = Pdf::loadView('admin.reports.animal-medical', compact('animal', 'settings'));

        $filename = 'ficha-medica-' . \Illuminate\Support\Str::slug($animal->name) . '-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }

    public function shelterStatistics(): Response
    {
        $spanishMonths = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        $totalAnimals = Animal::whereIn('status', [
            AnimalStatus::Available->value,
            AnimalStatus::InProcess->value,
            AnimalStatus::Quarantine->value,
        ])->count();

        $availableAnimals = Animal::available()->count();

        $totalAdoptions = AdoptionRequest::where('status', AdoptionRequestStatus::Approved->value)->count();

        $adoptionsThisMonth = AdoptionRequest::where('status', AdoptionRequestStatus::Approved->value)
            ->whereYear('updated_at', now()->year)
            ->whereMonth('updated_at', now()->month)
            ->count();

        $totalUsers = User::count();

        $pendingAdoptionRequests = AdoptionRequest::pending()->count();

        $adoptedAnimals = Animal::where('status', AnimalStatus::Adopted->value)
            ->whereNotNull('entry_date')
            ->with(['adoptionRequests' => fn ($q) => $q
                ->where('status', AdoptionRequestStatus::Approved->value)
                ->whereNotNull('approved_at')])
            ->get();

        $diffs = $adoptedAnimals->flatMap(function ($animal) {
            return $animal->adoptionRequests->map(
                fn ($req) => $animal->entry_date->diffInDays($req->approved_at)
            );
        })->filter();

        $avgStay = $diffs->isNotEmpty() ? (int) round($diffs->avg()) : null;

        $speciesDistribution = Animal::where('status', '!=', AnimalStatus::Deceased->value)
            ->selectRaw('species, COUNT(*) as total')
            ->groupBy('species')
            ->get();

        $speciesTotal = $speciesDistribution->sum('total');

        $statusDistribution = Animal::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        $statusTotal = $statusDistribution->sum('total');

        $adoptionsByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $count = AdoptionRequest::where('status', AdoptionRequestStatus::Approved->value)
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->count();
            $adoptionsByMonth[] = [
                'month' => $spanishMonths[$date->month - 1] . ' ' . $date->year,
                'count' => $count,
            ];
        }

        $adoptionsMonthTotal = array_sum(array_column($adoptionsByMonth, 'count'));

        $settings = Setting::pluck('value', 'key')->toArray();

        $pdf = Pdf::loadView('admin.reports.shelter-statistics', compact(
            'settings',
            'totalAnimals',
            'availableAnimals',
            'totalAdoptions',
            'adoptionsThisMonth',
            'avgStay',
            'totalUsers',
            'pendingAdoptionRequests',
            'speciesDistribution',
            'speciesTotal',
            'statusDistribution',
            'statusTotal',
            'adoptionsByMonth',
            'adoptionsMonthTotal',
        ));

        $filename = 'estadisticas-albergue-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }

    public function animalsList(Request $request): Response
    {
        $query = Animal::query()
            ->with(['photos' => fn ($q) => $q->where('is_primary', true)])
            ->latest();

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

        $animals = $query->get();

        $appliedFilters = array_filter([
            'species'    => $request->species,
            'status'     => $request->status,
            'sex'        => $request->sex,
            'entry_type' => $request->entry_type,
            'search'     => $request->search,
        ]);

        $settings = Setting::pluck('value', 'key')->toArray();
        $pdf = Pdf::loadView('admin.reports.animals-list', compact('animals', 'appliedFilters', 'settings'))
            ->setPaper('a4', 'landscape');

        $filename = 'listado-animales-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }
}
