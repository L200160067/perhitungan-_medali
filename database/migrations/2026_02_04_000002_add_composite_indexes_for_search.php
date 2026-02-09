<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->index(['gender', 'name'], 'participants_gender_name_idx');
        });

        Schema::table('tournament_categories', function (Blueprint $table) {
            $table->index(['type', 'gender'], 'tournament_categories_type_gender_idx');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->index(['category_id', 'status'], 'registrations_category_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropIndex('participants_gender_name_idx');
        });

        Schema::table('tournament_categories', function (Blueprint $table) {
            $table->dropIndex('tournament_categories_type_gender_idx');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropIndex('registrations_category_status_idx');
        });
    }
};
