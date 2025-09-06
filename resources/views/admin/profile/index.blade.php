@extends('layouts.admin') {{-- ton layout AdminLTE --}}

@section('title', 'Mon Profil')

@section('content')

    <div class="my-4">     
        <div class="mb-3">
            <h6 style="font-size: 20px;padding-top:5px;" class="mb-2 mb-md-0 mx-0 pb-2">Modifier mon profil</h6>
        </div>
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="form-group mb-4">
                    <label>Prénom</label>
                    <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}"
                        class="form-control">
                </div>

                <div class="form-group mb-4">
                    <label>Nom</label>
                    <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}" class="form-control">
                </div>

                <div class="form-group mb-4">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                </div>

                <div class="form-group mb-4">
                    <label>Mot de passe (laisser vide si inchangé)</label>
                    <input type="password" name="password" class="form-control">
                    <input type="password" name="password_confirmation" class="form-control mt-2"
                        placeholder="Confirmer mot de passe">
                </div>

                <div class="form-group mb-4">
                    <label>Photo de profil</label><br>
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" class="img-circle mb-2" width="80"
                            alt="Photo actuelle">
                    @endif
                    <input type="file" name="photo" class="form-control-file">
                </div>
            </div>

          
                <x-mybutton type="submit" class="btn-plein mt-3">Mettre à jour</x-mybutton>
         
        </form>

    </div>

@endsection