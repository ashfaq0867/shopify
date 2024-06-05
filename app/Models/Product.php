<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'sku',
        'product',
        'descript',
        'brand',
        'vendor',
        'billing_type',
        'rental_term',
        'code',
        'our_sku',
        'sub_brand',
        'dealer_price',
        'map_price',
        'msrp_price',
        'customer_price',
        'currency',
        'download_path',
        'status',
        'last_modified',
        'release_date',
        'info',
        'youtube',
        'social_media',
        'categories',
        'is_hardware',
        'casepack',
        'webassets',
        'price_update',
        'is_new_product',
        'shopify_product',
        'shopify_prod_id',
    ];
}
