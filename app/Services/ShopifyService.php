<?php
// app/Services/ShopifyGraphQLService.php

namespace App\Services;

use Shopify\Clients\GraphQL;
use Shopify\Auth\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ShopifyGraphQLService
{
    protected $shopifyDomain;
    protected $accessToken;
    protected $client;

    public function __construct()
    {
        $this->shopifyDomain = env('SHOPIFY_DOMAIN');
        $this->accessToken = env('SHOPIFY_ACCESS_TOKEN');
        $this->client = new Client();
    }

    protected function query($query, $variables = [])
    {
        $response = $this->client->post("https://{$this->shopifyDomain}/admin/api/2024-04/graphql.json", [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Shopify-Access-Token' => $this->accessToken,
            ],
            'json' => [
                'query' => $query,
                'variables' => $variables,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function createProduct(array $productData)
    {
        $query = <<<'GRAPHQL'
        mutation($input: ProductInput!) {
            productCreate(input: $input) {
                product {
                    id
                    title
                }
                userErrors {
                    field
                    message
                }
            }
        }
        GRAPHQL;

        return $this->query($query, ["input" => $productData]);
    }

    public function getProductList()
    {
        $query = <<<'GRAPHQL'
        {
            products(first: 10) {
                edges {
                    node {
                        id
                        title
                    }
                }
            }
        }
        GRAPHQL;

        return $this->query($query);
    }

    public function getProduct($productId)
    {
        $query = <<<'GRAPHQL'
        query($id: ID!) {
            product(id: $id) {
                id
                title
                descriptionHtml
            }
        }
        GRAPHQL;

        return $this->query($query, ["id" => $productId]);
    }

    public function updateProduct($productId, array $productData)
    {
        $query = <<<'GRAPHQL'
        mutation($input: ProductInput!) {
            productUpdate(input: $input) {
                product {
                    id
                    title
                }
                userErrors {
                    field
                    message
                }
            }
        }
        GRAPHQL;

        $productData['id'] = $productId;

        return $this->query($query, ["input" => $productData]);
    }
}
