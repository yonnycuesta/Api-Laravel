<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Prophecy\Call\Call;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        try {
            if ($products->isEmpty()) {
                return response()->json([
                    'message' => 'No hay productos registrados',
                ], 404);
            } else {
                return response()->json([
                    'data' => $products,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los productos',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {

        $product = Product::create($request->validated());

        // Consultar la categoría del producto a crear existente en la base de datos
        $category = Category::find($request->category_id);

        // Agregar el producto a la categoría
        $category->products()->save($product);

        try {
            if ($category) {
                return response()->json([
                    'message' => 'Producto creado correctamente',
                    'data' => $product,
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Error al crear el producto',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el producto',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        try {
            if ($product) {
                return response()->json([
                    'data' => $product,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Producto no encontrado',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el producto',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->update($request->validated());

            return response()->json([
                'message' => 'Producto actualizado correctamente',
                'data' => $product,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Producto no encontrado',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        try {
            if ($product) {
                $product->delete();

                return response()->json([
                    'message' => 'Producto eliminado correctamente',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Producto no encontrado',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el producto',
            ], 500);
        }
    }
}
