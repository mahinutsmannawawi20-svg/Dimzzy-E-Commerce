<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YoGatewayService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('YOGATEWAY_API_KEY', 'yo_sec_0f602690a74b4d6158030c8f929371fe');
        $this->baseUrl = env('YOGATEWAY_BASE_URL', 'https://yogateway.web.id/api.php');
    }

    /**
     * Create payment transaction
     * 
     * @param float $amount
     * @return array|null
     */
    public function createPayment($amount)
    {
        try {
            $response = Http::get($this->baseUrl, [
                'action' => 'createpayment',
                'apikey' => $this->apiKey,
                'amount' => $amount,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['status']) && $data['status'] === true) {
                    return $data['result'];
                }
            }

            Log::error('YoGateway createPayment failed', [
                'response' => $response->body(),
                'amount' => $amount
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('YoGateway createPayment exception', [
                'message' => $e->getMessage(),
                'amount' => $amount
            ]);

            return null;
        }
    }

    /**
     * Check payment status
     * 
     * @param string $trxid
     * @return array|null
     */
    public function checkStatus($trxid)
    {
        try {
            $response = Http::get($this->baseUrl, [
                'action' => 'checkstatus',
                'apikey' => $this->apiKey,
                'trxid' => $trxid,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['status']) && $data['status'] === true) {
                    return $data['result'];
                }
            }

            Log::error('YoGateway checkStatus failed', [
                'response' => $response->body(),
                'trxid' => $trxid
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('YoGateway checkStatus exception', [
                'message' => $e->getMessage(),
                'trxid' => $trxid
            ]);

            return null;
        }
    }
}
