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
        Schema::table('image_apps', function (Blueprint $table) {
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('image_apps', function (Blueprint $table) {
            $table->dropColumn('file_size');
            $table->dropColumn('mime_type');
        });
    }
};

        
