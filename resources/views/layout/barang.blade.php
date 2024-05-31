@extends('index')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Barang</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Barang</li>
            </ol>
        </div>

        <!-- Row -->
        <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <!-- Modal Add-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('add-product') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="namaProduk">Nama Produk</label>
                                            <input type="text" required class="form-control" id="namaProduk" name="name"
                                                placeholder="Nama Produk">
                                        </div>
                                        <div class="form-group">
                                            <label for="touchSpin3">Stok</label>
                                            <div class="input-group touch-spin">
                                                <span class="input-group-btn input-group-prepend">
                                                </span>
                                                <input style="text-align: center" id="touchSpin3" type="text" required
                                                    value="0" name="stock" class="form-control">
                                                <span class="input-group-btn input-group-append">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="hrgjual">Harga Jual</label>
                                            <input type="text" required class="form-control" id="hrgjual" placeholder="Rp.-"
                                                name="hrg_jual">
                                        </div>
                                        <div class="form-group">
                                            <label for="hrgeli">Harga Beli</label>
                                            <input type="text" required class="form-control" id="hrgeli" placeholder="Rp.-"
                                                name="hrg_beli">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-primary"
                                        data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end Modal --}}
                    <!-- Modal Delete-->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin menghapus data ini?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <!-- Tombol Konfirmasi Hapus -->
                                    <form id="deleteForm" method="POST"
                                        action="{{ route('delete-product', ':barang_id') }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end Modal --}}
                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="editNamaProduk">Nama Produk</label>
                                            <input type="text" required class="form-control" id="editNamaProduk"
                                                name="edit_name" placeholder="Nama Produk">
                                        </div>
                                        <div class="form-group">
                                            <label for="editStok">Stok</label>
                                            <input type="text" required class="form-control" id="editStok" name="edit_stock"
                                                placeholder="Stok">
                                        </div>
                                        <div class="form-group">
                                            <label for="editHargaJual">Harga Jual</label>
                                            <input type="text" required class="form-control" id="editHargaJual"
                                                name="edit_hrg_jual" placeholder="Harga Jual">
                                        </div>
                                        <div class="form-group">
                                            <label for="editHargaBeli">Harga Beli</label>
                                            <input type="text" required class="form-control" id="editHargaBeli"
                                                name="edit_hrg_beli" placeholder="Harga Beli">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end modal edit --}}
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
                        <div>
                        <button class="btn btn-primary" href="" data-toggle="modal" data-target="#exampleModal"
                            id="#myBtn">
                            Add <i class="fas fa-plus-circle"></i>
                        </button>
                        <a class="btn btn-warning" href="{{ route('rollback-product') }}">
                            Rollback <i class="fas fa-recycle"></i>
                        </a>
                        </div>
                    </div>
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
                                            <a class="btn btn-primary edit-btn" href="#" data-toggle="modal"
                                                data-target="#editModal" data-barang-id="{{ $barang->id }}"
                                                data-barang-nama="{{ $barang->name }}"
                                                data-barang-stok="{{ $barang->stock }}"
                                                data-barang-harga-jual="{{ $barang->hrg_jual }}"
                                                data-barang-harga-beli="{{ $barang->hrg_beli }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger delete-btn" href="#" data-toggle="modal"
                                                data-target="#deleteModal" data-barang-id="{{ $barang->id }}"
                                                data-barang-nama="{{ $barang->name }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
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
