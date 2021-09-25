<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // El método index debería devolver todo el listado de categorias

        $categories = Category::included()
                                ->filter()
                                ->sort()
                                ->getOrPaginate();

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // El método guarda en la base y devuelve el nuevo registro de categoria

        // Validar datos de la categoría
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories'
        ]);

        $category = Category::create($request->all());

        return CategoryResource::make($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        // El método mostrará la información de una sola categoría que se
        // pase como un parámetro en la url

        $category = Category::included()->findOrFail($id);

        return CategoryResource::make($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // El método actualizará la información de la categoría

        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,'.$category->id
        ]);

        $category->update($request->all());

        return CategoryResource::make($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // El método elimina el registro de la base de datos
        $category->delete();
        
        return CategoryResource::make($category);
    }
}
