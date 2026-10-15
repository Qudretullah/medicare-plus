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
        Schema::create('doctors', function (Blueprint $table) {

            $table->id();

            // Doctor basic information
            $table->string('name');
            $table->string('slug')->unique();

            // Professional details
            $table->string('specialization');
            $table->string('department')->nullable();
            $table->string('qualification')->nullable();

            $table->unsignedSmallInteger('experience_years')
                ->default(0);

            // Profile details
            $table->text('short_description')->nullable();
            $table->longText('bio')->nullable();

            // Doctor profile image
            $table->string('image_path')->nullable();

            // Admin management
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            // Created and updated dates
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
