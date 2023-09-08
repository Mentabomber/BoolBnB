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


                <label for="address">Indirizzo</label>
                <br>
                <input type="text" name="address" id="address" value="{{ $address->street }}">
                <br>


                <!-- <label for="street">Via / Località</label>
                <br>
                <input type="text" name="street" id="street" value="{{ $address->street }}">
                <br>
                <label for="street_number">Numero Civico</label>
                <br>
                <input type="number" name="street_number" id="street_number" value="{{ $address->street_number }}">
                <br>
                <label for="cap">CAP</label>
                <br>
                <input type="number" name="cap" id="cap" value="{{ $address->cap }}">
                <br>
                <label for="city">Città</label>
                <br>
                <input type="text" name="city" id="city" value="{{ $address->city }}">
                <br>
                <label for="province">Provincia</label>
                <br>
                <input type="text" name="province" id="province" value="{{ $address->province }}">
                <br> -->
                <label for="floor">Piano</label>
                <br>
                <input type="number" name="floor" id="floor" value="{{ $address->floor }}">
                <br>

                <input class="my-3" type="submit" value="update">

            </form>
            <form
            class="d-inline"
            method="POST"
            action="{{ route('auth.apartments.delete', $apartment -> id) }}"
            >

            @csrf
            @method("DELETE")

            <input class="btn btn-primary" type="submit" value="DELETE" onclick="return confirm('Sei sicuro di voler eliminare questo appartamento?')">
            </form>
            <a href="{{ route('dashboard') }}">Torna alla Dashboard</a>
        </div>
    </div>
@endsection
