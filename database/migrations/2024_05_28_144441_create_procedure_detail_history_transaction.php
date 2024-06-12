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
        DB::unprepared('
            CREATE PROCEDURE detail_history_transaction(IN vid INT)
            BEGIN
                SELECT td.id, p.name as product, p.hrg_jual as harga, td.qty, (p.hrg_jual*td.qty) as sub_total FROM customers c
                JOIN transactions t ON t.cust_id = c.id
                JOIN detail_transactions td ON td.trans_id = t.id
                JOIN products p ON td.product_id = p.id WHERE t.id = vid;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS detail_history_transaction');
    }
};
