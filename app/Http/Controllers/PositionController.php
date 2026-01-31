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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:positions|max:255',
            'base_salary' => 'required|numeric|min:0'
        ]);

        Position::create($request->all());

        return back()->with('success', 'Position added successfully!');
    }

    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|max:255|unique:positions,name,' . $position->id,
            'base_salary' => 'required|numeric|min:0'
        ]);

        $position->update($request->all());

        return redirect()->route('positions.index')->with('success', 'Position updated successfully!');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return back()->with('success', 'Position removed.');
    }
}