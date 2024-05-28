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
            CREATE PROCEDURE updateProduct(IN vid INT, IN vname VARCHAR(255), IN vstock INT , IN vhrg_jual INT ,IN vhrg_beli INT)
            BEGIN
                UPDATE products SET name = vname, stock = vstock, hrg_jual = vhrg_jual, hrg_beli = vhrg_beli, updated_at = NOW() WHERE id = vid;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS updateProduct');
    }
};
