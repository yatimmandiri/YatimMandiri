<?php

namespace App\Http\Controllers;

use App\Http\Resources\Resource\DonationResource;
use App\Jobs\NotificationTransaction;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Rekening;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Midtrans\Notification;

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

    public function notifications()
    {
        $this->initMidtrans();
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $donations = Donation::where('donation_notransaksi', $notif->order_id)->first();
        $cekRekening = Rekening::where('id', $donations->rekening_id)->first();
        $cekUsers = User::where('id', $donations->user_id)->first();
        $cekCampaign = Campaign::where('id', $donations->campaign_id)->first();

        switch ($transaction) {
            case 'settlement':
                $donations->donation_status = "Success";
                $donations->save();
                break;
            case 'pending':
                $donations->donation_status = "Pending";
                $donations->save();
                break;
            default:
                $donations->donation_status = "Expired";
                $donations->save();
                break;
        }

        if ($donations->donation_status == 'Success') {
            $message = 'Alhamdulillah, terima kasih atas Donasi Sahabat *' . $cekUsers->name . '*, . Insya Allah, Donasimu akan kami salurkan sesuai amanah dan ketentuan syariah
                Invoice: *' . $donations->donation_notransaksi . '* 
                Nama program: *' . $cekCampaign->campaign_name . '* 
                Jumlah Transfer: *Rp ' . number_format($donations->donation_nominaldonasi * $donations->donation_quantity, 0, ",", ".") . '*  
                Melalui: ' . $cekRekening->rekening_bank . ' *(' . $donations->donation_vanumber . ')* 
                A.n. Yayasan Yatim Mandiri (Donasi Yatim Mandiri)  
                ⌛️ Semoga Allah Ta ala melimpahkan pahala dan keberkahan terhadap harta yang telah Sahabat ' . $cekUsers->name . ' titipkan, dan semoga menjadi pembuka rahmat, kasih sayang, juga rezeki dunia-akhirat yang luas. Aamiin yaa Rabbal alamin.';
        } else {
            $message = 'Sahabat *' . $cekUsers->name . '*, selangkah lagi untuk menyelesaikan pembayaran donasi 
            Invoice: *' . $donations->donation_notransaksi . '* 
            Nama program: *' . $cekCampaign->campaign_name . '* 
            Jumlah Transfer: *Rp ' . number_format($donations->donation_nominaldonasi * $donations->donation_quantity, 0, ",", ".") . '*  
            Melalui: ' . $cekRekening->rekening_bank . ' *(' . $donations->donation_vanumber . ')* 
            A.n. Yayasan Yatim Mandiri (Donasi Yatim Mandiri)  
            ⌛️ Selanjutnya silahkan melakukan pembayaran Donasi. Pastikan transfer dengan nominal yang tertera diatas agar bisa terkonfirmasi otomatis dengan tepat. 
            Salam.';
        }

        dispatch(new NotificationTransaction($cekUsers->email, [
            'name' => $cekUsers->name,
            'handphone' => $cekUsers->handphone,
            'invoice' =>  $donations->donation_notransaksi,
            'campaigns' =>  $cekCampaign->campaign_name,
            'nominal' => $donations->donation_nominaldonasi * $donations->donation_quantity,
            'payments' => $cekRekening->rekening_bank,
            'virtualaccount' => $donations->donation_vanumber,
            'status' => $donations->donation_status,
        ]));

        $this->sendWhatsapp($cekUsers->handphone, $message);

        $donationsResource = DonationResource::make($donations);

        return $this->sendResponse($donationsResource, 'Payment Successfully');
    }
}
