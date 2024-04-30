<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Produk;
use Validator;

class ProductAPIController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        // Filter by service ID
        if ($request->has('service_id')) {
            $query->where('id_service', $request->service_id);
        }

        // Search by product name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('produk', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%")
                  ->orWhere('created_by', 'like', "%$search%")
                  ->orWhere('id_service', 'like', "%$search%")
                  ->orWhere('id', 'like', "%$search%");
            });
        }

        $products = $query->orderBy('id_service')->paginate(10);

        return response()->json(['success' => true, 'data' => $products]);
    }

    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'id_service' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        // Store the product
        $productData = $request->all();
        $productData['date_added'] = Carbon::now();
        Produk::create($productData);

        return response()->json(['success' => true, 'message' => 'Product created successfully.'], 201);
    }

    public function show($id)
    {
        $product = Produk::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $product]);
    }

    public function update(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        // Update the product
        $product = Produk::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        $product->update($request->all());

        return response()->json(['success' => true, 'message' => 'Product updated successfully.']);
    }

    public function destroy($id)
    {
        $product = Produk::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }
}
