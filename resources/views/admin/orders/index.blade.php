@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
    <div class="mt-4">

        {{-- Desktop --}}
        <div class="table-responsive d-none d-md-block">
            <div class="card shadow-sm border-0 mb-3">
                <div class="d-flex justify-content-between gap-2 align-items-center mb-3">
                    <h6 style="font-size: 20px;padding-top:5px;" class="mb-2 mb-md-0 mx-0 pb-2">Liste des commande</h6>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button style="font-size:12px" type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Fermer"></button>
                    </div>
                @endif
                <table style="font-size: 13px" class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Client</th>
                            <th>Téléphone</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix total</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ $order->product->name ?? '-' }}</td>
                                <td>{{ $order->quantity ?? 1 }}</td>
                                <td>{{ number_format(($order->product->price ?? 0) * ($order->quantity ?? 1), 2, ',', ' ') }} DH
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            @foreach(['pending', 'processing', 'completed', 'canceled'] as $status)
                                                <option value="{{ $status }}" @if($order->status === $status) selected @endif>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <form id="delete-form-{{ $order->id }}"
                                        action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="flex-fill"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <button style="font-size:12px" type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $order->id }})">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center fst-italic text-muted">Aucune commande trouvée</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile --}}
        <div class="d-md-none">
            <div class="mb-3">
                <h2 class="mb-3 text-center">Liste des Commandes</h2>
            </div>

            @forelse($orders as $order)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="mb-1"><strong>Client :</strong> {{ $order->name }}</p>
                        <p class="mb-1"><strong>Téléphone :</strong> {{ $order->phone }}</p>
                        <p class="mb-1"><strong>Produit :</strong> {{ $order->product->name ?? '-' }}</p>
                        <p class="mb-1"><strong>Quantité :</strong> {{ $order->quantity ?? 1 }}</p>
                        <p class="mb-1"><strong>Prix total :</strong>
                            {{ number_format(($order->product->price ?? 0) * ($order->quantity ?? 1), 2, ',', ' ') }} DH</p>
                        <p class="mb-1"><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p class="mb-2"><strong>Status :</strong></p>
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select form-select-sm mb-2" onchange="this.form.submit()">
                                @foreach(['pending', 'processing', 'completed', 'canceled'] as $status)
                                    <option value="{{ $status }}" @if($order->status === $status) selected @endif>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <div class=" mt-2">
                            <form id="delete-form-{{ $order->id }}" action="{{ route('admin.orders.destroy', $order->id) }}"
                                method="POST" class="flex-fill" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button style="font-size:12px" type="button" class="btn btn-danger btn-sm"
                                onclick="confirmDelete({{ $order->id }})">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center fst-italic text-muted">Aucune commande trouvée</div>
            @endforelse
        </div>

    </div>
@endsection