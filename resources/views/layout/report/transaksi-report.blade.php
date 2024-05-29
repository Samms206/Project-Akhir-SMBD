@extends('index')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Laporan Transaksi</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item">Laporan Transaksi</li>
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
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Earnings
                                    (Monthly)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{ $vearning_monthly->pendapatanBulanIni }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                                        3.48%</span>
                                    <span>Since last month</span>
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
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Sales</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $vtotal_transaction->sales }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>
                                        12%</span>
                                    <span>Since last years</span>
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
                                    <th>Customer</th>
                                    <th>Staff</th>
                                    <th>Total</th>
                                    <th>Discount</th>
                                    <th>Paid</th>
                                    <th>Changed</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vhistory_trans as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1}}</td>
                                        <td>{{ $item->customer }}</td>
                                        <td>{{ $item->staff }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>{{ $item->discount }}</td>
                                        <td>{{ $item->paid }}</td>
                                        <td>{{ $item->changed }}</td>
                                        <td>{{ $item->tanggal }}</td>
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
