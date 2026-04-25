<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdoptionRequestStatus;
use App\Enums\AnimalStatus;
use App\Http\Controllers\Controller;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Models\CessionRequest;
use App\Models\PostAdoptionFollowup;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnimals = Animal::whereIn('status', [
            AnimalStatus::Available->value,
            AnimalStatus::InProcess->value,
            AnimalStatus::Quarantine->value,
        ])->count();

        $availableAnimals = Animal::available()->count();

        $adoptionsThisMonth = AdoptionRequest::where('status', AdoptionRequestStatus::Approved->value)
            ->whereYear('updated_at', now()->year)
            ->whereMonth('updated_at', now()->month)
            ->count();

        $totalAdoptions = AdoptionRequest::where('status', AdoptionRequestStatus::Approved->value)->count();

        $pendingAdoptionRequests = AdoptionRequest::pending()->count();

        $pendingCessionRequests = CessionRequest::pending()->count();

        $totalUsers = User::count();

        // Promedio de días entre entry_date y la fecha de aprobación para animales adoptados
        $adoptedAnimals = Animal::where('status', AnimalStatus::Adopted->value)
            ->whereNotNull('entry_date')
            ->with(['adoptionRequests' => fn($q) => $q
                ->where('status', AdoptionRequestStatus::Approved->value)
                ->whereNotNull('approved_at')])
            ->get();

        $diffs = $adoptedAnimals->flatMap(function ($animal) {
            return $animal->adoptionRequests->map(
                fn($req) => $animal->entry_date->diffInDays($req->approved_at)
            );
        })->filter();

        $avgStay = $diffs->isNotEmpty() ? (int) round($diffs->avg()) : null;

        // Adopciones por mes — últimos 6 meses (usando updated_at como fecha de aprobación)
        $spanishMonths = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $adoptionsByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = AdoptionRequest::where('status', AdoptionRequestStatus::Approved->value)
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->count();
            $adoptionsByMonth[] = [
                'month' => $spanishMonths[$date->month - 1] . ' ' . $date->year,
                'count' => $count,
            ];
        }

        // selectRaw justificado: agrupación por campo enum para gráficas de distribución.
        // Los casts del modelo se aplican al acceder al atributo en la instancia resultante.
        $speciesDistribution = Animal::where('status', '!=', AnimalStatus::Deceased->value)
            ->selectRaw('species, COUNT(*) as total')
            ->groupBy('species')
            ->get()
            ->mapWithKeys(fn($item) => [$item->species->label() => (int) $item->total]);

        $statusDistribution = Animal::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn($item) => [$item->status->label() => (int) $item->total]);

        $criticalCount = PostAdoptionFollowup::criticalCount();
        $criticalFollowups = PostAdoptionFollowup::critical()
            ->with(['adoptionRequest.animal', 'adoptionRequest.user'])
            ->latest('visit_date')
            ->limit(5)
            ->get();

        $recentAdoptionRequests = AdoptionRequest::with(['user', 'animal'])
            ->recent()
            ->limit(5)
            ->get();

        $recentCessionRequests = CessionRequest::with(['user'])
            ->recent()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalAnimals',
            'availableAnimals',
            'adoptionsThisMonth',
            'totalAdoptions',
            'pendingAdoptionRequests',
            'pendingCessionRequests',
            'totalUsers',
            'avgStay',
            'adoptionsByMonth',
            'speciesDistribution',
            'statusDistribution',
            'criticalCount',
            'criticalFollowups',
            'recentAdoptionRequests',
            'recentCessionRequests',
        ));
    }
}
