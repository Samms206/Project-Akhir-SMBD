<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        DB::insert('INSERT INTO customers (name, phone, address, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', [
            $request->name,
            $request->phone,
            $request->address
        ]);

        return redirect('/customer')->with('success', 'Data customer berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        DB::update('UPDATE customers SET name = ?, phone = ?, address = ?, updated_at = NOW() WHERE id = ?', [
            $request->name,
            $request->phone,
            $request->address,
            $id
        ]);

        return redirect('/customer')->with('success', 'Data customer berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::delete('UPDATE customers SET deleted_at = NOW() WHERE id = ?', [$id]);

        return redirect('/customer')->with('warning', 'Data customer telah dihapus.');
    }
}
