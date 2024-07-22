<?php

use App\Http\Controllers\FindCoordinatesController;
use Illuminate\Support\Facades\Route;

Route::get('/coordinates', FindCoordinatesController::class);
