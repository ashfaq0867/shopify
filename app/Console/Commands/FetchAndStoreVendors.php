<?php

// app/Console/Commands/FetchAndStoreVendors.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Vendor;

class FetchAndStoreVendors extends Command
{
    protected $signature = 'vendors:fetch';
    protected $description = 'Fetch vendors from Xchange and store them in the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Fetching vendors from Xchange...');

        // Step 1: Fetch the API token
        $tokenResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('XCHANGE_TKEY')
        ])->post('https://xchangeb2b.com/XCH/vr_api/token');

        if (!$tokenResponse->successful()) {
            $this->error('Failed to fetch token from Xchange.');
            return 1;
        }

        $token = $tokenResponse->json()['token'];

        // Step 2: Fetch vendors from Xchange
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('XCHANGE_APIKEY') . ':' . $token
        ])->get('https://xchangemarketb2b.com/api/v2/athabasca/vendors');

        if (!$response->successful()) {
            $this->error('Failed to fetch vendors from Xchange.');
            return 1;
        }

        $vendors = $response->json()['vendors'];

        // Step 3: Store vendors in the database
        foreach ($vendors as $vendorData) {
            Vendor::updateOrCreate(
                ['vendor_id' => $vendorData['vendor_id']],
                [
                    'name' => $vendorData['name'],
                    'doing_business_as' => $vendorData['doing_business_as'] ?? null,
                    'phone' => $vendorData['phone'] ?? null,
                    'address' => $vendorData['address'] ?? null,
                    'city' => $vendorData['city'] ?? null,
                    'state_prov' => $vendorData['state_prov'] ?? null,
                    'zip' => $vendorData['zip'] ?? null,
                    'country' => $vendorData['country'] ?? null,
                    'contact_name' => $vendorData['contact_name'] ?? null,
                    'contact_email' => $vendorData['contact_email'] ?? null,
                    'contact_phone' => $vendorData['contact_phone'] ?? null,
                    'credit_status' => $vendorData['credit_status'] ?? null,
                    'prepay_required' => $vendorData['prepay_required'] ?? null,
                    'ap_name' => $vendorData['ap_name'] ?? null,
                    'ap_email' => $vendorData['ap_email'] ?? null,
                    'ap_phone' => $vendorData['ap_phone'] ?? null,
                    'support' => $vendorData['support'] ?? null,
                ]
            );
        }

        $this->info('Vendors have been successfully fetched and stored.');
        return 0;
    }
}
