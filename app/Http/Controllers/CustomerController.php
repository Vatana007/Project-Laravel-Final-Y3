<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Customer::create($request->all());
        return back()->with('success', 'Customer added!');
    }

    public function create()
    {
        return view('customers.create');
    }
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate(['name' => 'required']);
        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', 'Member updated');
    }
}