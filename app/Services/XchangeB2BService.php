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
        $this->apiKey = 'rk_1af000b670db58d95783a48d5561f28a1f29e652392619d31c74c04aa43b0ee75016';
        $this->etok = 'af7bdb016e0e863ee969f2ace2d4d94fd5e4d4d5129ce29dc06d515fd1b1fca6fc247a9153d5b5ffd03d3f9bf71dfe5fd14a2bd1ec50303c225ea10f873442a3';
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
