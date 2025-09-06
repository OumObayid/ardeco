@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row g-4 align-items-start">

            {{-- 🔹 Image principale et galerie --}}
            <div class="col-md-6">
                <div class="p-3 rounded shadow" style="background-color: #1d1b19;">
                    {{-- Image principale zoomable --}}
                    <div class="border rounded overflow-hidden" style="cursor: zoom-in;" data-bs-toggle="modal"
                        data-bs-target="#zoomModal">
                        <img id="mainImage"
                            src="{{ $product->image ? Storage::url($product->image) : '/images/no_image_available.pnge' }}"
                            class="img-fluid w-100" style="transition: transform 0.3s ease;"
                            onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                    </div>

                    {{-- Galerie d'images --}}
                    @if ($product->images && $product->images->count())
                        <div class="mt-3 text-center">
                            @foreach ($product->images as $image)
                                <img src="{{ Storage::url($image->image_path) }}" onclick="changeImage(this.src)"
                                    style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                    class="image-gallery border rounded p-1 bg-white mb-3">
                            @endforeach
                        </div>
                    @endif

                    {{-- Modal pour zoom --}}
                    <div class="modal fade" id="zoomModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content bg-dark border-0">
                                <div class="modal-body text-center p-0">
                                    <img id="zoomedImage"
                                        src="{{ $product->image ? Storage::url($product->image) : '/images/no_image_available.pnge' }}"
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 🔹 Détails + Formulaire --}}
            <div class="col-md-6">
                <h2 class="h4 h-md2 fw-bold text-light mb-3 text-center">{{ $product->name }}</h2>
                <p class="text-secondary">{{ $product->category->name ?? 'Non classé' }}</p>
                {{-- Message de succès ou d’erreur --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <p class="mb-4 text-light">{{ $product->description }}</p>
                <h4 class="fw-bold text-warning mb-4">{{ number_format($product->price, 2, ',', ' ') }} DH</h4>

                {{-- Formulaire de commande --}}
                <div class="card border-0 shadow" style="background-color: #2a2622; color: #fff;">
                    <div class="card-body">
                        <h5 class="card-title mb-3 text-light">Commander ce produit</h5>

                        <form action="{{ route('order.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            {{-- Choix de la couleur si disponible --}}
                            @if ($product->colors)
                                <div class="mb-3">
                                    <label class="form-label text-light">Choisir une couleur</label>
                                    <select name="color" class="form-select bg-dark text-light border-secondary" required>
                                        <option value="" disabled selected>-- Sélectionner --</option>
                                        @foreach ($product->colors as $color)
                                            <option value="{{ trim($color) }}">{{ ucfirst(trim($color)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            {{-- Quantité --}}
                            <div class="mb-3">
                                <label class="form-label text-light">Quantité</label>
                                <div class="d-flex align-items-center bg-dark rounded px-2" style="width: fit-content;">
                                    <button type="button" class="btn btn-outline-light btn-sm px-3 fw-bold quantity-btn"
                                        aria-label="Moins">−</button>
                                    <input type="number" name="quantity" min="1" value="1"
                                        class="form-control bg-dark text-light text-center border-0 shadow-none quantity-input"
                                        style="width: 60px;" required>
                                    <button type="button" class="btn btn-outline-light btn-sm px-3 fw-bold quantity-btn"
                                        aria-label="Plus">+</button>
                                </div>
                            </div>

                            {{-- Informations client --}}
                            <div class="mb-3">
                                <label class="form-label text-light">Nom complet</label>
                                <input type="text" name="name" class="form-control bg-dark text-light border-secondary"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-light">Téléphone</label>
                                <input type="tel" name="phone" class="form-control bg-dark text-light border-secondary"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-light">Ville</label>
                                <input type="text" name="city" class="form-control bg-dark text-light border-secondary"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-light">Adresse complète</label>
                                <textarea name="address" rows="3" class="form-control bg-dark text-light border-secondary"
                                    required></textarea>
                            </div>


                            <div class="text-center">
                                <x-mybutton type="submit" class="w-100">
                                    Commander maintenant
                                </x-mybutton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        {{-- Produits similaires --}}
        <h3 class="text-light mt-5 mb-3">Vous aimerez également :</h3>
        <div class="related-products-container">
            <div class="related-products-track">
                @foreach($relatedProducts as $related)
                    <div class="related-product-card">
                        <a href="{{ route('products.show', $related) }}">
                            <img src="{{ $related->image ? Storage::url($related->image) : '/images/no_image_available.pnge' }}"
                                alt="{{ $related->name }}">
                            <p class="text-light text-center mt-2">{{ $related->name }}</p>
                            <p class="text-warning text-center">{{ number_format($related->price, 2, ',', ' ') }} DH</p>
                        </a>
                    </div>
                @endforeach

                {{-- Dupliquer la série pour scroll continu --}}
                @foreach($relatedProducts as $related)
                    <div class="related-product-card">
                        <a href="{{ route('products.show', $related) }}">
                            <img src="{{ $related->image ? Storage::url($related->image) : '/images/no_image_available.pnge' }}"
                                alt="{{ $related->name }}">
                            <p class="text-light text-center mt-2">{{ $related->name }}</p>
                            <p class="text-warning text-center">{{ number_format($related->price, 2, ',', ' ') }} DH</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>





    </div>

    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.quantity-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const input = this.closest('.d-flex').querySelector('.quantity-input');
                    let value = parseInt(input.value) || 1;
                    if (this.textContent.trim() === '+') input.value = value + 1;
                    else if (this.textContent.trim() === '−' && value > 1) input.value = value - 1;
                });
            });
        });

        function changeImage(src) {
            document.getElementById('mainImage').src = src;
            document.getElementById('zoomedImage').src = src;
        }
    </script>
@endsection

@push('styles')
    <style>
        /* Supprimer les flèches sur input type=number */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

/* related products */
.related-products-container {
    overflow: hidden;
    width: 100%;
    margin-bottom: 40px;
    background-color: #1d1b19;
}

.related-products-track {
    display: flex;
    gap: 20px;
    width: max-content; /* nécessaire pour que flex ne limite pas la largeur */
    animation: scroll-left 40s linear infinite;
}

.related-products-container:hover .related-products-track {
    animation-play-state: paused;
}

.related-product-card {
    flex: 0 0 auto;
    width: 300px;
    background-color: #2a2622;
    border-radius: 10px;
    padding: 10px;
    display: flex;
    flex-direction: column; /* empile img, nom et price */
}

.related-product-card a {
    display: flex;
    flex-direction: column;
    flex: 1; /* permet de remplir la card verticalement */
    text-decoration: none; /* supprime le souligné */
}

.related-product-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 6px;
}

.related-product-card p {
    margin: 5px 0 0 0;
    text-align: center;
}

/* Prix toujours en bas */
.related-product-card p.text-warning {
    margin-top: auto; /* pousse le prix vers le bas */
}

@keyframes scroll-left {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%); /* comme on a dupliqué, -50% correspond à la moitié totale */
    }
}

/* Galerie d'images */
.image-gallery {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.image-gallery:hover {
    transform: scale(1.2); /* zoom léger */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* ombre */
    z-index: 2; /* pour que l'image zoomée passe au-dessus des autres */
}
    </style>
@endpush