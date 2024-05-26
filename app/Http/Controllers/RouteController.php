<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function index()
    {
        return view('layout.dashboard');
    }

    public function gotoCharts()
    {
        return view('layout.chart');
    }

    public function gotoBarang()
    {
        $barangs = DB::select('SELECT * FROM products WHERE deleted_at IS NULL ORDER BY id ASC');
        return view('layout.barang')->with('barangs', $barangs);
    }

    public function gotoTransaksi()
    {
        $custs = DB::select('SELECT * FROM customers WHERE deleted_at IS NULL ORDER BY id ASC');
        return view('layout.transaksi', ['custs' => $custs]);
    }

    public function gotoUser()
    {
        $custs = DB::select('SELECT * FROM customers WHERE deleted_at IS NULL ORDER BY id ASC');
        return view('layout.user')->with('customers', $custs);
    }

    public function gotoReportTransaction(){
        $invoices = DB::select('SELECT * FROM customers WHERE deleted_at IS NULL ORDER BY id ASC');
        return view('layout.report.transaksi-report')->with('invoices', $invoices);
    }
}
