<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Page d'accueil : afficher les produits paginés (accessible à tous)
     */
    public function home()
    {
        $products = Product::with('category')->latest()->paginate(12);
        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }

    /**
     * Afficher un produit via slug (accessible à tous)
     */
    public function show(Product $product)
    {
        $product->load('category', 'images');

        // 🔹 Produits similaires (même catégorie, exclure le produit courant)
        $relatedProducts = Product::where('categorie_id', $product->categorie_id)
            ->where('id', '!=', $product->id)
            ->take(10)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }


    /**
     * Liste des produits pour l'admin
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Formulaire de création d'un produit (Admin)
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Enregistrement d'un nouveau produit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'categorie_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048',
            'colors' => 'nullable|string',
        ]);

        // Gestion de l'image principale
        $imagePath = null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            if ($file->isValid()) {

                // Créer le dossier si inexistant
                $storagePath = storage_path('app/public/products');
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0777, true);
                }

                // Stocker le fichier
                $imagePath = $file->store('products', 'public');

                // Vérification
                if (!file_exists(storage_path('app/public/' . $imagePath))) {
                    dd("Erreur : le fichier n'a pas été stocké.", $imagePath, $storagePath);
                }
            } else {
                dd("Erreur : fichier invalide", $file);
            }
        }

        // Création du produit
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'categorie_id' => $validated['categorie_id'] ?? null,
            'image' => $imagePath,
            'colors' => isset($validated['colors']) ? array_map('trim', explode(',', $validated['colors'])) : null,
        ]);

        // Galerie d'images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file->isValid()) {
                    $galleryPath = $file->store('products/gallery', 'public');
                    $product->images()->create([
                        'image_path' => $galleryPath,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit ajouté avec succès.');
    }

    /**
     * Formulaire d'édition d'un produit
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Mise à jour d'un produit
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'categorie_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'colors' => 'nullable|string',
        ]);

        // Gestion de l'image principale
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                // Supprimer l'ancienne image
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->image = $file->store('products', 'public');
            }
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'categorie_id' => $validated['categorie_id'] ?? null,
            'colors' => isset($validated['colors']) ? array_map('trim', explode(',', $validated['colors'])) : null,
            'image' => $product->image,
        ]);

        // Ajout nouvelles images de galerie
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file->isValid()) {
                    $galleryPath = $file->store('products/gallery', 'public');
                    $product->images()->create([
                        'image_path' => $galleryPath,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Supprimer une image de galerie
     */
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image supprimée avec succès.');
    }

    /**
     * Supprimer un produit
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé avec succès.');
    }


}
