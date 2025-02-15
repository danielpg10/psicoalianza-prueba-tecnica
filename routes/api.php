<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\City;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cities/{country}', function ($countryId) {
    return City::where('country_id', $countryId)->get();
});