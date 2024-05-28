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
            CREATE TRIGGER products_after_insert
            AFTER INSERT ON products
            FOR EACH ROW
            BEGIN
                INSERT INTO history_logs (table_name, action, user, created_at, updated_at)
                VALUES ("products", "insert", current_user(), NOW(), NOW());
            END
        ');

        DB::unprepared('
            CREATE TRIGGER products_after_update
            AFTER UPDATE ON products
            FOR EACH ROW
            BEGIN
                INSERT INTO history_logs (table_name, action, user, created_at, updated_at)
                VALUES ("products", "update", current_user(), NOW(), NOW());
            END
        ');

        DB::unprepared('
            CREATE TRIGGER products_after_delete
            AFTER DELETE ON products
            FOR EACH ROW
            BEGIN
                INSERT INTO history_logs (table_name, action, user, created_at, updated_at)
                VALUES ("products", "delete", current_user(), NOW(), NOW());
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS products_after_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS products_after_update');
        DB::unprepared('DROP TRIGGER IF EXISTS products_after_delete');
    }
};
