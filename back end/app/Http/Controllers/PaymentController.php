<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Braintree\Gateway;
use Illuminate\Support\Facades\Http;
use App\Models\Sponsorship; 
use App\Models\Apartment;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $paymentMethod = "creditCard";
        $sponsorshipId = $request->input('sponsor_id');
        $sponsorship = sponsorship::find($sponsorshipId);
       
        // $apartment = Apartment::find($apartmentId);
        $nonce = $request->payment_method_nonce;
        $cost = $sponsorship->cost;

        // Effettua il pagamento utilizzando Braintree
        $gateway = new Gateway([
            "environment" => env("BRAINTREE_ENVIRONMENT"),
            "merchantId" => env("BRAINTREE_MERCHANT_ID"),
            "publicKey" => env("BRAINTREE_PUBLIC_KEY"),
            "privateKey" => env("BRAINTREE_PRIVATE_KEY"),
        ]);

        // Gestisci il pagamento in base al metodo selezionato
        
            // Elabora la transazione con carta di credito
            $result = $gateway->transaction()->sale([
                'amount' => $cost,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true,
                   
                ],

                
             
            ]);

            $data = $request -> all();
            
           
            if ($result->success) {
                
                 $nowDate = Carbon::now()->toDateString();
                 $nowDateParse = Carbon::parse($nowDate);
                 $sponsorship = Sponsorship::findOrFail($data['sponsor_id']);
                 $apartment = Apartment :: findOrFail($data['apartment_id']);

                 
            if ($data['sponsor_id']== 1) {
                $endDate = $nowDateParse -> copy() -> addDays(1);
            } else if ($data['sponsor_id'] == 2) {
                $endDate = $nowDateParse -> copy() -> addDays(3);
            } else if ($data['sponsor_id'] == 3) {
                $endDate = $nowDateParse -> copy() -> addDays(6);
            }
                 $apartment -> sponsorships() -> attach($sponsorship, ['start_date'=> $nowDate, 'end_date' => $endDate]);
    
                }
            

                
            
        
}


}