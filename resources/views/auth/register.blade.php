@extends('layouts.auth')

@section('auth-content')
    <h3 class="text-center mb-4">Créer un compte</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3 position-relative">
            <label for="name" class="form-label">Nom</label>
            <i class="bi bi-person-fill form-icon"></i>
            <input type="text" id="name" name="name" class="input-with-icon form-control"
                   value="{{ old('name') }}" required autofocus>
        </div>

        <div class="mb-3 position-relative">
            <label for="email" class="form-label">Email</label>
            <i class="bi bi-envelope-fill form-icon"></i>
            <input type="email" id="email" name="email" class="input-with-icon form-control"
                   value="{{ old('email') }}" required>
        </div>

        <div class="mb-3 position-relative">
            <label for="password" class="form-label">Mot de passe</label>
            <i class="bi bi-lock-fill form-icon"></i>
            <input type="password" id="password" name="password" class="input-with-icon form-control" required>
        </div>

        <div class="mb-3 position-relative">
            <label for="password_confirmation" class="form-label">Confirmer mot de passe</label>
            <i class="bi bi-lock-fill form-icon"></i>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="input-with-icon form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">S’inscrire</button>
    </form>

    <p class="text-center mt-3">
        Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
    </p>
@endsection
