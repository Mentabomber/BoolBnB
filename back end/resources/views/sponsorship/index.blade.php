@extends('layouts.app')
@section('content')
    <div class="container">
        <form id="payment-form" action="{{ route('process_payment') }}" method="post" class="col-12 col-lg-6 mx-auto">
            @csrf
            <div class="card mb-3" style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">
                <div class="card-body">
                    <h2 class="card-title">Acquista una sponsorizzazione</h2>

                    <div class="form-group">
                        <label for="sponsor_id">Scegli un pacchetto:</label><br>
                        @foreach ($sponsorship as $sponsor)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sponsor_id"
                                    id="sponsor_{{ $sponsor->id }}" value="{{ $sponsor->id }}" required>
                                <label class="form-check-label" for="sponsor_{{ $sponsor->id }}">
                                    {{ $sponsor->name }} (Prezzo: {{ $sponsor->cost }}€, Durata:
                                    {{ $sponsor->duration }}
                                    ore)
                                </label>
                            </div>
                        @endforeach

                        {{-- Errore --}}
                        @error('sponsor_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="dropin-wrapper" class="mt-3">
                        <div id="checkout-message"></div>
                        <div id="dropin-container"></div>
                        <input id="nonce" name="payment_method_nonce" type="hidden" />
                        <input id="apartment_id" name="apartment_id" type="hidden" value="{{ $apartment->id }}" />

                        <button id="submit-button" class="btn btn-primary btn-block">Paga</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "{{ $token }}";
        //funzione usata per far sparire il tasto paga al momento del successo
        function block_none() {
            console.log("ciao");
            document.getElementById('submit-button').classList.add('hide');
        }
       

        braintree.dropin.create({
            authorization: client_token,
            container: '#dropin-container'
        }, function(createErr, instance) {
            if (createErr) {
                console.error(createErr);
                return;
            }

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        console.error(err);
                        return;
                    }

                    // Imposta il valore del "payment nonce" nell'input nascosto
                    document.querySelector('#nonce').value = payload.nonce;

                    // Invia il form al server
                    form.submit();
                    block_none();
                });
            });
        });
    </script>
    <style>
        .hide{
            display: none;
        }
    </style>
@endsection
