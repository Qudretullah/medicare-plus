
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
        Schema::create('website_content_items', function (Blueprint $table) {

            $table->id();

            // Website page: home, about, contact, etc.
            $table->string('page', 100)->index();

            // Unique identifier for each editable content item
            $table->string('content_key', 191)->unique();

            // text, textarea, image, url, etc.
            $table->string('type', 30)->default('text');

            // Current content value
            $table->longText('value')->nullable();

            // Original/default content for restoration
            $table->longText('original_value')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_content_items');
    }
};
