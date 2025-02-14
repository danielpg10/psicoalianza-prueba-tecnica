<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::latest()->get();
        return view('countries.index', compact('countries'));
    }

    public function create()
    {
        return view('countries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:countries|max:255'
        ]);

        Country::create($validated);

        return redirect()->route('countries.index')
            ->with('success', 'País creado exitosamente');
    }

    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries,name,'.$country->id
        ]);

        $country->update($validated);

        return redirect()->route('countries.index')
            ->with('success', 'País actualizado correctamente');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')
            ->with('success', 'País eliminado correctamente');
    }
}