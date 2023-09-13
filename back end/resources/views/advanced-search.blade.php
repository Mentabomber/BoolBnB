@extends('layouts.app')
@section('content')
    <h1 class="display-5 fw-bold">
        Ricerca Avanzata
    </h1>
    <form method="POST" action="{{ route('apartment.search') }}" enctype='multipart/form-data'>
        @csrf
        @method('POST')
        <br>
        <input type="hidden" name="address" id="resultField">
        <input type="hidden" name="latitude" id="resultFieldLA">
        <input type="hidden" name="longitude" id="resultFieldLO">
        <br>
        <label for="address">Indirizzo</label>
        <br>
        <input type="text" name="address" id="searchInput" placeholder="Cerca indirizzo">
        <ul style="list-style-type: none;" id="suggestions"></ul>
        <input class="my-3" type="submit" value="Cerca">
    </form>
    <br>

    <label for="km-radius">Raggio Kilometri</label>
    <input type="text" id="km-radius" name="km-radius">
    <br>
    <h3>Letti disponibili</h3>
    <br><input type="radio" class="available-beds" onchange="bedsAndRoomsControl()" name="available-beds" value="1" checked>
    <label for="1">1</label>
    <br><input type="radio" class="available-beds" onchange="bedsAndRoomsControl()" name="available-beds" value="2">
    <label for="2">2</label>
    <br><input type="radio" class="available-beds" onchange="bedsAndRoomsControl()" name="available-beds" value="3">
    <label for="3">3</label>
    <br><input type="radio" class="available-beds" onchange="bedsAndRoomsControl()" name="available-beds" value="4">
    <label for="4">4</label>
    <br><input type="radio" class="available-beds" onchange="bedsAndRoomsControl()" name="available-beds" value="5">
    <label for="5">5+</label>
    <br>
    <h3>Stanze Disponibili</h3>
    <br><input type="radio" class="available-rooms"  onchange="bedsAndRoomsControl()" name="available-rooms" value="1" checked>
    <label for="1">1</label>
    <br><input type="radio" class="available-rooms"  onchange="bedsAndRoomsControl()" name="available-rooms" value="2">
    <label for="2">2</label>
    <br><input type="radio" class="available-rooms"  onchange="bedsAndRoomsControl()" name="available-rooms" value="3">
    <label for="3">3</label>
    <br><input type="radio" class="available-rooms"  onchange="bedsAndRoomsControl()" name="available-rooms" value="4">
    <label for="4">4</label>
    <br><input type="radio" class="available-rooms"  onchange="bedsAndRoomsControl()" name="available-rooms" value="5">
    <label for="5">5+</label>
    <br>
    <br>

    <h3>Servizi Disponibili</h3>
    @foreach ($services as $service)
        <div class="form-check" style="max-width: 300px">
            <input class="form-check-input" type="checkbox" value="{{ $service->id }}" name="services[]"
                id="service{{ $service->id }}" onchange="handleCheckboxChange(this, {{ $service->id }})">


            <label class="form-check-label" for="service{{ $service->id }}">
                {{ $service->name }}
            </label>
        </div>
    @endforeach
    <br>
    <div>
        <input class="my-3" type="submit" value="Cerca" id="bottoneInvio">

        @foreach ($apartments as $apartment)
            <div class="apartment_card" data-apartment="{{ json_encode($apartment) }}" id="{{ $apartment->id }}" data-beds="{{ $apartment->beds }}" data-rooms="{{ $apartment->rooms }}">
                <a href="{{ route('guest.apartments.show', $apartment->id) }}">{{ $apartment->title }}</a>
                <br>
                <img src="{{ asset('storage/uploads/' . $apartment->image) }}" alt="">
            </div>

            <div class="apartment_service">
                <ul data-services="{{ json_encode($apartment->services) }}" data-apartment-id="{{ $apartment->id }}"
                    id="{{ $apartment->id }}">
                    @foreach ($apartment->services as $service)
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="content">
        <div class="container">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempora temporibus, dicta nemo aliquam totam nisi
                deserunt soluta quas voluptatum ab beatae praesentium necessitatibus minus, facilis illum rerum officiis
                accusamus dolores!</p>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/search-bar.js') }}"></script>
    <script>
        function bedsAndRoomsControl(){
            // const beds = document.querySelector('input[name="available.beds"]:checked');
            // const rooms = document.querySelector('input[name="available.rooms"]:checked');
            const apartmentCards = document.querySelectorAll(".apartment_card");


            // Seleziona i radiobutton per il numero di stanze
            const roomsValue = parseInt(document.querySelector("input[name='available-rooms']:checked").value);


            // Seleziona i radiobutton per il numero di letti
            const bedsValue = parseInt(document.querySelector("input[name='available-beds']:checked").value);
   

            // Stampa i valori
            console.log(roomsValue, bedsValue);

            apartmentCards.forEach(function(apartmentCard) {
                const bedsOfApartment = parseInt(apartmentCard.dataset.beds);
                const roomsOfApartment = parseInt(apartmentCard.dataset.rooms);

                if (!isNaN(bedsValue) && !isNaN(roomsValue)) {
                    if (!(bedsValue <= bedsOfApartment) || !(roomsValue <= roomsOfApartment)) {
                        apartmentCard.classList.add('hidden');
                    } else {
                        apartmentCard.classList.remove('hidden');
                    }
                } else if (!isNaN(bedsValue)) {
                    if (!(bedsValue <= bedsOfApartment)) {
                        apartmentCard.classList.add('hidden');
                    } else {
                        apartmentCard.classList.remove('hidden');
                    }
                } else if (!isNaN(roomsValue)) {
                    if (!(roomsValue <= roomsOfApartment)) {
                        apartmentCard.classList.add('hidden');
                    } else {
                        apartmentCard.classList.remove('hidden');
                    }
                }
            });


        }
        const submit = document.getElementById("bottoneInvio");
        // submit.addEventListener("click", () => {
        //     bedsAndRoomsControl();
        //     handleCheckboxChange(checkbox, id);
        // });
        
        function createServiceApartmentRelationship(apartmentId, serviceId) {
            return {
                apartment_id: apartmentId,
                service_id: serviceId,
            };
        };
        let apartmentServiceProva = [];
        var serviceIdProva = [];
        var apartmentIdProva = [];
        const apartmentServicesProva = document.querySelectorAll(".apartment_service");
        apartmentServicesProva.forEach(function(apartmentCardService) {
                    var servicesDataProva = JSON.parse(apartmentCardService.querySelector('ul').dataset.services);
                  
                    var ulElementProva = apartmentCardService.querySelector('ul');
                 
                    servicesDataProva.forEach(function(service) {
                        apartmentIdProva = ulElementProva.dataset.apartmentId;
                        serviceIdProva = service.id;
                        // console.log(ulElementProva.dataset.apartmentId);
                        // console.log(apartmentIdProva, "id appartamento" , serviceIdProva, "id servizio");
                        const provaProva = createServiceApartmentRelationship(apartmentIdProva, serviceIdProva);
                        
                        apartmentServiceProva.push(provaProva);
                        // console.log(apartmentServiceProva);
                      
                    });
                });


        var activeCheckboxes = [];
        function handleCheckboxChange(checkbox, id) {
            const apartmentServices = document.querySelectorAll(".apartment_service");
            const apartmentCards = document.querySelectorAll(".apartment_card");

            let apartmentService = [];
            var serviceId = [];
            var apartmentId = [];
            
            if (checkbox.checked) {
                activeCheckboxes.push(id);
                console.log(activeCheckboxes);
                apartmentServices.forEach(function(apartmentCardService) {
                    var servicesData = JSON.parse(apartmentCardService.querySelector('ul').dataset.services);
                  
                    var ulElement = apartmentCardService.querySelector('ul');
                 
                    servicesData.forEach(function(service) {
                        apartmentId = ulElement.dataset.apartmentId;
                        serviceId = service.id;

                        const prova = createServiceApartmentRelationship(apartmentId, serviceId);
                        
                        apartmentService.push(prova);
                        // console.log(apartmentService, "APARTMENT SERVICE dentro if");
                      
                    });
                });

                // apartmentServices.forEach(element => {
                //     if (serviceId !== element["service_id"] && apartmentId !== element["apartment_id"]) {

                //         apartmentCards.forEach(element1 => {
                //             element1.classList.add('hidden');
                //         });
                //     }
                apartmentCards.forEach(element => {
                    // se l'elemento non ha classe hidden entro
                    if (!(element.classList.contains('hidden'))) {
                        //
                        for (let i = 0; i < apartmentService.length; i++) {
                                // se l'id del servizio è diverso dall'id del servizio dell'appartamento e l'id dell'appartamento del div è uguale all'id dell'appartamento entro
                                if (!(id === parseInt(apartmentService[i]['service_id']) && parseInt(element.id) ===
                                        parseInt(apartmentService[i]['apartment_id']))) {
                                    if (parseInt(element.id) === parseInt(apartmentService[i]['apartment_id']))
                                        element.classList.add('hidden');
                                } else {
                                    element.classList.remove('hidden');
                                    i += apartmentService.length;

                                }


                        }
                    }
                });
            }
            else {
                var elementoDaRimuovere = id;
                let selectedElementApId; 
                var indice = activeCheckboxes.indexOf(elementoDaRimuovere);
                if (indice > -1) {
                    activeCheckboxes.splice(indice, 1);
                }
                console.log(activeCheckboxes, "active checkboxes");
                // console.log(apartmentCards, "apartmentCards");
                let confrontServices = [];
                apartmentCards.forEach(element => {
                    // controllo se il div contenente i dati degli appartamenti ha la classe hidden
                    if ((element.classList.contains('hidden'))) {
                        // metto l'id dell'appartamento con classe hidden dentro la variabile selectedElementApId
                        selectedElementApId = element.id;
                        // console.log(selectedElementApId, "selectedElementApId");
                        confrontServices = [];
                        //ciclo con la lunghezza dell'array che contiene tutti gli appartamenti in risultato con la ricerca iniziale
                        for (let i = 0; i < apartmentServiceProva.length; i++) {
                            // controllo se l'id dell'appartamento selezionato in principio combacia con un id all'interno dell'array di tutti gli appartamenti ricercati in pagina 
                            if (selectedElementApId === apartmentServiceProva[i]['apartment_id']) {
                                // estraggo il numero del servizio corelato all'appartamento e lo metto in idContainer
                                let idContainer = apartmentServiceProva[i]['service_id'];
                                // pusho l'id dentro all'array che 
                                console.log(confrontServices, "confrontServices");
                                confrontServices.push(idContainer);
                                
                            }

                        }
                        
                        console.log(confrontServices, "array confrontServices");
                    }
                    console.log(confrontServices, "fuori");
                    if (activeCheckboxes.every(item => confrontServices.includes(item))) {
                        
                                element.classList.remove('hidden');
                    }  
                });
                bedsAndRoomsControl();
            }
        }
    </script>

    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection
