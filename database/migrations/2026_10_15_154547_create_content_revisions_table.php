
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_revisions', function (Blueprint $table) {
            $table->id();

            $table->string('model_type', 150);
            $table->unsignedBigInteger('model_id');

            $table->string('action', 30);

            $table->longText('old_values')->nullable();
            $table->longText('new_values')->nullable();

            $table->foreignId('changed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index([
                'model_type',
                'model_id',
            ], 'content_revisions_model_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_revisions');
    }
};
