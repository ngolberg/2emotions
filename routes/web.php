<?php

Auth::routes();

Route::get('/logout-manual', function () {
  request()->session()->invalidate();
});

Route::post('/ulogin', 'UloginController@auth');

// Localization
// Cache::flush();
$lang = config('app.locale');
Route::get('/{lang}/js/lang.js', function ($lang) {
    $strings = Cache::rememberForever('lang.js?' . $lang, function () use ($lang) {

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');

Route::get('/{any}', 'AppController@index')->where('any', '.*');


