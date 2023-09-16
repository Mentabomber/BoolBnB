<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Braintree\Gateway;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createTransaction(Request $request)
    {
        // Codice per la transazione di Braintree
        $gateway = new Gateway([
            "environment" => env("BRAINTREE_ENVIRONMENT"),
            "merchantId" => env("BRAINTREE_MERCHANT_ID"),
            "publicKey" => env("BRAINTREE_PUBLIC_KEY"),
            "privateKey" => env("BRAINTREE_PRIVATE_KEY"),
        ]);
        $result = $gateway->transaction()->sale([
            'amount' => '10.00',
            'paymentMethodNonce' => 'fake-valid-nonce',
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        // Passa il risultato alla vista
        return view('sponsorship.payment', ['result' => $result]);
    }
}


