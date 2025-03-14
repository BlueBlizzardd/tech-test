<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
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
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        if (!is_numeric($request->price) || $request->price < 0) {
            return response()->json(["message" => "El precio debe ser un numero valido y positivo."], 500);
        }

        if (!is_numeric($request->stock) || $request->stock < 0) {
            return response()->json(["message" => "El stock debe ser un numero entero positivo."], 500);
        }

        Product::create([
            'sku' => $request->sku,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        return response()->json(["message" => "El stock debe ser un numero entero positivo."], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Product::find($product->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::transaction(function () use ($request, $product) {
                if (!$product) {
                    throw new \Exception("Producto no encontrado.");
                }

                if (!is_numeric($request->price) || $request->price < 0) {
                    throw new \Exception("El precio debe ser un numero valido y positivo.");
                }

                if (!is_numeric($request->stock) || $request->stock < 0) {
                    throw new \Exception("El stock debe ser un numero entero positivo.");
                }

                $product->sku = $request->sku;
                $product->name = $request->name;
                $product->description = $request->description;
                $product->price = $request->price;
                $product->stock = $request->stock;

                $product->save();
            });
        } catch (\Exception $e) {
            Log::error("Error al actualizar producto: " . $e->getMessage());
            return response()->json(["message" => "error: " . $e->getMessage()], 500);
        }

        return response()->json(["message" => "El producto ha sido actualizado exitosamente."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {
                if (!$product) {
                    throw new \Exception("Producto no encontrado.");
                }

                $product->delete();
            });
        } catch (\Exception $e) {
            Log::error("Error al eliminar producto: " . $e->getMessage());
            return response()->json(["error" => $e->getMessage()], 500);
        }

        return response()->json(["message" => "Producto eliminado"]);
    }
}
