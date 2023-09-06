<?php

namespace App\Http\Controllers;

use App\Jobs\ThanhToanBillJob;
use App\Models\ChiTietDonHang;
use App\Models\HoaDon;
use App\Models\KhachHang;
use App\Models\Transaction;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index()
    {
        // $content = 'PARTNER.DIRECT_DEBITS_VCB.MSE..38803349523.38803349523-0936734440-DATN10021';
        // // $content = 'MBVCB.3422786007.DATN10020.CT tu 1031217375 TRUONG CONG THACH toi1036752669 NGUYEN LUONG BAO';
        // $tim = strpos($content, "DATN");
        // if (strpos($content, "DATN")) {
        //     $str = substr($content, $tim, 9);
        // }
        // dd($str);
        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $now  = Carbon::today()->format('d/m/Y');
        $link = 'http://api.danangseafood.vn/api';
        $respone = $client->post($link, [
            'body' => json_encode(
                [
                    'begin'           => $now,
                    'end'             => $now,
                    'username'        => '0898174546',
                    'password'        => 'nlBao2k1!',
                    'accountNumber'   => '1036752669'
                ]
            )
        ]);

        $res  = json_decode($respone->getBody()->getContents(), true);
        if ($res['success']) {
            foreach ($res['results'] as $key => $value) {
                $so_tien = str_replace(".", "", $value['Amount']);
                $so_tien = str_replace(",", "", $so_tien);
                if($value['CD'] == '+') {
                    $check = Transaction::where('Reference', $value['Reference'])->first();
                    if(!$check) {
                        $str            =  $value['Description'];
                        $id_don_hang    =  0;
                        $tim   = strpos($str, "DATN");
                        if($tim) {
                            $str = substr($str, $tim, 9);

                            $bill = HoaDon::where('bill_name', $str)->first();
                            if($bill && $bill->bill_total <= $so_tien) {
                                $bill->is_payment = 1;
                                $bill->save();
                                $id_don_hang = $bill->id;
                                $khachHang                  = KhachHang::find($bill->customer_id);
                                $info['email']              = $bill->customer_email;
                                $info['ho_ten']             = $khachHang->ho_ten;
                                $info['dia_chi']            = $khachHang->dia_chi;
                                $info['bill_total']         = $bill->bill_total;
                                $info['bill_name']          = $bill->bill_name;
                                $info['ship_fullname']      = $bill->ship_fullname;
                                $info['ship_phone']         = $bill->ship_phone;
                                $info['ship_address']       = $bill->ship_address;

                                ThanhToanBillJob::dispatch($info);
                            }
                        }
                        Transaction::create([
                            'tranDate'      =>  $value['tranDate'],
                            'Reference'     =>  $value['Reference'],
                            'Amount'        =>  $so_tien,
                            'Description'   =>  $str,
                            'id_don_hang'   =>  $id_don_hang,
                        ]);

                    }
                }
            }
        }
    }
}
