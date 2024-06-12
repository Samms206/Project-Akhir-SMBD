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
            CREATE VIEW vtotal_permonth AS
            SELECT
                SUM(CASE WHEN MONTH(created_at) = 1 THEN total-discount ELSE 0 END) AS januari,
                SUM(CASE WHEN MONTH(created_at) = 2 THEN total-discount ELSE 0 END) AS februari,
                SUM(CASE WHEN MONTH(created_at) = 3 THEN total-discount ELSE 0 END) AS maret,
                SUM(CASE WHEN MONTH(created_at) = 4 THEN total-discount ELSE 0 END) AS april,
                SUM(CASE WHEN MONTH(created_at) = 5 THEN total-discount ELSE 0 END) AS mei,
                SUM(CASE WHEN MONTH(created_at) = 6 THEN total-discount ELSE 0 END) AS juni
            FROM
                transactions
            WHERE
                YEAR(created_at) = YEAR(CURDATE()) AND
                MONTH(created_at) BETWEEN 1 AND 6;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vtotal_permonth');
    }
};
