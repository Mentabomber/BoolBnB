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
    <label for="available-beds">Letti disponibili</label>
    <input type="text" id="available-beds" name="available-beds">
    <br>
    <label for="available-rooms">Stanze Disponibili</label>
    <input type="text" id="available-rooms" name="available-rooms">
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
            <div class="apartment_card" data-apartment="{{ json_encode($apartment) }}" id="{{ $apartment->id }}">
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
        // const submit = document.getElementById("bottoneInvio");
        // submit.addEventListener("click", function() {
        //     const beds = document.getElementById("available-beds");
        //     const rooms = document.getElementById("available-rooms");
        //     const apartmentCards = document.querySelectorAll(".apartment_card");
        //     const apartmentServices = document.querySelectorAll(".apartment_service");

        //     const bedsValue = parseInt(beds.value);
        //     const roomsValue = parseInt(rooms.value);

        //     apartmentCards.forEach(function(apartmentCard) {
        //         const bedsOfApartment = parseInt(apartmentCard.dataset.beds);
        //         const roomsOfApartment = parseInt(apartmentCard.dataset.rooms);

        //         if (!isNaN(bedsValue) && !isNaN(roomsValue)) {
        //             if (!(bedsValue <= bedsOfApartment) || !(roomsValue <= roomsOfApartment)) {
        //                 apartmentCard.classList.add('hidden');
        //             } else {

        //                 apartmentCard.classList.remove('hidden');
        //             }
        //         } else if (!isNaN(bedsValue)) {
        //             if (!(bedsValue <= bedsOfApartment)) {
        //                 apartmentCard.classList.add('hidden');
        //             } else {
        //                 apartmentCard.classList.remove('hidden');
        //             }
        //         } else if (!isNaN(roomsValue)) {
        //             if (!(roomsValue <= roomsOfApartment)) {
        //                 apartmentCard.classList.add('hidden');
        //             } else {
        //                 apartmentCard.classList.remove('hidden');
        //             }
        //         }
        //     });

        //     apartmentServices.forEach(function(apartmentCardService) {
        //         var servicesData = JSON.parse(apartmentCardService.querySelector('ul').dataset.services);
        //         var apartmentService = document.querySelector('.apartment_service');
        //         var ulElement = apartmentService.querySelector('ul');

        //         servicesData.forEach(function(service) {
        //             var apartmentId = ulElement.dataset.apartmentId;
        //             console.log(service.id, apartmentId);
        //         });
        //     });
        // });

        const submit = document.getElementById("bottoneInvio");
        submit.addEventListener("click", function() {
            const beds = document.getElementById("available-beds");
            const rooms = document.getElementById("available-rooms");
            const apartmentCards = document.querySelectorAll(".apartment_card");

            const bedsValue = parseInt(beds.value);
            const roomsValue = parseInt(rooms.value);

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


        });

        function createServiceApartmentRelationship(apartmentId, serviceId) {
            return {
                apartment_id: apartmentId,
                service_id: serviceId,
            };
        };
        var activeCheckboxes = [];
        function handleCheckboxChange(checkbox, id) {
            const apartmentServices = document.querySelectorAll(".apartment_service");
            const apartmentCards = document.querySelectorAll(".apartment_card");

            let apartmentService = [];
            var serviceId = [];
            var apartmentId = [];

            console.log(checkbox);
            if (checkbox.checked) {
                activeCheckboxes.push(id);
                console.log(activeCheckboxes);
                apartmentServices.forEach(function(apartmentCardService) {
                    var servicesData = JSON.parse(apartmentCardService.querySelector('ul').dataset.services);
                    // console.log(servicesData);
                    var ulElement = apartmentCardService.querySelector('ul');
                    // console.log(ulElement);
                    servicesData.forEach(function(service) {
                        apartmentId = ulElement.dataset.apartmentId;
                        serviceId = service.id;

                        const prova = createServiceApartmentRelationship(apartmentId, serviceId);
                        // console.log(prova);
                        apartmentService.push(prova);
                        // console.log(typeof(apartmentService), "2");
                        // console.log(apartmentService);
                        // console.log(serviceId, apartmentId);
                        // console.log(apartmentService, "array con id app e servizio");
                    });
                });

                // apartmentServices.forEach(element => {
                //     if (serviceId !== element["service_id"] && apartmentId !== element["apartment_id"]) {

                //         apartmentCards.forEach(element1 => {
                //             element1.classList.add('hidden');
                //         });
                //     }
                console.log(apartmentService);
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

                var indice = activeCheckboxes.indexOf(elementoDaRimuovere);
                if (indice > -1) {
                    activeCheckboxes.splice(indice, 1);
                }
                console.log(activeCheckboxes);


                // console.log("entro nel secondo else e rimuovo hidden");
                // apartmentCards.forEach(element => {
                //     // se il div ha la classe hidden entro
                //     if (element.classList.contains('hidden')) {
                //         console.log("entro nel primo if");
                //         for (let i = 0; i < apartmentService.length; i++) {
                //                 // se l'id del servizio è diverso dall'id del servizio dell'appartamento e l'id dell'appartamento del div è uguale all'id dell'appartamento entro
                //                 if (!(id === parseInt(apartmentService[i]['service_id']) && parseInt(element.id) ===
                //                         parseInt(apartmentService[i]['apartment_id']))) {
                //                             console.log("entro nel secondo if");
                //                     if (parseInt(element.id) === parseInt(apartmentService[i]['apartment_id']))
                //                         element.classList.add('hidden');
                //                     console.log("entro in if e addo hidden");
                //                 } else {
                //                     console.log("entro nel secondo else e rimuovo hidden");
                //                     element.classList.remove('hidden');
                //                     i += apartmentService.length;

                //                 }
                //         }
                //     }
                //     else{
                //         element.classList.remove('hidden');
                //     }
                // });
            }
        }
    </script>

    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection
