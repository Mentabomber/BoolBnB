@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="text-center">

            <h1>Modifica dettagli Appartamento</h1>
            <form method="POST" action="{{ route('guest.apartments.show', $apartment->id) }}" enctype='multipart/form-data'>

                @csrf
                @method('PUT')

                <label for="title">Descrizione</label>
                <br>
                <input type="text" name="title" id="title" value="{{ $apartment->title }}">
                <br>
                <label for="rooms">Stanze</label>
                <br>
                <input type="number" name="rooms" id="rooms" value="{{ $apartment->rooms }}">
                <br>
                <label for="beds">Letti</label>
                <br>
                <input type="number" name="beds" id="beds" value="{{ $apartment->beds }}">
                <br>
                <label for="bathrooms">Bagni</label>
                <br>
                <input type="number" name="bathrooms" id="bathrooms" value="{{ $apartment->bathrooms }}">
                <br>
                <label for="square_meters">Metri Quadrati</label>
                <br>
                <input type="number" name="square_meters" id="square_meters" value="{{ $apartment->square_meters }}">
                <br>
                <label for="image">Immagine Appartamento</label>
                <img src="{{ asset('storage/uploads/' . $apartment->image) }}" alt="">
                <input type="file" name="image" id="image">
                <br>
                <label for="">Servizi</label>
                <br>
                @foreach ($services as $service)
                    <div class="form-check mx-auto" style="max-width: 300px">
                        <input class="form-check-input" type="checkbox" value="{{ $service->id }}" name="services[]"
                            id="service{{ $service->id }}"
                            @foreach ($apartment->services as $apartmentServices)
                                @checked($apartmentServices -> id === $service -> id) @endforeach>
                        <label class="form-check-label" for="service{{ $service->id }}">
                            {{ $service->name }}
                        </label>
                    </div>
                @endforeach
                <br>
                <h2>Indirizzo</h2>
                <input type="hidden" name="address" id="resultField">
                <input type="hidden" name="latitude" id="resultFieldLA">
                <input type="hidden" name="longitude" id="resultFieldLO">
                <br>
                <label for="address">Indirizzo</label>
                <br>
                <input type="text" name="address" id="searchInput" value="{{ $address->address }}">
                <ul style="list-style-type: none;"id="suggestions"></ul>

                <script>
                    const searchInput = document.getElementById('searchInput');
                    const suggestionsList = document.getElementById('suggestions');
                    console.log(searchInput);

                    searchInput.addEventListener('input', function() {
                        const inputValue = this.value;

                        fetch(
                                `https://api.tomtom.com/search/2/search/${encodeURIComponent(inputValue)}.json?key=tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1&countrySet=IT`
                            )
                            .then(function(response) {
                                return response.json();
                            })
                            .then(function(data) {
                                const addresses = data.results;
                                console.log(addresses);

                                // Rimuovi i suggerimenti precedenti
                                suggestionsList.innerHTML = '';

                                // Mostra gli indirizzi suggeriti nell'autocompletamento
                                addresses.forEach(function(address) {
                                    suggestionsList.style.display = 'block';
                                    const suggestion = document.createElement('li');
                                    suggestion.textContent = address.address.freeformAddress;
                                    const floor = document.getElementById('floor');
                                    const floorLabel = document.getElementById('floor-label');
                                    console.log(addresses.length);
                                    floor.style.display = "none";
                                    floorLabel.style.display = "none";

                                    suggestion.addEventListener('click', function() {
                                        // Aggiungi il valore dell'indirizzo selezionato all'input di ricerca
                                        searchInput.value = address.address.freeformAddress;
                                        const indirizzo = document.getElementById('resultField');
                                        const latitudine = document.getElementById('resultFieldLA');
                                        const longitudine = document.getElementById('resultFieldLO');
                                        floor.style.display = "inline";
                                        floorLabel.style.display = "block";
                                        indirizzo.value = address.address.freeformAddress;
                                        latitudine.value = address.position.lat;
                                        longitudine.value = address.position.lon;
                                        suggestionsList.style.display = 'none';

                                    });

                                    suggestionsList.appendChild(suggestion);
                                });
                            })
                            .catch(function(error) {
                                console.error(error);
                            });
                    });
                </script>
                <label for="floor" id="floor-label" style="display: block;">Piano</label>
                <input type="number" name="floor" id="floor" value="{{ $address->floor }}">
                <br>
                <input class="my-3" type="submit" value="update">

            </form>
            <form class="d-inline" method="POST" action="{{ route('auth.apartments.delete', $apartment->id) }}">

                @csrf
                @method('DELETE')

                <input class="btn btn-primary" type="submit" value="DELETE"
                    onclick="return confirm('Sei sicuro di voler eliminare questo appartamento?')">
            </form>
            <a href="{{ route('dashboard') }}">Torna alla Dashboard</a>
        </div>
    </div>
@endsection
