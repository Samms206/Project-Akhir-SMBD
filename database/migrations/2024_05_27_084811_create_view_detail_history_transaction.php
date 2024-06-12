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
        DB::statement('
            CREATE VIEW vdetail_history_transaction AS
            SELECT td.id, t.id as trans_id, p.name as product, p.hrg_jual as harga, td.qty, (p.hrg_jual*td.qty) as sub_total FROM customers c
            JOIN transactions t ON t.cust_id = c.id
            JOIN detail_transactions td ON td.trans_id = t.id
            JOIN products p ON td.product_id = p.id
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vdetail_history_transaction');
    }
};
