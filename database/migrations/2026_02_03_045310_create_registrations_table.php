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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('tournament_categories')
                ->cascadeOnDelete();

            $table->foreignId('contingent_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('medal_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->enum('status', [
                'registered',
                'passed_weigh_in',
                'failed_weigh_in',
                'competed',
                'dns',
                'dq',
            ])->default('registered');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
