<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('location', function (Blueprint $table) {
            $table->string('postal_code', 10)->primary();
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('region', 50);
            $table->string('country_region', 50);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('location');
    }
};
