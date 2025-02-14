<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::latest()->get();
        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:positions|max:255'
        ]);

        Position::create($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Cargo creado exitosamente');
    }

    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name,'.$position->id
        ]);

        $position->update($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Cargo actualizado correctamente');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('positions.index')
            ->with('success', 'Cargo eliminado correctamente');
    }
}