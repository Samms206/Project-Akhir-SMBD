<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function addToCart($id)
    {
        $barang = DB::select('SELECT name, hrg_jual FROM products WHERE id = ?', [$id]);

        if (!empty($barang)) {
            return response()->json([
                'namaProduk' => $barang[0]->name,
                'harga' => $barang[0]->hrg_jual,
            ]);
        } else {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                // Membuat transaksi baru
                $customerId = $request->input('cust_id');
                $staffId = $request->input('staff_id');
                $discount = $request->input('diskon');
                $total = $request->input('total');
                $paid = $request->input('bayar');
                $change = $request->input('change');

                if ($customerId == null) {
                    $customerId = 1;
                }

                $transactionId = DB::table('transactions')->insertGetId([
                    'cust_id' => $customerId,
                    'staff_id' => $staffId,
                    'total' => $total,
                    'discount' => $discount,
                    'paid' => $paid,
                    'change' => $change,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Menyimpan detail transaksi
                $idBarangArray = $request->input('id_barang');
                $hargaArray = $request->input('harga');
                $qtyArray = $request->input('qty');
                $subTotalArray = $request->input('sub_total');

                foreach ($idBarangArray as $key => $idBarang) {
                    $qty = $qtyArray[$key];

                    DB::insert('INSERT INTO detail_transactions(trans_id, product_id, qty, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', [
                        $transactionId,
                        $idBarang,
                        $qty
                    ]);
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
}
