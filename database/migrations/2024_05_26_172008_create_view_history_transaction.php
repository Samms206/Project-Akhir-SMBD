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
            CREATE VIEW vhistory_transaction AS
            SELECT
                t.id,
                c.name as customer,
                u.name as staff,
                t.total,
                t.discount,
                t.paid,
                (t.change + t.discount) as changed,
                t.created_at as tanggal
            FROM customers c
            JOIN transactions t ON t.cust_id = c.id
            JOIN users u ON t.staff_id = u.id
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vhistory_transaction');
    }
};
