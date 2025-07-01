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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("title_en");
            $table->string("title_ar");
            $table->string("description_en");
            $table->string("description_ar");
            $table->string("logo_og");
            $table->string("logo_site");
            $table->string("keywords");
            $table->string("favicon");
            $table->text("head")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
