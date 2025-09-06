<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Routes Admin
    |--------------------------------------------------------------------------
    */

    /**
     * Liste des catégories (Admin)
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Formulaire de création d'une catégorie (Admin)
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Ajout d'une nouvelle catégorie (Admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:555',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie ajoutée avec succès.');
    }

    /**
     * Formulaire d'édition d'une catégorie (Admin)
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Mise à jour d'une catégorie (Admin)
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:555',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Suppression d'une catégorie (Admin)
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('delete', $category); // à implémenter via Policy si nécessaire

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | Route publique
    |--------------------------------------------------------------------------
    */

    /**
     * Affichage d'une catégorie côté public (via slug)
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }
}
