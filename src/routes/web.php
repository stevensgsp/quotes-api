<?php

use Illuminate\Support\Facades\Route;

Route::get('quotes', function () {
    return view('quotes::index');
});
