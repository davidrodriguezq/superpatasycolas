<?php

namespace App\Http\Controllers\Public;

use App\Enums\CessionRequestStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreCessionRequest;
use App\Models\CessionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CessionController extends Controller
{
    public function create(): View
    {
        return view('public.cession.create');
    }

    public function store(StoreCessionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        CessionRequest::create(array_merge($data, [
            'user_id' => auth()->id(),
            'status'  => CessionRequestStatus::Pending->value,
        ]));

        return redirect()
            ->route('cession.my-requests')
            ->with('success', 'Tu solicitud de cesión ha sido enviada. Nuestro equipo la revisará y se pondrá en contacto contigo.');
    }

    public function myRequests(): View
    {
        $cessionRequests = auth()->user()
            ->cessionRequests()
            ->with('animal')
            ->latest()
            ->get();

        return view('public.cession.my-requests', compact('cessionRequests'));
    }
}
