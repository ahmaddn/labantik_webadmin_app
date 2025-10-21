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
        Schema::create('s_news', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('content');
            $table->uuid('user_id');
            $table->uuid('s_category_id');
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('core_users');
            $table->foreign('s_category_id')->references('id')->on('s_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s__news');
    }
};
