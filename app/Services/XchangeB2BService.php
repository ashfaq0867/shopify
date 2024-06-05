<?php

namespace App\Services;

use GuzzleHttp\Client;

class XchangeB2BService{
    protected $apiKey;
    protected $etok;
    protected $baseApiUrl = 'https://xchangemarketb2b.com/api/v2/athabasca';
    protected $tokenUrl = 'https://xchangeb2b.com/XCH/vr_api/token';
    protected $httpClient;

    public function __construct($apiKey, $etok)
    {
        $this->apiKey = $apiKey;
        $this->etok = $etok;
        $this->httpClient = new Client([
        'base_uri' => $this->baseApiUrl,
        'headers' => [
        'Accept' => 'application/json',],]);
    }

    public function getVendors()
    {
        // Get timed token
        $token = $this->getToken();
        // Make API request with token
        $response = $this->httpClient->request('GET', '/vendors', [
        'headers' => [
        'Authorization' => 'Bearer ' . $this->apiKey . ':' . $token,
        'Accept' => 'application/json',],]);

        // Parse and return response
        return json_decode($response->getBody(), true);
    }

    protected function getToken()
    {

        // Make request for timed token
        $response = $this->httpClient->post($this->tokenUrl, [
        'headers' => [
        'Authorization' => 'Bearer ' . $this->etok,
        'Accept' => 'application/json',
        ],]);
         // Extract token from the response
        $token = json_decode($response->getBody(), true)['token'];
        return $token;
    }

}
