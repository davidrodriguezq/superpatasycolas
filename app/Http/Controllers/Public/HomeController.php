<?php

namespace App\Http\Controllers\Public;

use App\Enums\AdoptionRequestStatus;
use App\Enums\AnimalStatus;
use App\Http\Controllers\Controller;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Models\BlogPost;

class HomeController extends Controller
{
    public function index()
    {
        $featuredAnimals = Animal::available()
            ->with('photos')
            ->latest('entry_date')
            ->limit(6)
            ->get();

        $stats = [
            'total'     => Animal::whereNotIn('status', [AnimalStatus::Deceased->value])->count(),
            'adoptions' => AdoptionRequest::where('status', AdoptionRequestStatus::Approved->value)->count(),
            'available' => Animal::available()->count(),
        ];

        $latestPosts = BlogPost::published()->latest()->limit(3)->get();

        return view('public.home', compact('featuredAnimals', 'stats', 'latestPosts'));
    }
}
