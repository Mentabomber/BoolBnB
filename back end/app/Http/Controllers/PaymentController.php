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
        $gateway = new BraintreeGateway([
            "environment" => env("BRAINTREE_ENVIRONMENT"),
            "merchantId" => env("BRAINTREE_MERCHANT_ID"),
            "publicKey" => env("BRAINTREE_PUBLIC_KEY"),
            "privateKey" => env("BRAINTREE_PRIVATE_KEY"),
        ]);
        $token = $gateway->ClientToken()->generate();
}

}