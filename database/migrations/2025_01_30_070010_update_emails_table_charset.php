<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailsTableCharset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Convert table charset and collation
        DB::statement("ALTER TABLE jobs CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    }

    public function down(): void
    {
        // Revert back to previous charset (if needed)
        DB::statement("ALTER TABLE jobs CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
    }
}
