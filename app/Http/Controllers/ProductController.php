<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function show($id)
    {
        $productName = DB::select('SELECT name FROM products WHERE id = ? AND deleted_at is null', [$id]);

        return response()->json(['productName' => $productName[0]->name ?? '']);
    }

    public function store(Request $request)
    {
        DB::statement('CALL insertProduct(?, ?, ?, ?)', [
            $request->name,
            $request->hrg_beli,
            $request->hrg_jual,
            $request->stock,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        DB::statement('CALL updateProduct(?, ?, ?, ?, ?)', [
            $id,
            $request->edit_name,
            $request->edit_stock,
            $request->edit_hrg_jual,
            $request->edit_hrg_beli,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::delete('UPDATE products SET deleted_at = NOW() WHERE id = ?', [$id]);

        return redirect('/barang')->with('warning', 'Data barang telah dihapus.');
    }

    public function rollbackProduct($id){
        DB::update('UPDATE products SET deleted_at = NULL WHERE id = ?', [$id]);
        return redirect('/barang')->with('success', 'Berhasil');
    }

}
