<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'shelter_name'         => 'required|string|max:255',
            'shelter_slogan'       => 'nullable|string|max:255',
            'shelter_description'  => 'nullable|string|max:1000',
            'shelter_district'     => 'required|string|max:255',
            'shelter_city'         => 'required|string|max:255',
            'shelter_phone'        => 'nullable|string|max:30',
            'shelter_email'        => 'nullable|email|max:255',
            'shelter_schedule'     => 'nullable|string|max:255',
            'shelter_facebook'     => 'nullable|url|max:500',
            'shelter_instagram'    => 'nullable|url|max:500',
            'shelter_mission'      => 'nullable|string|max:2000',
            'shelter_vision'       => 'nullable|string|max:2000',
            'shelter_history'      => 'nullable|string|max:5000',
            'shelter_privacy_note' => 'nullable|string|max:500',
        ], [
            'shelter_name.required'     => 'El nombre del albergue es obligatorio.',
            'shelter_name.max'          => 'El nombre no puede exceder 255 caracteres.',
            'shelter_district.required' => 'El distrito es obligatorio.',
            'shelter_city.required'     => 'La ciudad es obligatoria.',
            'shelter_email.email'       => 'El correo electrónico no tiene un formato válido.',
            'shelter_facebook.url'      => 'La URL de Facebook no es válida.',
            'shelter_instagram.url'     => 'La URL de Instagram no es válida.',
        ]);

        $keys = [
            'shelter_name', 'shelter_slogan', 'shelter_description',
            'shelter_district', 'shelter_city', 'shelter_phone',
            'shelter_email', 'shelter_schedule', 'shelter_facebook',
            'shelter_instagram', 'shelter_mission', 'shelter_vision',
            'shelter_history', 'shelter_privacy_note',
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key));
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Configuración guardada correctamente.');
    }
}
