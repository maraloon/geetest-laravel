<?php

use App\Http\Controllers\GeetestController;

Route::get(
    "/",
    function () {
        View::addExtension("html", "php");
        return view()->file("index.html");
    }
);

Route::get('register', [GeetestController::class, 'register']);
Route::post('validate', [GeetestController::class, 'validateCaptcha']);
