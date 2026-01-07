<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Products::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('products', 'public');
            $data['foto'] = 'storage/' . $imagePath;
        }

        Products::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Delete old image if exists
            if ($product->foto) {
                $oldPath = str_replace('storage/', '', $product->foto);
                Storage::disk('public')->delete($oldPath);
            }
            
            $imagePath = $request->file('foto')->store('products', 'public');
            $data['foto'] = 'storage/' . $imagePath;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        
        if ($product->foto) {
            $oldPath = str_replace('storage/', '', $product->foto);
            Storage::disk('public')->delete($oldPath);
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
