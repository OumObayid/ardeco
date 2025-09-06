@extends('layouts.admin')

@section('content')
    <div class=" mt-4">
        <div class="row justify-content-center">
            <h6 style="font-size: 20px;padding-top:5px;" class="mb-2 mb-md-0 mx-0 pb-5">Modifier le Produit</h6>
            <div class=" mx-3">
                {{-- Affichage des erreurs globales --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Erreur :</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nom --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nom du produit</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $product->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Prix --}}
                    <div class="mb-3">
                        <label for="price" class="form-label fw-semibold">Prix (DH)</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                            id="price" name="price" value="{{ old('price', $product->price) }}" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Couleurs --}}
                    <div class="mb-3">
                        <label for="colors" class="form-label fw-semibold">Couleurs disponibles</label>
                        <input type="text" class="form-control @error('colors') is-invalid @enderror" id="colors"
                            name="colors"
                            value="{{ old('colors', $product->colors ? implode(', ', $product->colors) : '') }}"
                            placeholder="Ex : rouge, bleu, noir">
                        @error('colors') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Séparez les couleurs par une virgule (si plusieurs).</div>
                    </div>

                    {{-- Catégorie --}}
                    <div class="mb-3">
                        <label for="categorie_id" class="form-label fw-semibold">Catégorie</label>
                        <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id"
                            name="categorie_id" required>

                            <option value="" disabled {{ old('categorie_id', $product->categorie_id) ? '' : 'selected' }}>
                                Sélectionner une catégorie
                            </option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('categorie_id', $product->categorie_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('categorie_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Image principale --}}
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold">Image du produit</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        @if ($product->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Image actuelle" width="100"
                                    class="rounded shadow-sm">
                            </div>
                        @endif
                    </div>

                    {{-- Galerie --}}
                    <div class="mb-3">
                        <label for="gallery_images" class="form-label fw-semibold">Galerie d’images (ajout)</label>
                        <input type="file" class="form-control @error('gallery_images.*') is-invalid @enderror"
                            id="gallery_images" name="gallery_images[]" multiple accept="image/*">
                        @error('gallery_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Images existantes --}}
                    @if ($product->images && $product->images->count())
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Images existantes :</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($product->images as $image)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" width="50" height="50"
                                            class="rounded border" style="object-fit: cover;">
                                        <button type="button" class="btn btn-sm btn-danger btn-close"
                                            style="position: absolute; top: -8px; right: -8px; font-size: 0.6rem;"
                                            onclick="event.preventDefault(); document.getElementById('delete-image-{{ $image->id }}').submit();">
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Bouton envoyer --}}
                    <div class="text-start pt-3">
                        <x-mybutton type="submit" class="btn-plein">
                            <i class="bi bi-check-circle"></i> Mettre à jour
                        </x-mybutton>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </div>

    {{-- Formulaires de suppression des images --}}
    @if ($product->images && $product->images->count())
        @foreach ($product->images as $image)
            <form id="delete-image-{{ $image->id }}" action="{{ route('admin.products.deleteImage', $image->id) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif
@endsection