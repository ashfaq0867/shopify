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
            $table->string('vendor_id')->nullable();
            $table->string('sku')->unique();
            $table->string('product');
            $table->string('descript')->nullable();
            $table->string('brand')->nullable();
            $table->string('vendor')->nullable();
            $table->string('billing_type')->nullable();
            $table->integer('rental_term')->nullable();
            $table->string('code')->nullable();
            $table->string('our_sku')->nullable();
            $table->string('sub_brand')->nullable();
            $table->decimal('dealer_price', 10, 2)->nullable();
            $table->decimal('map_price', 10, 2)->nullable();
            $table->decimal('msrp_price', 10, 2)->nullable();
            $table->decimal('customer_price', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('download_path')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('last_modified')->nullable();
            $table->timestamp('release_date')->nullable();
            $table->string('info')->nullable();
            $table->string('youtube')->nullable();
            $table->string('social_media')->nullable();
            $table->json('categories')->nullable();
            $table->string('is_hardware')->nullable();
            $table->integer('casepack')->nullable();
            $table->json('webassets')->nullable();
            $table->boolean('price_update')->default(false);
            $table->boolean('is_new_product')->default(false);
            $table->boolean('shopify_product')->default(false);
            $table->unsignedBigInteger('shopify_prod_id')->nullable();
            $table->timestamps();
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
