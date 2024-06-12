<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;


class ReportTransactionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Menggunakan DB::select() untuk menjalankan query SQL
        $results = DB::select('SELECT * FROM `vhistory_transaction`');

        // Mengubah array hasil DB::select() menjadi Collection
        return new Collection($results);
    }
}
