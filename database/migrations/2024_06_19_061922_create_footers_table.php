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

        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_footer_id')->constrained()->onDelete('cascade');
            $table->foreignId('platform_footer_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('url');
            $table->string('username');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};
