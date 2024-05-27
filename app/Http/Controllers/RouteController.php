<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function index()
    {
        $vhistory_trans = DB::select('SELECT * FROM `vhistory_transaction`');
        $vsold_product = DB::select('SELECT * FROM `vsold_product` LIMIT 6');
        return view('layout.dashboard', ['vhistory_trans' => $vhistory_trans, 'vsold_product' => $vsold_product]);
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
        $vhistory_trans = DB::select('SELECT * FROM `vhistory_transaction`');
        return view('layout.report.transaksi-report')->with('vhistory_trans', $vhistory_trans);
    }

    public function gotoDetailReportTransaction($id){
        $vdetail_history_trans = DB::select('SELECT * FROM `vdetail_history_transaction` WHERE trans_id = ?', [$id]);
        $vhistory_trans = DB::selectOne('SELECT * FROM `vhistory_transaction`');
        return view('layout.report.detail-transaksi-report', [
            'vdetail_history_trans' => $vdetail_history_trans,
            'vhistory_trans' => $vhistory_trans
        ]);
    }

    public function gotoRollbackProduct(){
        $barangs = DB::select('SELECT * FROM products WHERE deleted_at IS NOT NULL ORDER BY id ASC');
        return view('layout.rollback.product')->with('barangs', $barangs);

    }

    public function gotoRollbackCustomer(){
        $custs = DB::select('SELECT * FROM customers WHERE deleted_at IS NOT NULL ORDER BY id ASC');
        return view('layout.rollback.customer')->with('customers', $custs);
    }
}
