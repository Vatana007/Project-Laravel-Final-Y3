<?php
namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();
        return view('positions.index', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:positions',
            'base_salary' => 'required|numeric'
        ]);
        Position::create($request->all());
        return back()->with('success', 'Position added!');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return back()->with('success', 'Position deleted!');
    }

    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate(['name' => 'required', 'base_salary' => 'required|numeric']);
        $position->update($request->all());
        return redirect()->route('positions.index')->with('success', 'Position updated successfully');
    }
}