<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            CREATE PROCEDURE detailProduct(IN vid INT)
            BEGIN
                DECLARE baris INT;
                SELECT products.name as product, detail_transactions.qty, products.hrg_jual as harga, (products.hrg_jual * detail_transactions.qty) as sub_total,transactions.created_at as tanggal FROM transactions
                    JOIN detail_transactions ON transactions.id = detail_transactions.trans_id
                    JOIN products ON detail_transactions.product_id = products.id
                WHERE products.id = vid;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS detailProduct');
    }
};
