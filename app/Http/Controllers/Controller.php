<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Midtrans\Config;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function sendResponse($result, $message)
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data' => $result,
        ];

        return response()->json($response, 200);
    }

    // Send Error
    protected function sendError($error, $errorMessage = [])
    {
        $response = [
            'status' => false,
            'message' => $error,
        ];

        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }

        return response()->json($response, 400);
    }

    // Cek Donatur
    protected function cekDonatur($email, $whatsapp)
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
            'API-KEY' => env('VIBRANT_APIKEY'),
        ])
            ->post(env('VIBRANT_URL') . '/api/find-donatur', [
                'email' => $email,
                'whatsapp' => $whatsapp
            ])
            ->json();
    }

    public function sendWhatsapp($handphone, $messages)
    {
        $credentials = [
            'sender' => '6285784820928',
            'number' => $handphone,
            'message' => $messages,
            'api_key' => 'qhWHn3Xbak7Fy3pNnUvFAcKTU8huHh',
        ];

        $response = Http::post('https://apiwa.yatimmandiri.org/send-message', $credentials)
            ->json();

        return $response;
    }

    protected function initMidtrans()
    {
        Config::$serverKey = env('PROD_MIDTRANS_SERVER_KEY');
        Config::$isProduction = true;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}
