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
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('img')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete()->cascadeOnDelete();
            $table->enum('status',['active','inactive'])->default('active');
            $table->boolean('is_delete')->default(false);
            $table->ipAddress('ipAddress')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
