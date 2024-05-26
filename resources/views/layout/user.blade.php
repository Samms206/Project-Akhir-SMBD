@extends('index')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">User</li>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('add-user') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text"  required class="form-control" id="name" name="name"
                                                placeholder="Nama">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" required required class="form-control" id="email" name="email"
                                                placeholder="Example@gmail.com">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Alamat</label>
                                            <input type="text"  required class="form-control" id="address" name="address"
                                                placeholder="Alamat">
                                        </div>
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select class="form-control" id="role" name="role" required>
                                                <option value="1">Admin</option>
                                                <option value="2">Staff</option>
                                                <option value="3">Suplier</option>
                                                <option value="4">Customer</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password"  required class="form-control" id="password" name="password"
                                                placeholder="*******">
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
                                            <label for="email">Email</label>
                                            <input type="email" required required class="form-control" id="editUserEmail" name="email"
                                                placeholder="Example@gmail.com">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Alamat</label>
                                            <input type="text"  required class="form-control" id="editUserAddress" name="address"
                                                placeholder="Alamat">
                                        </div>
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select class="form-control" id="role" name="role" required>
                                                <option value="1">Admin</option>
                                                <option value="2">Staff</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password"  required class="form-control" id="password" name="password"
                                                placeholder="*******">
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
                                        action="{{ route('delete-user', ':user_id') }}">
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
                        <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                        <a class="btn btn-primary" href="" data-toggle="modal" data-target="#addModal"
                        id="#myBtn">
                            Add <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            @if ($user->role == '1')
                                                Admin
                                            @elseif ($user->role == '2')
                                                Staff
                                            @elseif ($user->role == '3')
                                                Supplier
                                            @else
                                                Customer
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-primary edit-btn-user" href="#" data-toggle="modal"
                                                data-target="#editModalUser"
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}"
                                                data-user-email="{{ $user->email }}"
                                                data-user-address="{{ $user->address }}"
                                                data-user-role="{{ $user->role }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger delete-btn-user" href="#" data-toggle="modal"
                                                data-target="#deleteModalUser"
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}"
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
