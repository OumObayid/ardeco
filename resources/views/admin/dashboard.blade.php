@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mt-5">
    {{-- Statistiques --}}
    <div class="row">
        {{-- Produits --}}
        <div class="col-md-3 col-sm-6 col-12 mb-3">
            <div class="info-box bg-info p-3 d-flex align-items-center rounded">
                <span class="info-box-icon fs-2"><i class="fas fa-box"></i></span>
                <div class="info-box-content ms-3">
                    <span class="info-box-text">Produits</span>
                    <span class="info-box-number">{{$productCount}}</span>
                    <a href="{{route('admin.products.index')}}" class="small-box-footer text-white d-block mt-1">Gérer <i class="gestIcon fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Catégories --}}
        <div class="col-md-3 col-sm-6 col-12 mb-3">
            <div class="info-box bg-success p-3 d-flex align-items-center rounded">
                <span class="info-box-icon fs-2"><i class="fas fa-tags"></i></span>
                <div class="info-box-content ms-3">
                    <span class="info-box-text">Catégories</span>
                    <span class="info-box-number">{{$categoryCount}}</span>
                    <a href="{{route('admin.categories.index')}}" class="small-box-footer text-white d-block mt-1">Gérer <i class="gestIcon fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Commandes --}}
        <div class="col-md-3 col-sm-6 col-12 mb-3">
            <div class="info-box bg-warning p-3 d-flex align-items-center rounded">
                <span class="info-box-icon fs-2"><i class="fas fa-receipt"></i></span>
                <div class="info-box-content ms-3">
                    <span class="info-box-text text-white">Commandes</span>
                    <span class="info-box-number text-white">{{$orderCount}}</span>
                    <a href="{{route('admin.orders.index')}}" class="small-box-footer text-white d-block mt-1">Voir <i class="gestIcon fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Utilisateurs --}}
        <div class="col-md-3 col-sm-6 col-12 mb-3">
            <div class="info-box bg-danger p-3 d-flex align-items-center rounded">
                <span class="info-box-icon fs-2"><i class="fas fa-user-shield"></i></span>
                <div class="info-box-content ms-3">
                    <span class="info-box-text">Utilisateurs</span>
                    <span class="info-box-number">{{$userCount}}</span>
                    <a href="{{route('admin.users.index')}}" class="small-box-footer text-white d-block mt-1">Gérer <i class="gestIcon fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    {{-- Dernières commandes --}}
    <div class="mt-3">
        <h5 class="mb-3">Dernières commandes</h5>

        {{-- Desktop/Table --}}
        <div class="d-none d-md-block">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Client</th>
                                <th>Téléphone</th>
                                <th>Produit</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestOrders as $order)
                                <tr>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ $order->product->name ?? '-' }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucune commande récente</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Mobile/Card View --}}
        <div class="d-md-none">
            @forelse ($latestOrders as $order)
                <div class="card mb-2 shadow-sm">
                    <div class="card-body">
                        <p><strong>Client :</strong> {{ $order->name }}</p>
                        <p><strong>Téléphone :</strong> {{ $order->phone }}</p>
                        <p><strong>Produit :</strong> {{ $order->product->name ?? '-' }}</p>
                        <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center">Aucune commande récente</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
