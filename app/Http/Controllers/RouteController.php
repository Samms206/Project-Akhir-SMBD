<?php

namespace App\Http\Controllers;

use App\Exports\ReportTransactionExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RouteController extends Controller
{
    public function index()
    {
        //tabel history transaction
        $vhistory_trans = DB::select('SELECT * FROM `vhistory_transaction`');
        //product sold
        $vsold_product = DB::select('SELECT * FROM `vsold_product` LIMIT 6');
        //Earning Monthly
        $vearning_monthly = DB::selectOne('SELECT * FROM `vearning_monthly`');
        //product sold All
        $vsold_product_all = DB::selectOne('SELECT * FROM `vsold_product_all`');
        //Total Transaction
        $vtotal_transaction = DB::selectOne('SELECT * FROM `vtotal_transaction`');
        //Total Produts
        $vtotal_produts = DB::selectOne('SELECT * FROM `vtotal_produts`');
        //Total Pendapatan Perbulan
        $vtotal_earning_permonth = DB::selectOne('SELECT * FROM `vtotal_permonth`');


        return view('layout.dashboard', [
            'vhistory_trans' => $vhistory_trans,
            'vsold_product' => $vsold_product,
            'vearning_monthly' => $vearning_monthly,
            'vsold_product_all' => $vsold_product_all,
            'vtotal_transaction' => $vtotal_transaction,
            'vtotal_produts' => $vtotal_produts,
            'vtotal_earning_permonth' => $vtotal_earning_permonth
        ]);
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
        //Earning Monthly
        $vtotal_earning = DB::selectOne('SELECT * FROM `vtotal_earning`');
        //Total Transaction
        $vtotal_transaction = DB::selectOne('SELECT * FROM `vtotal_alltransaction`');
        return view('layout.report.transaksi-report', [
            'vhistory_trans' => $vhistory_trans,
            'vearning_monthly' => $vtotal_earning,
            'vtotal_transaction' => $vtotal_transaction
        ]);
    }

    public function gotoReportProduct(){
        $products = DB::select('SELECT * FROM `products`');
        //Earning Monthly
        $vsold_product_all = DB::selectOne('SELECT * FROM `vsold_product_all`');
        //Total Transaction
        $total_stock = DB::selectOne('SELECT * FROM `vtotal_stock`');
        return view('layout.report.barang-report', [
            'products' => $products,
            'vsold_product_all' => $vsold_product_all,
            'total_stock' => $total_stock
        ]);
    }

    public function gotoDetailReportTransaction($id){
        $vdetail_history_trans = DB::select('CALL detail_history_transaction(?)', [$id]);
        $vhistory_trans = DB::selectOne('CALL history_transaction(?)', [$id]);
        return view('layout.report.detail-transaksi-report', [
            'vdetail_history_trans' => $vdetail_history_trans,
            'vhistory_trans' => $vhistory_trans
        ]);
    }

    public function gotoDetailReportProduct($id){
        $detail_product = DB::select('CALL detailProduct(?)', [$id]);
        return view('layout.report.detail-barang-report', [
            'detail_product' => $detail_product,
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

    public function exportReportTransaction(){
        return Excel::download(new ReportTransactionExport, 'report-transaction.xlsx');
    }
}
