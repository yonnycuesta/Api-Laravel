<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'No hay categorías registradas',
            ], 404);
        } else {
            return response()->json([
                'data' => $categories,
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());

        if ($category) {
            return response()->json([
                'message' => 'Categoría creada correctamente',
                'data' => $category,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Error al crear la categoría',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if ($category) {
            return response()->json([
                'data' => $category,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Categoría no encontrada',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->update($request->validated());

            return response()->json([
                'message' => 'Categoría actualizada correctamente',
                'data' => $category,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Categoría no encontrada',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return response()->json([
                'message' => 'Categoría eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Categoría no encontrada',
            ], 404);
        }
    }
}
