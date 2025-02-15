<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('country')->latest()->get();
        return view('cities.index', compact('cities'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('cities.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id'
        ]);

        City::create($validated);

        return redirect()->route('cities.index')
            ->with('success', 'Ciudad creada exitosamente');
    }

    public function edit(City $city)
    {
        $countries = Country::all();
        return view('cities.edit', compact('city', 'countries'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id'
        ]);

        $city->update($validated);

        return redirect()->route('cities.index')
            ->with('success', 'Ciudad actualizada correctamente');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')
            ->with('success', 'Ciudad eliminada correctamente');
    }
    
    public function show(City $city)
    {
        return response()->json([
            'data' => $city->load('country') 
        ]);
    }
}