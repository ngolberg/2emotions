<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function update(String $lang, Request $request)
    {
        if (in_array($lang, config('app.available_locale'))) {
            session(['lang' => $lang]);

            return session('lang');
        }

        return '';
    }
}
