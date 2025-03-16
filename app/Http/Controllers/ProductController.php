<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('dashboard', [
            'products' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('products/create-products');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Product::create($request->validate([
            'sku' => ['required', 'numeric'],
            'name' => ['required'],
            'description' => ['nullable'],
            'price' => ['required', 'numeric', 'decimal:2', 'min:1'],
            'stock' => ['required', 'numeric', 'integer', 'min:1']
        ]));

        return to_route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return Product::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $product = Product::findOrFail($id);

        return Inertia::render('products/update-products', [
            "product" => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        // Si esto falla se redirige a un 404, por lo que no hace falta
        // colocarlo en la transaccion
        $product = Product::findOrFail($id);

        // Esto redirige al usuario a la pagina normal si falla, por lo que no hay
        // que validar como parte de la transaccion
        $request->validate([
            'sku' => ['required', 'numeric'],
            'name' => ['required'],
            'description' => ['nullable'],
            'price' => ['required', 'numeric', 'decimal:2', 'min:1'],
            'stock' => ['required', 'numeric', 'integer', 'min:0']
        ]);

        try {
            DB::transaction(function () use ($request, $product) {
                $product->update([
                    'sku' => $request->sku,
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'stock' => $request->stock,
                ]);

                $product->save();
            });
        } catch (\Exception $e) {
            Log::error("Error al actualizar producto: " . $e->getMessage());
            return to_route('edit', ['id' => $id]);
        }

        return to_route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        // Si esto falla se redirige a un 404, por lo que no hace falta
        // colocarlo en la transaccion
        $product = Product::findOrFail($id);

        try {
            DB::transaction(function () use ($product) {
                $product->delete();
            });
        } catch (\Exception $e) {
            Log::error("Error al eliminar producto: " . $e->getMessage());
            return to_route('dashboard');
        }

        return to_route('dashboard');
    }
}
