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
        Schema::create('tournament_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->enum('type', ['kyourugi', 'poomsae']);

            $table->enum('gender', ['M', 'F', 'Mixed']);
            $table->date('age_reference_date');
            $table->unsignedTinyInteger('min_age');
            $table->unsignedTinyInteger('max_age');

            // Kyourugi (weight class)
            $table->string('weight_class_name')->nullable();
            $table->decimal('min_weight', 5, 2)->nullable();
            $table->decimal('max_weight', 5, 2)->nullable();

            // Poomsae
            $table->enum('poomsae_type', ['individual', 'pair', 'team'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_categories');
    }
};
