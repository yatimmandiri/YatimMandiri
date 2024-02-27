<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

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
}
