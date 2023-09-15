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
        <input type="text" name="latitude" id="resultFieldLA" value="{{ $latitudeSt }}">
        <input type="text" name="longitude" id="resultFieldLO" value="{{ $longitudeSt }}">
        <br>
        <label for="address">Indirizzo</label>
        <br>
        <input type="text" name="address" id="searchInput" placeholder="Cerca indirizzo">
        <ul style="list-style-type: none;" id="suggestions"></ul>
        <input class="my-3" type="submit" value="Cerca">
    </form>
    <br>


    <div>
        <input class="my-3" type="submit" value="Cerca" id="bottoneInvio" onclick="maxDistanceShowingApartment()">

        @foreach ($apartments as $apartment)
            <div class="apartment_card" data-apartment="{{ json_encode($apartment) }}" id="{{ $apartment->id }}"
                data-beds="{{ $apartment->beds }}" data-rooms="{{ $apartment->rooms }}"
                data-address="{{ json_encode($apartment->address) }}" data-apartment-id="{{ $apartment->id }}"
                data-latitude="{{ json_encode($apartment->latitude) }}"
                data-longitude="{{ json_encode($apartment->longitude) }}">
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
        function maxDistanceShowingApartment() {

            var slider = document.getElementById("myRange");
            var output = document.getElementById("demo");
            output.innerHTML = slider.value;

            // Update the current slider value (each time you drag the slider handle)
            slider.oninput = function() {
                output.innerHTML = this.value;
            }

            let radius = slider.value;
            console.log(radius, 'raggio');


            const latitude = parseFloat(document.getElementById("resultFieldLA").value);
            const longitude = parseFloat(document.getElementById("resultFieldLO").value);

            // console.log(latitude,longitude);
            const apartmentCards = document.querySelectorAll(".apartment_card");
            // console.log(apartmentCards);
            // const apartmentAddress = document.querySelectorAll(".apartment_address");

            apartmentCards.forEach(function(apartmentCardAddress) {

                var latitudeData = apartmentCardAddress.dataset.latitude;
                var longitudeData = apartmentCardAddress.dataset.longitude;

                var latiditeValue = parseFloat(latitudeData.slice(1, -1));
                var longitudeValue = parseFloat(longitudeData.slice(1, -1));

                // let latitudeValue = parseInt(latitudeData);
                // longitudeData = parseFloat(longitudeData);
                console.log(latiditeValue, longitudeValue, 'ciao');
                // var latitudeData = JSON.parse(apartmentCardAddress.querySelector('.long-lat').dataset.latitude);
                // var longitudeData = JSON.parse(apartmentCardAddress.querySelector('.long-lat').dataset.longitude);

                // console.log(typeof(latitudeValue), typeof(longitudeData));
                // console.log(latitudeValue, longitudeData);
                var distance =
                    (6371 * Math.acos(Math.cos(Math.radians(latitude)) *
                        Math.cos(Math.radians(latiditeValue)) *
                        Math.cos(Math.radians(longitudeValue) -
                            Math.radians(longitude)) +
                        Math.sin(Math.radians(latitude)) *
                        Math.sin(Math.radians(latiditeValue))))
                console.log(distance);
                if (distance >= radius) {
                    apartmentCardAddress.classList.add('hidden');
                } else {
                    apartmentCardAddress.classList.remove('hidden');

                }
            });


        }

        function bedsAndRoomsControl() {
            // const beds = document.querySelector('input[name="available.beds"]:checked');
            // const rooms = document.querySelector('input[name="available.rooms"]:checked');
            const apartmentCards = document.querySelectorAll(".apartment_card");


            // Seleziona i radiobutton per il numero di stanze
            const rooms = document.querySelector("input[name='available-rooms']:checked") ?? 0;

            // console.log(rooms, 'prova');

            let roomsValue = 0;
            let bedsValue = 0;

            if (rooms === 0) {
                console.log('sono if di rooms');
                roomsValue = 0;
            } else {
                roomsValue = parseInt(document.querySelector("input[name='available-rooms']:checked").value);
            }

            console.log(roomsValue, 'prova');


            // Seleziona i radiobutton per il numero di letti
            const beds = document.querySelector("input[name='available-beds']:checked") ?? 0;

            if (beds === 0) {
                console.log('sono if di beds');
                bedsValue = 0;
            } else {
                console.log('sono else di beds');
                console.log(parseInt(document.querySelector("input[name='available-beds']:checked").value));
                bedsValue = parseInt(document.querySelector("input[name='available-beds']:checked").value);
                console.log(bedsValue, 'valore selezionato');
            }

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
        // const submit = document.getElementById("bottoneInvio");
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
            } else {
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
                maxDistanceShowingApartment();
            }
        }
    </script>

    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection
