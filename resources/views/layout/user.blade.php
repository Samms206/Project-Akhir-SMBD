@extends('index')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Customer</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Customer</li>
            </ol>
        </div>

        <!-- Row -->
        <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <!-- Modal Add-->
                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Customer</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('add-customer') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text"  required class="form-control" id="name" name="name"
                                                placeholder="Nama">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Telepon</label>
                                            <input type="text"  required class="form-control" id="phone" name="phone"
                                                placeholder="Telepon">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Alamat</label>
                                            <input type="text"  required class="form-control" id="address" name="address"
                                                placeholder="Alamat">
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
                    <!-- Modal Edit-->
                    <div class="modal fade" id="editModalUser" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text"  required class="form-control" id="editUserName" name="name"
                                                placeholder="Nama">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Telepon</label>
                                            <input type="text"  required class="form-control" id="editUserPhone" name="phone"
                                                placeholder="Telepon">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Alamat</label>
                                            <input type="text"  required class="form-control" id="editUserAddress" name="address"
                                                placeholder="Alamat">
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
                    {{-- end Edit --}}
                    <!-- Modal Delete-->
                    <div class="modal fade" id="deleteModalUser" tabindex="-1" role="dialog"
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
                                    <form id="deleteFormUser" method="POST"
                                        action="{{ route('delete-customer', ':user_id') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end Modal --}}
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Customer</h6>
                        <div>
                        <a class="btn btn-primary" href="" data-toggle="modal" data-target="#addModal"
                        id="#myBtn">
                            Add <i class="fas fa-plus-circle"></i>
                        </a>
                        <a class="btn btn-warning" href="{{ route('rollback-customer') }}">
                            Rollback <i class="fas fa-recycle"></i>
                        </a>
                    </div>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $cust)
                                    <tr>
                                        <td>{{ $cust->name }}</td>
                                        <td>{{ $cust->address }}</td>
                                        <td>{{ $cust->phone }}</td>
                                        <td>
                                            <a class="btn btn-primary edit-btn-user" href="#" data-toggle="modal"
                                                data-target="#editModalUser"
                                                data-user-id="{{ $cust->id }}"
                                                data-user-name="{{ $cust->name }}"
                                                data-user-phone="{{ $cust->phone }}"
                                                data-user-address="{{ $cust->address }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger delete-btn-user" href="#" data-toggle="modal"
                                                data-target="#deleteModalUser"
                                                data-user-id="{{ $cust->id }}"
                                                data-user-name="{{ $cust->name }}"
                                                >
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
