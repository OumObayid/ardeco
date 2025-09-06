@extends('layouts.app')

@section('content')
    {{-- 🔹 BANNIÈRE --}}
    <div class="banner">
        <div class="banner-overlay"></div>
        <div class="banner-content">
            <h1 class="display-4 fw-bold">Votre intérieur, votre style</h1>
            <p class="lead">Découvrez nos tables, tabourets et décorations élégantes</p>
            <x-mylink href="#produits" class="btn-plein mt-3">Voir les produits</x-mylink>
        </div>
    </div>

    {{-- 🔹 PRODUITS --}}
    <section id="produits" class="product-section">
        <div class="container">
            <h2 class="text-center mb-5">Nos Produits</h2>
            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card cardd h-100 mb-4 ">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="cardd-img-top"
                                    alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/No_image_available.png') }}" class="cardd-img-top"
                                    alt="Pas d'image">
                            @endif

                            <div class="cardd-body d-flex flex-column justify-content-between text-center">
                                <div>
                                    <h6 class="cardd-title text-truncate m-2" title="{{ $product->name }}">
                                        {{ $product->name }}</h6>
                                </div>
                                <div class="mt-auto">
                                    <p style="color:var(--color-accent)" class="fw-bold mb-2">{{ number_format($product->price, 2, ',', ' ') }} dh</p>
                                    {{-- Lien corrigé pour utiliser le slug --}}
                                   
                                        <x-mylink  href="{{ route('products.show', $product) }}" class="w-100 mt-3">Voir détails</x-mylink>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">Aucun produit disponible pour le moment.</p>
                @endforelse
            </div>

            {{-- Pagination --}}
         <div class="mt-4 d-flex justify-content-center">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
        </div>
    </section>
@endsection
