<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('default_values', function (Blueprint $table) {
            $table->id();
            $table->decimal('kg_price', 8, 2);
            $table->decimal('hourly_rate', 8, 2);
            $table->decimal('rent', 10, 2);
            $table->timestamps();
        });

        DB::table('default_values')->insert([
            'kg_price' => 5,
            'hourly_rate' => 10,
            'rent' => 3000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('default_values');
    }
};