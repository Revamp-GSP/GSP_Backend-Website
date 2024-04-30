<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Customers;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        $query = Customers::query();

        // Filter by customer ID
        if ($request->has('id_pelanggan')) {
            $query->where('id_pelanggan', $request->id_pelanggan);
        }

        // Search by customer name or designation
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%$search%")
                ->orWhere('sebutan', 'like', "%$search%")
                ->orWhere('created_by', 'like', "%$search%")
                ->orWhere('id_pelanggan', 'like', "%$search%");
            });
        }

        $customers = $query->orderBy('id_pelanggan')->paginate(10);

        return view('customers.indexcustomers', compact('customers'));
    }

    public function create()
    {
        return view('customers.createcustomers');
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'nama_pelanggan' => 'required',
            'id_pelanggan' => 'required',
        ]);

        // Store the customer
        $customerData = $request->all();
        $customerData['date_added'] = Carbon::now();
        Customers::create($customerData);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function edit($id)
    {
        $customer = Customers::findOrFail($id);
        return view('customers.editcustomers', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'nama_pelanggan' => 'required',
            'id_pelanggan' => 'required',
        ]);

        // Update the customer
        $customer = Customers::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        // Delete the customer
        Customers::findOrFail($id)->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

}
