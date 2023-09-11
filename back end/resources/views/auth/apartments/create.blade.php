@extends('layouts.app')
@section('content')
<script src="../../../public/assets/js/main.js"></script>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="text-center">

            <h1>Aggiungi nuov Appartamento</h1>
            <form method="POST" action="{{ route('apartment.store') }}" enctype='multipart/form-data'>

                @csrf
                @method('POST')

                <label for="title">Descrizione</label>
                <br>
                <input type="text" name="title" id="title">
                <br>
                <label for="rooms">Stanze</label>
                <br>
                <input type="number" name="rooms" id="rooms">
                <br>
                <label for="beds">Letti</label>
                <br>
                <input type="number" name="beds" id="beds">
                <br>
                <label for="bathrooms">Bagni</label>
                <br>
                <input type="number" name="bathrooms" id="bathrooms">
                <br>
                <label for="square_meters">Metri Quadrati</label>
                <br>
                <input type="number" name="square_meters" id="square_meters">
                <br>
                <label for="image">Immagine Appartamento</label>
                <input type="file" name="image" id="image">
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
                <br>
                <h2>Indirizzo</h2>
                <input type="hidden" name="address" id="resultField">
                <input type="hidden" name="latitude" id="resultFieldLA">
                <input type="hidden" name="longitude" id="resultFieldLO">
                <br>
                <label for="address">Indirizzo</label>
                <br>
                <input type="text" name="address" id="searchInput" placeholder="Cerca indirizzo">
                <ul style="list-style-type: none;"id="suggestions"></ul>

              
                <label for="floor" id="floor-label" style="display: block;">Piano</label>
                <input type="number" name="floor" id="floor">
                <br>

                <input class="my-3" type="submit" value="create">
            </form>
            <a href="{{ route('dashboard') }}">Torna alla Dashboard</a>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('assets/js/search-bar-update-create.js') }}"></script>
@endsection
