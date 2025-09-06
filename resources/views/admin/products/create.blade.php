@extends('layouts.admin')

@section('content')
    <div class=" mt-4">
        <div class="row justify-content-center">
            <h6 style="font-size: 20px;padding-top:5px;" class="mb-2 mb-md-0 mx-0 pb-5">Ajouter un Produit</h6>
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

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nom --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nom du produit</label>
                    <input type="text" class="form-control border-2 @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name') }}" required
                           placeholder="Entrez le nom du produit" />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control border-2 @error('description') is-invalid @enderror"
                              id="description" name="description" rows="4" placeholder="Description détaillée du produit">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Prix --}}
                <div class="mb-3">
                    <label for="price" class="form-label fw-semibold">Prix (DH)</label>
                    <input type="number" step="0.01" class="form-control border-2 @error('price') is-invalid @enderror"
                           id="price" name="price" value="{{ old('price') }}" required placeholder="Exemple: 19.99" />
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catégorie --}}
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-semibold">Catégorie</label>
                    <select class="form-select border-2 @error('categorie_id') is-invalid @enderror"
        id="categorie_id" name="categorie_id" required>
    <option value="" disabled {{ old('categorie_id') ? '' : 'selected' }}>Sélectionner une catégorie</option>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ old('categorie_id') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
    @endforeach
</select>

                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Couleurs --}}
                <div class="mb-3">
                    <label for="colors" class="form-label fw-semibold">Couleurs disponibles</label>
                    <input type="text" class="form-control border-2 @error('colors') is-invalid @enderror"
                           id="colors" name="colors" value="{{ old('colors') }}"
                           placeholder="Ex : rouge, bleu, noir" />
                    <div class="form-text">Séparez les couleurs par une virgule (si plusieurs).</div>
                    @error('colors')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Image principale --}}
                <div class="mb-4">
                    <label for="image" class="form-label fw-semibold">Image du produit</label>
                    <input type="file" class="form-control border-2 @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/*" />
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Galerie --}}
                <div class="mb-4">
                    <label for="gallery_images" class="form-label fw-semibold">Galerie (images supplémentaires)</label>
                    <input type="file" class="form-control border-2 @error('gallery_images.*') is-invalid @enderror"
                           id="gallery_images" name="gallery_images[]" accept="image/*" multiple />
                    <div class="form-text">Vous pouvez sélectionner plusieurs images pour la galerie.</div>
                    @error('gallery_images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-start">
                        <x-mybutton type="submit" class="btn-plein">
                            <i class="bi bi-check-circle"></i> Ajouter
                        </x-mybutton>
                    </div>
            </form>
      
    </div>
</div>
@endsection
