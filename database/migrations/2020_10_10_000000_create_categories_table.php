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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable();
            $table->string('name');
            $table->string('key')->index();
            $table->string('slug')->index();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_default')->default(false);
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
