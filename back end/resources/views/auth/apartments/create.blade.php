@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="text-center">

            
            <h1><span>Crea</span> nuovo appartamento</h1>
            <form id="update-form" method="POST" action="{{ route('apartment.store') }}" enctype='multipart/form-data'>

                @csrf
                @method('POST')

                <div class="container text-center">
                    <div class="row">
                       <div class="col-sm-2"><label for="title" class="form-label">Descrizione</label></div>
                    <div class="col-sm-10"><input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="apartment-title" placeholder="Inserisci Descrizione">
                       <span id="title-error" class="invalid-feedback" role="alert"><strong></strong></span></div>
                    </div>
                    <br>
                
                   
                    <div class="row">
                        <div class="col-sm-2">
                         <label for="address" class="form-label">Indirizzo</label>
                        </div>
                        <input type="hidden" name="address" id="resultField">
                        <input type="hidden" name="latitude" id="resultFieldLA">
                        <input type="hidden" name="longitude" id="resultFieldLO">
                        <div class="col-sm-10">
                            <input type="text" name="address" class="form-control @error('indirizzo') is-invalid @enderror" id="searchInput" placeholder="Inserisci Indirizzo">
                            <span id="address-error" class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                     
                        <ul style="list-style-type: none;"id="suggestions"></ul>
                    </div>
                    <br>

                   <div class="row">
                      <div class="col-sm-2"><label for="floor" class="form-label">Piano</label></div>
                      <div class="col-sm-10"><input type="number" name="floor" class="form-control @error('floor')  is-invalid @enderror" id="floor" placeholder="Inserisci Piano" >
                       <span id="floor-error" class="invalid-feedback" role="alert"><strong></strong></span>
                      </div>
                   </div>
                   <br>
                
                   <div class="row">
                     <div class="col-sm-2"><label for="square_meters" class="form-label">Dimensioni</label></div>
                     <div class="col-sm-10"><input type="number" name="square_meters" class="form-control @error('square_meters')  is-invalid @enderror" id="square_meters" placeholder="Inserisci Metri Quadrati" >
                      <span id="square_meters-error" class="invalid-feedback" role="alert"><strong></strong></span>
                     </div>
                    </div>
                    <br>
                
                   <div class="row">
                     <div class="col-sm-2"><label for="rooms" class="form-label">Stanze</label></div>
                     <div class="col-sm-10"><input type="number" name="rooms" class="form-control @error('rooms')  is-invalid @enderror" id="rooms" placeholder="Inserisci Stanze" >
                       <span id="rooms-error" class="invalid-feedback" role="alert"><strong></strong></span>
                     </div>
                    </div>
                    <br>
                
                   <div class="row">
                     <div class="col-sm-2"><label for="beds" class="form-label">Letti</label></div>
                     <div class="col-sm-10"><input type="number" name="beds" class="form-control @error('beds')  is-invalid @enderror" id="beds" placeholder="Inserisci Letti" >
                      <span id="beds-error" class="invalid-feedback" role="alert"><strong></strong></span>
                     </div>
                    </div>
                    <br>
                
                   <div class="row">
                      <div class="col-sm-2"><label for="bathrooms" class="form-label">Bagni</label></div>
                      <div class="col-sm-10"><input type="number" name="bathrooms" class="form-control @error('bathrooms')  is-invalid @enderror" id="bathrooms" placeholder="Inserisci Bagni" >
                          <span id="bathrooms-error" class="invalid-feedback" role="alert"><strong></strong></span>
                      </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                      <div class="col-sm-2"> <label for="image">Immagine</label></div>
                      <div class="col-sm-10"> <input type="file" name="image" id="image">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="visible">Visibilità</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="radio" class="visible"  name="visible" value="1" checked> si 
                            <input type="radio" class="visible"  name="visible" value="0"> no
                        </div>
                    </div>
                    <br>
                    <br>
        
                <label for="">Servizi</label>
                <br>
                @foreach ($services as $service)
                    <div class="form-check mx-auto" style="max-width: 300px">
                        <input class="form-check-input" type="checkbox" value="{{ $service->id }}" name="services[]"
                            id="service{{ $service->id }}">
                        <label class="form-check-label" for="service{{ $service->id }}">
                            {{ $service->name }}
                        </label>
                    </div>
                @endforeach
                <div class="row d-flex justify-content-center my-5">
                    <div class="col-sm-6 ">
                        <button type="button" class="btn btn-primary" id="submit-button">Crea</button>
                    </div>
                </div>
                
                <br>
            </form>
    
            <a id="redirect-button" href="{{ route('dashboard') }}">Torna alla Dashboard</a>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('assets/js/search-bar-update-create.js') }}"></script>
    <script>
       document.addEventListener("DOMContentLoaded", function() {
            const updateForm = document.getElementById("update-form");
            const submitButton = document.getElementById("submit-button");
            const titleField = document.getElementById("apartment-title");
            const addressField = document.getElementById("searchInput");
            const roomsField = document.getElementById("rooms");
            const bedsField = document.getElementById("beds");
            const bathroomsField = document.getElementById("bathrooms");
            const square_metersField = document.getElementById("square_meters");
            const floorField = document.getElementById("floor");

            
            submitButton.addEventListener("click", function() {
                if (validateForm()) {
                    // Se la validazione è riuscita, invia il form
                    updateForm.submit();
                }
            });
            
            function validateForm() {
                console.log(addressField.value, 'address');
                let isValid = true;

                // Validazione del campo "title"
                const titleValue = titleField.value.trim();
                if (titleValue === "") {
                    isValid = false;
                    document.getElementById("title-error").innerHTML = "Il campo 'Descrizione' è obbligatorio.";
                    titleField.classList.add("is-invalid");
                } 
                else if (titleValue.length < 3 || titleValue.length > 64){
                    isValid = false;
                    document.getElementById("title-error").innerHTML = "Il campo 'Descrizione' deve essere contenuto fra 3 e 64 caratteri";
                    titleField.classList.add("is-invalid");
                }
                else {
                    document.getElementById("title-error").innerHTML = "";
                    titleField.classList.remove("is-invalid");
                }

                 // Validazione del campo "indirizzo"
                const addressValue = addressField.value;
                if (addressValue == "" || addressValue == null) {
                    isValid = false;
                    document.getElementById("address-error").innerHTML = "Il campo 'Indirizzo' è obbligatorio.";
                    addressField.classList.add("is-invalid");
                }
                else {
                    document.getElementById("address-error").innerHTML = "";
                    addressField.classList.remove("is-invalid");
                }

                // Validazione del campo "rooms"
                const roomsValue = roomsField.value;
                if (roomsValue === "") {
                    isValid = false;
                    document.getElementById("rooms-error").innerHTML = "Il campo 'Stanze' è obbligatorio.";
                    roomsField.classList.add("is-invalid");
                } 
                else if (roomsValue < 1){
                    isValid = false;
                    document.getElementById("rooms-error").innerHTML = "Il campo 'Stanze' deve essere almeno 1";
                    roomsField.classList.add("is-invalid");
                }
                else {
                    document.getElementById("rooms-error").innerHTML = "";
                    roomsField.classList.remove("is-invalid");
                }

                // Validazione del campo "beds"
                const bedsValue = bedsField.value;
                if (bedsValue === "") {
                    isValid = false;
                    document.getElementById("beds-error").innerHTML = "Il campo 'Letti' è obbligatorio.";
                    bedsField.classList.add("is-invalid");
                } else if (bedsValue < 1) {
                    isValid = false;
                    document.getElementById("beds-error").innerHTML = "Il campo 'Letti' deve essere almeno 1";
                    bedsField.classList.add("is-invalid");
                } else {
                    document.getElementById("beds-error").innerHTML = "";
                    bedsField.classList.remove("is-invalid");
                }

                    // Validazione del campo "bathrooms"
                    const bathroomsValue = bathroomsField.value;
                if (bathroomsValue === "") {
                    isValid = false;
                    document.getElementById("bathrooms-error").innerHTML = "Il campo 'Bagni' è obbligatorio.";
                    bathroomsField.classList.add("is-invalid");
                } else if (bathroomsValue < 1) {
                    isValid = false;
                    document.getElementById("bathrooms-error").innerHTML = "Il campo 'Bagni' deve essere almeno 1";
                    bathroomsField.classList.add("is-invalid");
                } else {
                    document.getElementById("bathrooms-error").innerHTML = "";
                    bathroomsField.classList.remove("is-invalid");
                }

                    // Validazione del campo "square_meters"
                    const square_metersValue = square_metersField.value;
                if (square_metersValue === "") {
                    isValid = false;
                    document.getElementById("square_meters-error").innerHTML = "Il campo 'Metri Quadrati' è obbligatorio.";
                    square_metersField.classList.add("is-invalid");
                } else if (square_metersValue < 1) {
                    isValid = false;
                    document.getElementById("square_meters-error").innerHTML = "Il campo 'Metri Quadrati' deve essere almeno 1";
                    square_metersField.classList.add("is-invalid");
                } else {
                    document.getElementById("square_meters-error").innerHTML = "";
                    square_metersField.classList.remove("is-invalid");
                }

                      // Validazione del campo "floor"
                      const floorValue = floorField.value;
                if (floorValue === "") {
                    isValid = false;
                    document.getElementById("floor-error").innerHTML = "Il campo 'Piano' è obbligatorio.";
                    floorField.classList.add("is-invalid");
                } else if (floorValue < 1) {
                    isValid = false;
                    document.getElementById("floor-error").innerHTML = "Il campo 'Piano' deve essere almeno 1";
                    floorField.classList.add("is-invalid");
                } else {
                    document.getElementById("floor-error").innerHTML = "";
                    floorField.classList.remove("is-invalid");
                }

                return isValid;
            }
        });
    </script>
@endsection

<style>
    .container {
    padding-top: 2rem;
    background-color: #dfdedf;
    padding-bottom: 6rem;
    }

    h1 {
        margin-top: 2rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        
    }

    span {
            color: #15ba8f;
            font-weight: bold;
        }

    label{
        color: black;
        font-weight: bold;
        
    }
    #submit-button{
        background-color: #0D233D;
        padding: 10 40;
        
    }
    #redirect-button{
        font-size: 22px;
        color: #15ba8f;
    }
</style>

