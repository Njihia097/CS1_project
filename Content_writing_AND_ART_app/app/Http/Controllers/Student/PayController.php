<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mpesa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cart;

class PayController extends Controller
{
    public function stk()
    {
        $mpesa = new \Safaricom\Mpesa\Mpesa();

        $BusinessShortCode = 174379;
        $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = '1';
        $PartyA = '254769986556'; // replace this with your phone number
        $PartyB = 174379;
        $PhoneNumber = '254769986556'; // replace this with your phone number
        $CallBackURL = 'https://837d-41-90-181-79.ngrok-free.app/mpesa/confirmation'; // Ensure no spaces
        $AccountReference = 'Laravel Mpesa';
        $TransactionDesc = 'Laravel Mpesa STK PUSH';
        $Remarks = 'Laravel Mpesa STK PUSH';

        // Log the callback URL to ensure it is correct
        Log::info('Callback URL: ' . $CallBackURL);

        $stkPushSimulation = $mpesa->STKPushSimulation(
            $BusinessShortCode,
            $LipaNaMpesaPasskey,
            $TransactionType,
            $Amount,
            $PartyA,
            $PartyB,
            $PhoneNumber,
            $CallBackURL,
            $AccountReference,
            $TransactionDesc,
            $Remarks
        );

        // Log the response from the STK Push Simulation
        Log::info('STK Push Simulation Response: ', (array) $stkPushSimulation);

        dd($stkPushSimulation);
    }

    public function confirmation(Request $request)
    {
        // Handle the Mpesa confirmation data here
        Log::info('Mpesa confirmation received:', $request->all());
        return response()->json(['message' => 'Callback received']);
    }

    public function mpesapay(){
        $user = Auth::user();
        $totalprice = Cart::where('user_id', $user->id)->sum('price');
        return view('home.mpesa', compact('user', 'totalprice'));
    }

   
}
