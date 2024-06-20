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

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('image_path');
            $table->string('url');
            $table->string('username')->nullable();
            $table->timestamps();
        });

        Schema::create('app_downloads', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('image_path');
            $table->string('download_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('app_downloads');
    }
};
