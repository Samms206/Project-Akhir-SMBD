@extends('index')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Laporan Transaksi</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item">Detail Laporan Transaksi</li>
            </ol>
        </div>
        <div class="container mt-6 mb-7 mb-4">
            <div class="row justify-content-center">
              <div class="col-lg-12 col-xl-7">
                <div class="card">
                  <div class="card-body p-5">
                    <div class="border-top border-gray-200 pt-4">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="text-muted mb-2">Payment No.</div>
                          <strong>#{{ $vhistory_trans->id }}</strong>
                        </div>
                        <div class="col-md-6 text-md-end">
                          <div class="text-muted mb-2">Payment Date</div>
                          <strong>{{ $vhistory_trans->tanggal }}</strong>
                        </div>
                      </div>
                    </div>

                    <div class="border-top border-gray-200 mt-4 py-4">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="text-muted mb-2">Staff</div>
                          <strong>
                            {{ $vhistory_trans->staff}}
                          </strong>
                        </div>
                        <div class="col-md-6 text-md-end">
                          <div class="text-muted mb-2">Payment To</div>
                          <strong>
                            POS Linea
                          </strong>
                          <p class="fs-sm">
                            Perum Reka Village, Blok AA no.4
                            <br>
                            <a href="mailto:hellolineastudio@gmail.com" class="text-purple">hellolineastudio@gmail.com
                            </a>
                          </p>
                        </div>
                      </div>
                    </div>

                    <table class="table border-bottom border-gray-200 mt-3">
                      <thead>
                        <tr>
                          <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">Produk</th>
                          <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm text-end px-0">Harga</th>
                          <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">Qty</th>
                          <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm text-end px-0">Sub Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($vdetail_history_trans as $item)
                            <tr>
                                <td class="px-0">{{ $item->product }}</td>
                                <td class="text-end px-0">Rp. {{ $item->harga }}</td>
                                <td class="px-0">{{ $item->qty }}x</td>
                                <td class="text-end px-0">Rp. {{ $item->sub_total }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-end px-0">Total</td>
                            <td></td>
                            <td></td>
                            <td class="text-end px-0">
                                <b class="text-dark">Rp. {{ $vhistory_trans->total }}</b>
                            </td>
                        </tr>
                      </tbody>
                    </table>

                    <div class="mt-5">
                      <div class="d-flex justify-content-end">
                        <p class="text-muted me-3">Diskon : </p>
                        <span>Rp. {{ $vhistory_trans->discount }}</span>
                      </div>
                      <div class="d-flex justify-content-end mt-3">
                        <h5 class="me-3">Dibayar :</h5>
                        <h5> Rp. {{ $vhistory_trans->paid }}</h5>
                      </div>
                      <div class="d-flex justify-content-end mt-3">
                        <h5 class="me-3">Kembalian :</h5>
                        <h5 class="text-success"> Rp. {{ $vhistory_trans->changed }}</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection
