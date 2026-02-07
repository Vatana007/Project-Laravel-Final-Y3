<?php

namespace App\Http\Controllers;

use App\Models\Employee; // Use Employee Model
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        // Fetch from 'employees' table
        $employees = Employee::with('position')->latest()->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = Position::all();
        return view('employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email', // Check employees table
            'phone' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'start_date' => 'required|date', // Required by your DB
        ]);

        // Save to 'employees' table
        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position_id' => $request->position_id,
            'start_date' => $request->start_date,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee saved!');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'start_date' => 'required|date',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        // Find the record in the 'employees' table
        $employee = Employee::findOrFail($id);

        // Delete it
        $employee->delete();

        return back()->with('success', 'Employee record has been removed.');
    }
}