@extends('layouts.admin')

@section('content')
    <style>
        .text-muted {
            display: none;
        }
    </style>

    <div class="mt-4">
        {{-- Bouton Ajouter --}}
        <div class="d-flex justify-content-between gap-2 align-items-center mb-3">
            <h6 style="font-size: 20px" class="mb-2 mb-md-0 mx-0">Liste des Produits</h6>
            <x-mylink class="btn-plein" href="{{ route('admin.products.create') }}">
                + produit
            </x-mylink>
        </div>
        {{-- Message de succès --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button style="font-size:12px" type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Version Desktop --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 8%;">Image</th>
                        <th style="width: 20%;">Nom</th>
                        <th style="width: 32%;">Description</th>
                        <th style="width: 10%;">Prix (DH)</th>
                        <th style="width: 15%;">Catégorie</th>
                        <th style="width: 15%;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" width="50" class="rounded shadow-sm"
                                        alt="{{ $product->name }}">
                                @else
                                    <span class="text-muted">Aucune image</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if(strlen($product->description) > 60)
                                    <span data-bs-toggle="tooltip" title="{{ $product->description }}">
                                        {{ Str::limit($product->description, 60) }}
                                    </span>
                                @else
                                    {{ $product->description }}
                                @endif
                            </td>
                            <td>{{ number_format($product->price, 2, ',', ' ') }} DH</td>
                            <td>{{ $product->category->name ?? 'Non classé' }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" style="font-size:12px" class="btn btn-sm btn-warning w-50"
                                        title="Modifier">
                                        Modifier
                                    </a>                                   
                                    <form id="delete-form-{{ $product->id }}"
                                action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="flex-fill"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button style="font-size:12px" type="button" class="btn btn-danger btn-sm w-50"
                                onclick="confirmDelete({{ $product->id }})">
                                Supprimer
                            </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucun produit disponible.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination Desktop --}}
            <div class="d-flex justify-content-end">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>

        {{-- Version Mobile --}}
        <div class="d-md-none">
            @forelse($products as $product)
                <div class="card mb-3 shadow-sm">
                    <div class="row g-0 align-items-center">
                        <div class="col-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start"
                                    alt="{{ $product->name }}">
                            @else
                                <div class="text-muted text-center py-3">Aucune image</div>
                            @endif
                        </div>
                        <div class="col-8">
                            <div class="card-body p-2 d-flex flex-column justify-content-between" style="height:100%;">
                                <div>
                                    <h6 class="card-title mb-1">{{ $product->name }}</h6>
                                    <p class="card-text text-truncate mb-1" style="max-height: 3rem;"
                                        title="{{ $product->description }}">
                                        {{ $product->description }}
                                    </p>
                                    <p class="card-text mb-2"><small
                                            class="text-muted">{{ number_format($product->price, 2, ',', ' ') }} DH -
                                            {{ $product->category->name ?? 'Non classé' }}</small></p>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" style="font-size:12px" class="btn btn-sm btn-warning w-50"
                                        title="Modifier">
                                        Modifier
                                    </a>                                   
                                    <form id="delete-form-{{ $product->id }}"
                                action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="flex-fill"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button style="font-size:12px" type="button" class="btn btn-danger btn-sm w-50"
                                onclick="confirmDelete({{ $product->id }})">
                                Supprimer
                            </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted">Aucun produit disponible.</div>
            @endforelse

            {{-- Pagination Mobile --}}
            <div class="d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>


    {{-- Tooltips Bootstrap --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection