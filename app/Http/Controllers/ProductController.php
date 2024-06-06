<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        return view('partials.products');
    }

    public function getProductList(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::query();

            // Handle sorting
            if ($request->has('order') && $request->has('columns')) {
                $orderColumn = $request->input('columns')[$request->input('order')[0]['column']]['data'];
                $orderDirection = $request->input('order')[0]['dir'];
                $query->orderBy($orderColumn, $orderDirection);
            }

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);

            $data = $this->getSearchedData($query, $start, $length);

            return response()->json([
                'data' => $data['data'],
                'recordsTotal' => $data['recordsTotal'],
                'recordsFiltered' => $data['recordsFiltered'],
            ]);
        }
    }

    private function getSearchedData($query, $start, $length)
    {
        $totalData = $query->count();
        $products = $query->skip($start)->take($length)->get();

        // Map products data
        $flattened_products = $products->map(function ($product) {
            return [
                'vendor_id' => $product->vendor_id,
                'sku' => $product->sku,
                'product' => $product->product,
                'descript' => $product->descript,
                'brand' => $product->brand,
                'vendor' => $product->vendor,
                'billing_type' => $product->billing_type,
                'rental_term' => $product->rental_term,
                'dealer_price' => $product->dealer_price,
                'map_price' => $product->map_price,
                'msrp_price' => $product->msrp_price,
                'customer_price' => $product->customer_price,
                'currency' => $product->currency,
                'download_path' => $product->download_path,
                'status' => $product->status,
            ];
        });

        return [
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $flattened_products,
        ];
    }

}
