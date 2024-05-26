@extends('index')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item">Transaksi</li>
            </ol>
        </div>
        <!--Row-->
        <div class="row">
            <div class="col-lg-4">
                <!-- Form Basic -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" id="idBarang" name="idBarang" placeholder="ID Barang">
                            </div>
                            <div class="form-group">
                                <label for="namaProduk">Nama Produk</label>
                                <input type="text" class="form-control" id="namaProduk" placeholder="Nama Produk"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="touchSpin3">Qty</label>
                                <div class="input-group touch-spin">
                                    <span class="input-group-btn input-group-prepend">
                                    </span>
                                    <input style="text-align: center" id="touchSpin3" type="text" value="0"
                                        name="qty" class="form-control">
                                    <span class="input-group-btn input-group-append">
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <button style="width: 100%" type="button" class="btn btn-warning" id="btnClear">Clear</button>
                                </div>
                                <div class="col-lg-6">
                                    <button style="width: 100%" type="button" class="btn btn-primary" id="btnAddproduct">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4" style="border-top: 4px solid #66BB69;">
                    <div class="card-body pr-4 pl-4">
                        <div class="row justify-content-between">
                            <div class="h4">GRAND TOTAL</div>
                            <div class="h4"><span id="grandTotal">Rp.-</span></div>
                        </div>
                        <hr>
                        <div class="row justify-content-end">
                            <div class="h5 text-success">Change : <span id="change">Rp.-</span></div>
                        </div>
                    </div>
                </div>

                <!-- Form Basic -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="kasir">Kasir</label>
                                        <input type="text" class="form-control" id="kasir" placeholder="Kasir"
                                            readonly value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="select2SinglePlaceholder">Customer</label>
                                        <select class="select2-single-placeholder form-control" name="customer"
                                            id="select2SinglePlaceholder">
                                            <option value="">Select</option>
                                            @foreach ($names as $name)
                                                <option value="{{ $name }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- id="formTransaction" --}}
                <form method="POST" action="{{ route('save-transaction') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Row -->
                    <div class="row">
                        <!-- DataTable with Hover -->
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="table-responsive p-3">
                                    {{-- Table Keranjang --}}
                                    <table class="table align-items-center table-flush table-hover" id="keranjang">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Total</th>
                                                <th id="total">Rp.-</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Row-->
                    <div class="row mb-4">
                        <div class="col-lg-8"></div>
                        <div class="col-lg-4">
                            <input type="hidden" name="total" id="tf_total">
                            <input type="hidden" name="change" id="tf_change">
                            <div class="form-group">
                                <label for="diskon">Diskon(Rp.)</label>
                                <input value="0" type="text" class="form-control" id="diskon" placeholder="Rp.-" name="diskon">
                            </div>
                            <div class="form-group">
                                <label for="bayar">Bayar(Rp.)</label>
                                <input required type="text" class="form-control" id="bayar" placeholder="Rp.-" name="bayar">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <button style="width: 100%" type="button" class="btn btn-danger mb-3">Batal</button>
                                </div>
                                <div class="col-lg-6">
                                    <button style="width: 100%" type="submit" class="btn btn-success" id="btnConfirm">Beli</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--Row-->

        </div>
        <!---Container Fluid-->
    @endsection
