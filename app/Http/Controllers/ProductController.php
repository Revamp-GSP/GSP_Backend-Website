<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Produk;

class ProductController extends Controller
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
                  ;
            });
        }

        $products = $query->orderBy('id_service')->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'id_service' => 'required',
        ]);
        // Store the product
        $productData = $request->all();
        $productData['date_added'] = Carbon::now();
        Produk::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Produk::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'id_service' => 'required',
        ]);

        // Update the product
        $product = Produk::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        // Delete the product
        Produk::findOrFail($id)->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
