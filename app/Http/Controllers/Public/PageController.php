<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        return view('public.pages.about');
    }

    public function contact()
    {
        return view('public.pages.contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        Mail::to('contacto@superpatasycolas.pe')
            ->send(new ContactMessage($validated));

        return back()->with('success', 'Tu mensaje fue enviado correctamente. Te responderemos pronto.');
    }
}
