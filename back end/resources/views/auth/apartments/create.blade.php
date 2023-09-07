@extends('layouts.app')
@section('content')
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
                <label for="street">Via / Località</label>
                <br>
                <input type="text" name="street" id="street">
                <br>
                <label for="street_number">Numero Civico</label>
                <br>
                <input type="number" name="street_number" id="street_number">
                <br>
                <label for="cap">CAP</label>
                <br>
                <input type="number" name="cap" id="cap">
                <br>
                <label for="city">Città</label>
                <br>
                <input type="text" name="city" id="city">
                <br>
                <label for="province">Provincia</label>
                <br>
                <input type="text" name="province" id="province">
                <br>
                <label for="floor">Piano</label>
                <br>
                <input type="number" name="floor" id="floor">
                <br>

                <input class="my-3" type="submit" value="create">
            </form>
            <a href="">Back to Dashboard</a>
        </div>
    </div>
@endsection
