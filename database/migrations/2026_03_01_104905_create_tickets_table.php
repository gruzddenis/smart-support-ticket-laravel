<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');

            $table->string('status')->default('Open');

            $table->string('category')->nullable();
            $table->string('sentiment')->nullable();
            $table->string('urgency')->nullable();
            $table->text('suggested_reply')->nullable();

            $table->timestamp('ai_processed_at')->nullable();
            $table->string('ai_error')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
