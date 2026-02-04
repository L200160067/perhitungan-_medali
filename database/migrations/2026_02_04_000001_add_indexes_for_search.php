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
        Schema::table('dojangs', function (Blueprint $table) {
            $table->index('name', 'dojangs_name_idx');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->index('name', 'participants_name_idx');
            $table->index('gender', 'participants_gender_idx');
            $table->index('birth_date', 'participants_birth_date_idx');
            $table->index(['gender', 'name'], 'participants_gender_name_idx');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index('start_date', 'events_start_date_idx');
            $table->index('end_date', 'events_end_date_idx');
        });

        Schema::table('contingents', function (Blueprint $table) {
            $table->index('name', 'contingents_name_idx');
        });

        Schema::table('tournament_categories', function (Blueprint $table) {
            $table->index('name', 'tournament_categories_name_idx');
            $table->index('type', 'tournament_categories_type_idx');
            $table->index('gender', 'tournament_categories_gender_idx');
            $table->index(['type', 'gender'], 'tournament_categories_type_gender_idx');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->index('status', 'registrations_status_idx');
            $table->index(['category_id', 'status'], 'registrations_category_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dojangs', function (Blueprint $table) {
            $table->dropIndex('dojangs_name_idx');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->dropIndex('participants_name_idx');
            $table->dropIndex('participants_gender_idx');
            $table->dropIndex('participants_birth_date_idx');
            $table->dropIndex('participants_gender_name_idx');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex('events_start_date_idx');
            $table->dropIndex('events_end_date_idx');
        });

        Schema::table('contingents', function (Blueprint $table) {
            $table->dropIndex('contingents_name_idx');
        });

        Schema::table('tournament_categories', function (Blueprint $table) {
            $table->dropIndex('tournament_categories_name_idx');
            $table->dropIndex('tournament_categories_type_idx');
            $table->dropIndex('tournament_categories_gender_idx');
            $table->dropIndex('tournament_categories_type_gender_idx');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropIndex('registrations_status_idx');
            $table->dropIndex('registrations_category_status_idx');
        });
    }
};
