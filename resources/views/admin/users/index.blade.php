@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')
    <div class="mt-4">
        {{-- Desktop --}}
        <div class="table-responsive d-none d-md-block">
            <div class="d-flex justify-content-between gap-2 align-items-center mb-3">
                <h6 style="font-size: 20px;padding-top:5px;" class="mb-2 mb-md-0 mx-0 pb-2">Liste des utilisateurs</h6>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button style="font-size:12px" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-end">
                                @if($user->role !== 'admin')
                                      <form id="delete-form-{{ $user->id }}"
                                action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="flex-fill"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button style="font-size:12px" type="button" class="btn btn-danger btn-sm "
                                onclick="confirmDelete({{ $user->id }})">
                                Supprimer
                            </button>
                                @else
                                    <span class="text-muted">Action non autorisée</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucun utilisateur trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile --}}
        <div class="d-md-none">
            <div class="mb-3">
                <h2 class="mb-3 text-center">Liste des Utilisateurs</h2>
            </div>

            @forelse($users as $user)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-1">{{ $user->firstname }} {{ $user->lastname }}</h6>
                        <p class="card-text mb-1"><small>Email: {{ $user->email }}</small></p>
                        <p class="card-text mb-2">
                            <small>Rôle: </small>
                        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                        </p>
                        <div class="d-flex justify-content-end gap-2">
                            @if($user->role !== 'admin')
                                <form id="delete-form-{{ $user->id }}"
                                action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="flex-fill"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button style="font-size:12px" type="button" class="btn btn-danger btn-sm w-50"
                                onclick="confirmDelete({{ $user->id }})">
                                Supprimer
                            </button>
                            @else
                                <span class="text-muted">Action non autorisée</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted">Aucun utilisateur trouvé.</div>
            @endforelse
        </div>
    </div>
@endsection