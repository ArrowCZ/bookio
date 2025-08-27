<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function set(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locale' => ['required', 'in:en,cs'],
        ]);

        session(['locale' => $validated['locale']]);

        // if ($request->user()) { $request->user()->update(['locale' => $validated['locale']]); }

        return back();
    }
}