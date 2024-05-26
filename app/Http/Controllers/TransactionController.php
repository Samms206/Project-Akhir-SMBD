<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function addToCart($id){
        $barang = Product::findOrFail($id);

        return response()->json([
            'namaProduk' => $barang->name,
            'harga' => $barang->hrg_jual,
        ]);
    }

    public function store(Request $request){
        // dd($request->all());
        // exit;
        DB::beginTransaction();
        try {
            // Membuat transaksi baru
            $transaction = new Transaction();
            $transaction->customer = $request->input('customer');
            $transaction->id_staff = Auth::user()->id;
            $transaction->discount = $request->input('diskon');
            $transaction->total = $request->input('total');
            $transaction->paid = $request->input('bayar');
            $transaction->change = $request->input('change');
            $transaction->save();

            // Mendapatkan id transaksi yang baru saja dibuat
            $transactionId = $transaction->id;

            // Menyimpan detail transaksi
            $idBarangArray = $request->input('id_barang');
            $hargaArray = $request->input('harga');
            $qtyArray = $request->input('qty');
            $subTotalArray = $request->input('sub_total');

            foreach ($idBarangArray as $key => $idBarang) {
                $detailTransaction = new DetailTransaction();
                $detailTransaction->id_transaction = $transactionId;
                $detailTransaction->id_barang = $idBarang;
                $detailTransaction->harga = $hargaArray[$key];
                $detailTransaction->qty = $qtyArray[$key];
                $detailTransaction->sub_total = $subTotalArray[$key];
                $detailTransaction->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan');

        } catch (\Throwable $th) {
            DB::rollBack();
            $errorMessage = $th->getMessage();
            dd($errorMessage);
        }
    }
}
