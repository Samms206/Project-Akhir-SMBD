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
            CREATE TRIGGER `stock_product_update_after_insert`
            AFTER INSERT
            ON `detail_transactions`
            FOR EACH ROW
            BEGIN
                UPDATE products SET stock = stock - NEW.qty WHERE id = NEW.product_id;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS stock_product_update_after_insert');
    }
};
