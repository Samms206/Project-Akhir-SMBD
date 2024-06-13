@extends('index')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Log Activity</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item">Log Activityk</li>
            </ol>
        </div>
        <!--Row-->
        <div class="row mb-3">
            <!-- Invoice Example -->
            <div class="col mb-4">
                <div class="card">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tabel</th>
                                    <th>Aksi</th>
                                    <th>User</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($log_activity as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1}}</td>
                                        <td>{{ $item->table_name }}</td>
                                        <td>{{ $item->action }}</td>
                                        <td>{{ $item->user }}</td>
                                        <td>{{ $item->created_at }}</td>
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
