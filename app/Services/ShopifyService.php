<?php
// app/Services/ShopifyGraphQLService.php

namespace App\Services;

use Shopify\Clients\GraphQL;
use Shopify\Auth\Session;

class ShopifyGraphQLService
{
    protected $shopifyDomain;
    protected $accessToken;
    protected $client;

    public function __construct()
    {
        $this->shopifyDomain = env('SHOPIFY_DOMAIN');
        $this->accessToken = env('SHOPIFY_ACCESS_TOKEN');

        $this->client = new GraphQL(
            $this->shopifyDomain,
            new Session('session-id', $this->shopifyDomain, true),
            $this->accessToken
        );
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

        $response = $this->client->query([
            "query" => $query,
            "variables" => ["input" => $productData]
        ]);

        return $response->getDecodedBody();
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

        $response = $this->client->query([
            "query" => $query
        ]);

        return $response->getDecodedBody();
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

        $response = $this->client->query([
            "query" => $query,
            "variables" => ["id" => $productId]
        ]);

        return $response->getDecodedBody();
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

        $response = $this->client->query([
            "query" => $query,
            "variables" => ["input" => $productData]
        ]);

        return $response->getDecodedBody();
    }
}
