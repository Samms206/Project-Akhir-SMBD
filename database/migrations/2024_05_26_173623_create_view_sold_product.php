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
            CREATE VIEW vsold_product AS
            SELECT
                p.name as product,
                SUM(td.qty) as sold,
                p.stock
            FROM products p
            JOIN detail_transactions td ON td.product_id = p.id
            JOIN transactions t ON t.id = td.trans_id
            GROUP BY p.name, p.stock
            ORDER BY sold DESC
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vsold_product');
    }
};
