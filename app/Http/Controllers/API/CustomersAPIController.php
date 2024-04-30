<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customers;
use Validator;

class CustomersAPIController extends Controller
{
    public function index()
    {
        $customers = Customers::paginate(10);
        return response()->json(['success' => true, 'data' => $customers]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelanggan' => 'required',
            'id_pelanggan' => 'required'
            // tambahkan validasi lainnya sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        Customers::create($request->all());

        return response()->json(['success' => true, 'message' => 'Customer created successfully.'], 201);
    }

    public function show($id)
    {
        $customer = Customers::find($id);
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $customer]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customers::find($id);
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $customer->update($request->all());

        return response()->json(['success' => true, 'message' => 'Customer updated successfully.']);
    }

    public function destroy($id)
    {
        $customer = Customers::find($id);
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
        }

        $customer->delete();
        return response()->json(['success' => true, 'message' => 'Customer deleted successfully.']);
    }
}


