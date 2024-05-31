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
            CREATE PROCEDURE validationDeleteProduct(IN vid INT, OUT message VARCHAR(255))
            BEGIN
                DECLARE baris INT;
                SELECT COUNT(*) INTO baris FROM detail_transactions WHERE product_id = vid;
                IF baris > 0 THEN
                    SET message = 'Produk tidak dapat dihapus karena terkait dengan transaksi.';
                ELSE
                    DELETE FROM products WHERE id = vid;
                    SET message = 'success';
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS validationDeleteProduct');
    }
};
