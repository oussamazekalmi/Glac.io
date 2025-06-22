<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fiscs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['rent', 'water', 'electricity', 'equipment', 'worklogs']);
            $table->string('equipment_name')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fiscs');
    }
};