<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SettingsController extends Controller
{
    public function ckEditorUpload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }

    public function rekening()
    {
        $cekRekening = Http::withToken(env('MOOTA_TOKEN'))
            ->get('https://app.moota.co/api/v2/bank')->json();

        return $cekRekening;
    }

    public function paket(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'API-KEY' => env('VIBRANT_APIKEY'),
        ])->post(env('VIBRANT_URL') . '/api/paket-donasi', [])
            ->json()['data'];

        return $this->sendResponse($response, 'Get Data Successfully');
    }

    public function pageViews(Request $request)
    {
        $data = $request->all();
        return $this->sendResponse([], 'Delete Data Successfully');
    }
}
