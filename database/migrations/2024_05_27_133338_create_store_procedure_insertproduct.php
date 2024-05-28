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
            CREATE PROCEDURE insertProduct(IN vname VARCHAR(255), IN vhrg_beli INT, IN vhrg_jual INT, IN vstock INT)
            BEGIN
                INSERT INTO products (name, stock, hrg_jual, hrg_beli, created_at, updated_at) VALUES (vname, vstock, vhrg_jual, vhrg_beli, NOW(), NOW());
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insertProduct');
    }
};
