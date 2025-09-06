@extends('layouts.admin')

@section('content')

    <div class=" mt-4">
        {{-- Bouton Ajouter --}}
        <div class="d-flex justify-content-between gap-2 align-items-center mb-3">
            <h6 style="font-size: 20px" class="mb-2 mb-md-0 mx-0">Liste des Catégories</h6>
            <x-mylink class="btn-plein" href="{{ route('admin.categories.create') }}">
                + catégorie
            </x-mylink>

        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="animation: fadeIn 0.5s;">
                {{ session('success') }}
                <button type="button" style="font-size:12px" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Vue Desktop (tableau) --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                @if(!empty($category->description) && strlen($category->description) > 50)
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $category->description }}">
                                        {{ Str::limit($category->description, 50) }}
                                    </span>
                                @else
                                    {{ $category->description ?? '-' }}
                                @endif
                            </td>
                            <td class="text-end">
                                <a style="font-size:12px" href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="btn btn-sm btn-warning " title="Modifier">
                                    Modifier
                                </a>
                                <form id="delete-form-{{ $category->id }}"
                                action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="flex-fill"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button style="font-size:12px" type="button" class="btn btn-danger btn-sm "
                                onclick="confirmDelete({{ $category->id }})">
                                Supprimer
                            </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Aucune catégorie trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Vue Mobile (cartes) --}}
        <div class="d-block d-md-none">
            @forelse ($categories as $category)
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $category->name }}</h6>
                        <p class="text-muted small mb-2">
                            {{ Str::limit($category->description, 100) ?? '-' }}
                        </p>
                        <div class="d-flex gap-2">
                            <a style="font-size:12px" href="{{ route('admin.categories.edit', $category->id) }}"
                                class="btn btn-warning btn-sm w-50">
                                Modifier
                            </a>
                            <form id="delete-form-{{ $category->id }}"
                                action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="flex-fill"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button style="font-size:12px" type="button" class="btn btn-danger btn-sm w-50"
                                onclick="confirmDelete({{ $category->id }})">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Aucune catégorie trouvée.</p>
            @endforelse
        </div>

    </div>


    {{-- Activation tooltips Bootstrap --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endsection