<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Resources\Collection\DonationCollection;
use App\Http\Resources\Resource\DonationResource;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Rekening;
use App\Models\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Midtrans\CoreApi;
use Midtrans\Transaction;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Donation::query()
            ->when($request->referals, function ($query) use ($request) {
                $query->where('donation_referals', $request->referals);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('donation_notransaksi', 'LIKE', '%' . $request->search . '%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('donation_status', $request->status);
            })
            ->when($request->statusCollection, function ($query) use ($request) {
                $query->whereIn('donation_status', $request->statusCollection);
            })
            ->orderBy('id', 'desc')
            ->orderBy('donation_status', 'asc');

        if ($request->per_page) {
            $donations = $query->paginate($request->per_page);
            $donationsResource = new DonationCollection($donations);
        } else {
            $donations = $query->orderBy('id', 'desc')->get();
            $donationsResource = DonationResource::collection($donations);
        }


        return $this->sendResponse($donationsResource, 'Get Data Successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonationRequest $request)
    {
        $cekRekening = Rekening::where('id', $request->rekening_id)->first();
        $cekCampaign = Campaign::where('id', $request->campaign_id)->first();

        $cekDonatur = $this->cekDonatur($request->email, $request->handphone);

        if (isset($cekDonatur['errors'])) {
            return $this->sendError('Error Whatsapp', $cekDonatur['errors']['whatsapp']);
        }

        if (!isset($cekDonatur['errors'])) {
            $kantor = 53;
            $handphone = $request->handphone;
            $kodeUser = $kantor  . date('Yms') . random_int(10, 99);
        } else {
            $kantor = $cekDonatur['data']['kantor_id'];
            $handphone = $cekDonatur['data']['phone'];
            $kodeUser = $cekDonatur['data']['id'];
        }

        $cekUsers = User::where('handphone', $request->handphone)
            ->orWhere('email', $request->email)
            ->first();

        if (!$cekUsers) {
            $cekUsers = User::create([
                'kode_user' => $kodeUser,
                'name' => $request->name,
                'email' => $request->email,
                'handphone' => $handphone,
                'email_verified_at' => now(),
                'kantor_id' => $kantor,
                'password' => Hash::make(Str::random(8)), // password
            ])->assignRole('Users');
        }

        $paymentGateway = [];
        $vaNumber = '';
        $billcode = '';
        $qrcode = '';
        $deeplinks = '';
        $hambaallah = 'N';
        $expired = '';
        $notransaksi = $cekUsers->kantor_id . date('ymdhis') . rand(10, 99);

        switch ($cekRekening->rekening_provider) {
            case 'Moota':
                # code...
                break;
            case 'Dana':
                # code...
                break;
            default:
                switch ($cekRekening->rekening_group) {
                    case 'e_money':
                        switch ($cekRekening->rekening_token) {
                            case 'qris':
                                $paymentMethod = [
                                    'payment_type' => $cekRekening->rekening_token,
                                    'qris' => [
                                        'acquirer' => 'airpay shopee'
                                    ]
                                ];
                                break;
                            default:
                                $paymentMethod = [
                                    'payment_type' => $cekRekening->rekening_token,
                                ];
                                break;
                        }
                        break;
                    default:
                        switch ($cekRekening->rekening_token) {
                            case 'echannel':
                                $paymentMethod = [
                                    'payment_type' => $cekRekening->rekening_token,
                                    'echannel' => [
                                        'bill_info1' => 'Payment',
                                        'bill_info2' => $cekCampaign->campaign_name
                                    ],
                                ];
                                break;
                            case 'permata':
                                $paymentMethod = [
                                    'payment_type' => $cekRekening->rekening_group,
                                ];
                                break;
                            default:
                                $paymentMethod = [
                                    'payment_type' => $cekRekening->rekening_group,
                                    'bank_transfer' => [
                                        'bank' => $cekRekening->rekening_token
                                    ],
                                ];
                                break;
                        }
                        break;
                }

                $paramMidtrans = array_merge($paymentMethod, [
                    'transaction_details' => [
                        'order_id' => $notransaksi,
                        'gross_amount' => $request->donation_nominaldonasi * $request->donation_quantity,
                    ],
                    'item_details' => [
                        [
                            'id' => $cekCampaign->id,
                            'price' => $request->donation_nominaldonasi,
                            'quantity' => $request->donation_quantity,
                            'name' => $cekCampaign->campaign_name,
                        ],
                    ],
                    'customer_details' => [
                        'first_name' => $cekUsers->name,
                        'last_name' => '',
                        'email' => $cekUsers->email,
                        'phone' => $cekUsers->handphone,
                    ],
                    'shipping_address' => [
                        'first_name' => $cekUsers->name,
                        'last_name' => '',
                        'email' => $cekUsers->email,
                        'phone' => $cekUsers->handphone,
                    ],
                ]);

                $this->initMidtrans();
                $paymentGateway = CoreApi::charge($paramMidtrans);

                $expired = $paymentGateway->expiry_time;

                switch ($cekRekening->rekening_group) {
                    case 'e_money':
                        switch ($cekRekening->rekening_token) {
                            case 'qris':
                                $qrcode = $paymentGateway->actions[0]->url;
                                $deeplinks = $paymentGateway->actions[0]->url;
                                break;
                            default:
                                $qrcode = $paymentGateway->actions[0]->url;
                                $deeplinks = $paymentGateway->actions[1]->url;
                                break;
                        }
                        break;

                    default:
                        // $expired = $paymentGateway->expiry_time;

                        switch ($cekRekening->rekening_token) {
                            case 'echannel':
                                $billcode = $paymentGateway->biller_code;
                                $vaNumber = $paymentGateway->bill_key;
                                break;
                            case 'permata':
                                $vaNumber = $paymentGateway->permata_va_number;
                                break;
                            default:
                                $vaNumber = $paymentGateway->va_numbers[0]->va_number;
                                break;
                        }
                        break;
                }
                break;
        }

        $data = array_merge($request->all(), [
            'donation_notransaksi' => $notransaksi,
            'donation_hambaallah' => $hambaallah,
            'donation_keterangan' => $request->keterangan_donasi,
            'donation_shohibul' => $request->shohibul,
            'donation_referals' => $request->referals,
            'donation_billcode' => $billcode,
            'donation_vanumber' => $vaNumber,
            'donation_qrcode' => $qrcode,
            'donation_deeplinks' => $deeplinks,
            'donation_expired' => $expired,
            'user_id' => $cekUsers->id,
            'donation_responsedonasi' => json_encode($paymentGateway),
        ]);

        $donations = Donation::create($data);
        $donationsResource = DonationResource::make($donations);

        return $this->sendResponse($donationsResource, 'Get Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        $donationsResource = DonationResource::make($donation);
        return $this->sendResponse($donationsResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        //
    }

    public function getTotalCountByStatus(Request $request)
    {
        $countGroupByDate = [];
        $count_pending_array = [];
        $count_success_array = [];
        $count_expired_array = [];

        $countPending = Donation::where('donation_status', 'Pending')
            ->when($request->referals != '-', function ($q) use ($request) {
                $q->where('donation_referals', $request->referals);
            })
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->count();
        $countExpired = Donation::where('donation_status', 'Expired')
            ->when($request->referals != '-', function ($q) use ($request) {
                $q->where('donation_referals', $request->referals);
            })
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->count();
        $countSuccess = Donation::where('donation_status', 'Success')
            ->when($request->referals != '-', function ($q) use ($request) {
                $q->where('donation_referals', $request->referals);
            })
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->count();


        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($request->endDate);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($request->startDate), $interval, $realEnd);

        foreach ($period as $date) {
            $array = Donation::where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->when($request->referals != '-', function ($q) use ($request) {
                    $q->where('donation_referals', $request->referals);
                })
                ->count();

            array_push($countGroupByDate, $array);
        }

        foreach ($period as $date) {
            $pending =  Donation::where('donation_status', 'Pending')
                ->when($request->referals != '-', function ($q) use ($request) {
                    $q->where('donation_referals', $request->referals);
                })
                ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->count();
            $success =  Donation::where('donation_status', 'Success')
                ->when($request->referals != '-', function ($q) use ($request) {
                    $q->where('donation_referals', $request->referals);
                })
                ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->count();
            $expired =  Donation::where('donation_status', 'Expired')
                ->when($request->referals != '-', function ($q) use ($request) {
                    $q->where('donation_referals', $request->referals);
                })
                ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->count();

            array_push($count_pending_array, $pending);
            array_push($count_success_array, $success);
            array_push($count_expired_array, $expired);
        }

        $response = [
            'count_pending' => $countPending,
            'count_expired' => $countExpired,
            'count_success' => $countSuccess,
            'countGroupByDate' => $countGroupByDate,
            'count_pending_array' => $count_pending_array,
            'count_success_array' => $count_success_array,
            'count_expired_array' => $count_expired_array,
        ];

        return $this->sendResponse($response, 'Get Data Successfully');
    }

    public function getTotalNominalByStatus(Request $request)
    {
        $nominalGroupByDate = [];
        $nominal_pending_array = [];
        $nominal_success_array = [];
        $nominal_expired_array = [];

        $nominalPending = Donation::where('donation_status', 'Pending')
            ->when($request->referals != '-', function ($q) use ($request) {
                $q->where('donation_referals', $request->referals);
            })
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->sum(DB::raw('donation_quantity * donation_nominaldonasi + donation_uniknominal'));
        $nominalExpired = Donation::where('donation_status', 'Expired')
            ->when($request->referals != '-', function ($q) use ($request) {
                $q->where('donation_referals', $request->referals);
            })
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->sum(DB::raw('donation_quantity * donation_nominaldonasi + donation_uniknominal'));
        $nominalSuccess = Donation::where('donation_status', 'Success')
            ->when($request->referals != '-', function ($q) use ($request) {
                $q->where('donation_referals', $request->referals);
            })
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->sum(DB::raw('donation_quantity * donation_nominaldonasi + donation_uniknominal'));

        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($request->endDate);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($request->startDate), $interval, $realEnd);

        foreach ($period as $date) {
            $array = Donation::where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->when($request->referals != '-', function ($q) use ($request) {
                    $q->where('donation_referals', $request->referals);
                })
                ->sum(DB::raw('donation_quantity * donation_nominaldonasi + donation_uniknominal'));
            array_push($nominalGroupByDate, $array);
        }

        foreach ($period as $date) {

            $pending = Donation::where('donation_status', 'Pending')
                ->when($request->referals != '-', function ($q) use ($request) {
                    $q->where('donation_referals', $request->referals);
                })
                ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->sum(DB::raw('donation_quantity * donation_nominaldonasi + donation_uniknominal'));
            $success =  Donation::where('donation_status', 'Success')
                ->when($request->referals != '-', function ($q) use ($request) {
                    $q->where('donation_referals', $request->referals);
                })
                ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->sum(DB::raw('donation_quantity * donation_nominaldonasi + donation_uniknominal'));
            $expired = Donation::where('donation_status', 'Expired')
                ->when($request->referals != '-', function ($q) use ($request) {
                    $q->where('donation_referals', $request->referals);
                })
                ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->sum(DB::raw('donation_quantity * donation_nominaldonasi + donation_uniknominal'));

            array_push($nominal_pending_array, $pending);
            array_push($nominal_success_array, $success);
            array_push($nominal_expired_array, $expired);
        }

        $response = [
            'nominal_pending' => $nominalPending,
            'nominal_expired' => $nominalExpired,
            'nominal_success' => $nominalSuccess,
            'nominalGroupByDate' => $nominalGroupByDate,
            'nominal_pending_array' => $nominal_pending_array,
            'nominal_success_array' => $nominal_success_array,
            'nominal_expired_array' => $nominal_expired_array,
        ];

        return $this->sendResponse($response, 'Get Data Successfully');
    }

    public function checkStatus()
    {
        $this->initMidtrans();
        $donations = Donation::all();

        foreach ($donations as $key) {
            $status = Transaction::status($key->donation_notransaksi);
            $donations = Donation::where('donation_notransaksi', $key->donation_notransaksi)->first();
            $transaction = $status['transaction_status'];

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
        }

        return $this->sendResponse('Success', 'Payment Successfully');
    }
}
