{{-- resources/views/categories/show.blade.php --}}
@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <div class="container py-5 ">
        {{-- Nom de la catégorie --}}
        <h1 class="text-center mb-3">{{ $category->name }}</h1>

        {{-- Description --}}
        @if($category->description)
            <div class="d-flex justify-content-center">
                <p class="text-center mb-5 fs-4 w-75" style="white-space: pre-line;">
                    {{ $category->description }}
                </p>
            </div>
        @endif
        {{-- Produits --}}
        @if ($category->products && $category->products->count())
            <div class="row g-4 justify-content-center">
                @foreach ($category->products as $product)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center my-4">
                        <div class="card cardd text-center" style="width: 100%; max-width: 300px;">
                            {{-- Image du produit --}}
                            @if ($product->image)
                                <!-- <img src="{{ asset('storage/' . $product->image) }}" class="cardd-img-top" alt="{{ $product->name }}">
                                            ou -->
                                <img src="{{ Storage::url($product->image) }}" class="cardd-img-top" alt="{{ $product->name }}">

                            @else
                                <img src="{{ asset('images/No_image_available.png') }}" class="cardd-img-top" alt="Pas d'image">
                            @endif

                            {{-- Contenu --}}
                            <div class="cardd-body d-flex flex-column justify-content-between">
                                <h6 class="cardd-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                                <p class="fw-bold mb-2">{{ number_format($product->price, 2, ',', ' ') }} DH</p>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-custom w-100">Voir détails</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">Aucun produit disponible pour cette catégorie.</p>
        @endif

 
    </div>
@endsection