@extends('index')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Laporan Produk</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item">Laporan Produk</li>
            </ol>
        </div>
        <!--Row-->
        <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Product</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_stock->total_stock }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Product Sales</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $vsold_product_all->sold }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Invoice Example -->
            <div class="col mb-4">
                <div class="card">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1}}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->stock }}</td>
                                        <td>{{ $item->hrg_jual }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('detail-report-transaction', $item->id) }}" class="btn btn-sm btn-primary">Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <!---Container Fluid-->
        @endsection
