<?php

namespace App\Http\Controllers;

use App\Services\ShopifyGraphQLService;
use Illuminate\Http\Request;
class ShopifyController extends Controller
{
    protected $shopifyService;

    public function __construct(ShopifyGraphQLService $shopifyService)
    {
        $this->shopifyService = $shopifyService;
    }

    public function createProduct(Request $request)
    {
        $productData = $request->all();
        $product = $this->shopifyService->createProduct($productData);
        return response()->json($product);
    }

    public function getProductList()
    {
        $products = $this->shopifyService->getProductList();
        return response()->json($products);
    }

    public function getProduct($id)
    {
        $product = $this->shopifyService->getProduct($id);
        return response()->json($product);
    }

    public function updateProduct(Request $request, $id)
    {
        $productData = $request->all();
        $product = $this->shopifyService->updateProduct($id, $productData);
        return response()->json($product);
    }
}
