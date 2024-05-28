@extends('index')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rollback Barang</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rollback Barang</li>
            </ol>
        </div>

        <!-- Row -->
        <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th>Harga Jual</th>
                                    <th>Harga Beli</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr>
                                        <td>{{ $barang->name }}</td>
                                        <td>{{ $barang->stock }}</td>
                                        <td>{{ $barang->hrg_jual }}</td>
                                        <td>{{ $barang->hrg_beli }}</td>
                                        <td>{{ $barang->created_at }}</td>
                                        <td>
                                            <div class="row" style="gap: 6px">
                                                <form action="{{ route('rollback-product-execute', $barang->id) }}" method="POST" >
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-warning edit-btn">
                                                        <i class="fas fa-recycle"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('delete-product', $barang->id) }}" method="POST" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger edit-btn">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--Row-->
    </div>
    <!---Container Fluid-->
@endsection
