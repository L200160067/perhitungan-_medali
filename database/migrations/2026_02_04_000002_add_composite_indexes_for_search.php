<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('CREATE INDEX IF NOT EXISTS participants_gender_name_idx ON participants (gender, name)');
        DB::statement('CREATE INDEX IF NOT EXISTS tournament_categories_type_gender_idx ON tournament_categories (type, gender)');
        DB::statement('CREATE INDEX IF NOT EXISTS registrations_category_status_idx ON registrations (category_id, status)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS participants_gender_name_idx');
        DB::statement('DROP INDEX IF EXISTS tournament_categories_type_gender_idx');
        DB::statement('DROP INDEX IF EXISTS registrations_category_status_idx');
    }
};
