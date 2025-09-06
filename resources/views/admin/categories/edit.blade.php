@extends('layouts.admin')

@section('content')
    <div class=" mt-4">
        <div class="row justify-content-center">
            <h6 style="font-size: 20px;padding-top:5px;" class="mb-2 mb-md-0 mx-0 pb-5">Modifier la Catégorie</h6>
            <div class=" mx-3">
                    {{-- Affichage des erreurs --}}
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

                    {{-- Formulaire de modification --}}
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de la catégorie</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                         <div class="text-start">
                        <x-mybutton type="submit" class="btn-plein">
                            <i class="bi bi-check-circle"></i> Mettre à jour
                        </x-mybutton>
                    </div>
                    </form>

                </div>
            </div>

        </div>

@endsection
