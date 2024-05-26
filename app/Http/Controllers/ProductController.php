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
        DB::insert('INSERT INTO products (name, stock, hrg_jual, hrg_beli, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())', [
            $request->name,
            $request->stock,
            $request->hrg_jual,
            $request->hrg_beli
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        DB::update('UPDATE products SET name = ?, stock = ?, hrg_jual = ?, hrg_beli = ?, updated_at = NOW() WHERE id = ?', [
            $request->edit_name,
            $request->edit_stock,
            $request->edit_hrg_jual,
            $request->edit_hrg_beli,
            $id
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::delete('UPDATE products SET deleted_at = NOW() WHERE id = ?', [$id]);

        return redirect('/barang')->with('warning', 'Data barang telah dihapus.');
    }
}
