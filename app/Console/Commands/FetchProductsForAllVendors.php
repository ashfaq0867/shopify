<?php

namespace App\Console\Commands;

use App\Models\Vendor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class FetchProductsForAllVendors extends Command
{
    protected $signature = 'products:fetch-for-all-vendors';
    protected $description = 'Fetch products for all vendors from Xchange and store them in the database';

    protected $apiKey;
    protected $tkey;
    protected $baseApiUrl;

    public function __construct()
    {
        parent::__construct();

        // Set the credentials and base API URL
        $this->apiKey = config('const.xchange_api_key');
        $this->tkey = config('const.xchange_tkey');
        $this->baseApiUrl = config('const.xchange_base_url');
    }

    public function handle()
    {
        $this->info("Fetching products for all vendors from Xchange...");

        $vendors = Vendor::all();

        foreach ($vendors as $vendor) {
            $this->fetchAndStoreProducts($vendor->vendor_id);
        }

        $this->info('Products for all vendors have been successfully fetched and stored.');
    }

    protected function fetchAndStoreProducts($vendorId)
    {
        $token = $this->getToken();
        if (!empty($token)) {
            $productsResponse = Http::withBasicAuth($this->apiKey, $token)
                ->get("{$this->baseApiUrl}/products?vendor_id={$vendorId}");

            if (!$productsResponse->successful()) {
                $this->error("Failed to fetch products for vendor ID: $vendorId from Xchange.");
                return;
            }

            $responseData = $productsResponse->json();
            $products = $responseData['products'];
            // Store products in the database
            foreach ($products as $productData) {
//                $lastModified = $productData['last_modified'] ?? null;
//                if ($lastModified && !strtotime($lastModified)) {
//                    $lastModified = null; // Set last_modified to null if it's invalid
//                }
//
//                // Check if the release_date is valid
//                $releaseDate = $productData['release_date'] ?? null;
//                if ($releaseDate && !strtotime($releaseDate)) {
//                    $releaseDate = null; // Set release_date to null if it's invalid
//                }
                Product::updateOrCreate(
                    ['sku' => $productData['sku']],
                    [
                        'vendor_id' => $vendorId,
                        'product' => $productData['product'],
                        'descript' => $productData['descript'] ?? null,
                        'brand' => $productData['brand'] ?? null,
                        'vendor' => $productData['vendor'] ?? null,
                        'billing_type' => $productData['billing_type'] ?? null,
                        'rental_term' => $productData['rental_term'] ?? null,
                        'code' => $productData['code'] ?? null,
                        'our_sku' => $productData['our_sku'] ?? null,
                        'sub_brand' => $productData['sub_brand'] ?? null,
                        'dealer_price' => $productData['dealer_price'] ?? null,
                        'map_price' => $productData['map_price'] ?? null,
                        'msrp_price' => $productData['msrp_price'] ?? null,
                        'customer_price' => $productData['customer_price'] ?? null,
                        'currency' => $productData['currency'] ?? null,
                        'download_path' => $productData['download_path'] ?? null,
                        'status' => $productData['status'] ?? null,
                        'last_modified' => null,
                        'release_date' => null ,
                        'info' => $productData['info'] ?? null,
                        'youtube' => $productData['youtube'] ?? null,
                        'social_media' => $productData['social_media'] ?? null,
                        'categories' => json_encode($productData['categories'] ?? []),
                        'is_hardware' => $productData['is_hardware'] ?? null,
                        'casepack' => $productData['casepack'] ?? null,
                        'webassets' => json_encode($productData['webassets'] ?? []),
                        'price_update' => $productData['price_update'] ?? false,
                        'is_new_product' => $productData['is_new_product'] ?? false,
                        'shopify_product' => $productData['shopify_product'] ?? false,
                        'shopify_prod_id' => $productData['shopify_prod_id'] ?? null,
                    ]
                );
            }
        }
    }

    protected function getToken()
    {
        $tokenResponse = Http::get("https://xchangeb2b.com/XCH/vr_api/token?tkey={$this->tkey}");

        if (!$tokenResponse->successful()) {
            $this->error('Failed to fetch token from Xchange.');
            return null;
        }

        return $tokenResponse->body();
    }
}
