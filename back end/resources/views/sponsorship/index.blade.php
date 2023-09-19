@extends('layouts.app')
@section('content')
<div class="container ">
    <h2 class="titolo text-center"><span class="color-green">Sponsorizza</span> {{$apartment->title}}</h2>
    <h3 class="subtitle text-center">Scegli il <span class="color-green" >piano</span> più adatto alle tue esigenze</h3>

    <form id="payment-form" action="{{ route('process_payment') }}" method="post">
        @csrf
        <div class="form-group">
            <div class="row d-flex justify-content-between">
                @foreach ($sponsorship as $sponsor)
                <div class="card col-md-3 col-sm-5">
                    <h5 class="type">{{ $sponsor->type }}</h5>
                    <div class="info">
                        <p>Piu' visibilita nella ricerca</p>
                        <p>Prezzo: {{ $sponsor->cost }}€</p>
                        <p>Durata: {{ $sponsor->duration }} ore</p>
                    </div>
                    <input class="form-check-input text-center" type="hidden" name="sponsor_id"
                            id="sponsor_{{ $sponsor->id }}" value="{{ $sponsor->id }}" required>
                            <label for=""></label>
                       
                </div>
            @endforeach
            </div>
            
        
            {{-- Errore --}}
            @error('sponsor_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
        
            {{-- Errore --}}
            @error('sponsor_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div id="dropin-wrapper" class="mt-3 text-center my-4 ">
            <div id="checkout-message"></div>
            <div id="dropin-container"></div>
            <input id="nonce" name="payment_method_nonce" type="hidden" />
            <input id="apartment_id" name="apartment_id" type="hidden" value="{{ $apartment->id }}" />

            <button id="submit-button " class="btn btn-primary btn-block" style="background-color: #0D233D">Paga</button>
        </div>

    </form>
</div>

<script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>
<script>
    var form = document.querySelector('#payment-form');
    var client_token = "{{ $token }}";
    var cards = document.querySelectorAll('.card');

    braintree.dropin.create({
        authorization: client_token,
        container: '#dropin-container'
    }, function (createErr, instance) {
        var titolo = document.querySelector(".braintree-sheet__text").innerHTML = "Paga con carta";
        var scadenza = document.querySelector(".braintree-form__flexible-fields > div:nth-child(1) > label:nth-child(1) > div:nth-child(1)").innerHTML = "Scadenza";
        var carta = document.querySelector(".braintree-form__label").innerHTML = "Numero Carta";
        if (createErr) {
            console.error(createErr);
            return;
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    console.error(err);
                    return;
                }

                // Imposta il valore del "payment nonce" nell'input nascosto
                document.querySelector('#nonce').value = payload.nonce;

                // Invia il form al server
                form.submit();
            });
        });

        cards.forEach(function (card) {
            card.addEventListener('click', function () {
                cards.forEach(function (c) {
                    c.classList.remove('selected-card');
                });
                card.classList.add('selected-card');
            });
        });
    });

    
</script>
@endsection

<style scoped>

   

    .card {
        width: 100%;
        max-width: 400px; 
        margin: 0 auto; 
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); 
        text-align: center;
        background-color: #fff;
        padding: 15px;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        cursor: pointer; 
        border: 2px solid #15ba8f;
        font-weight: bolder
    }

    .card:hover {
        box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.3);
    }

    .card.selected-card {
        transform: scale(1.2); 
    }

    .card h5 {
        color: #15ba8f; 
        
    }

    .titolo {
        font-size:5rem;
        margin-bottom: 2rem;
        font-weight: bolder
        
        
    }

   .color-green {
    color:#15ba8f; 
    
   }

   .subtitle {
    margin-bottom: 2rem;
    font-weight: bold
    
   }

   .type {
    font-size: 2.5rem;
    font-weight: bolder;
    margin-bottom: 2rem

   }

   .info {
    font-size: 1.4rem
   }

   #dropin-container {
    width: 60%;
    margin: 0 auto
   }
 
   .braintree-card {
    border: 1px solid #15ba8f
   }

   #submit-button {



   }

   .braintree-form__hosted-field {
    border: 2px solid #15ba8f;
    border-radius: 15px;
    
   }
  
  .braintree-sheet__header {
    border: 1px solid #15ba8f
  }
</style>

