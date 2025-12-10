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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('sku')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->double('old_price')->nullable();
            $table->double('price')->nullable();
            $table->text('sort_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('additional_description')->nullable();
            $table->string('shipping_returns')->nullable();
            $table->boolean('status')->default(true);
            $table->string('created_by');
            $table->timestamps();

             // Soft delete column
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
