@extends('layouts.app')
@section('content')

<h1 class="display-5 fw-bold">
    Ricerca Avanzata
</h1>
<br>
<form method="POST" action="{{ route('apartment.advanced-search') }}" enctype='multipart/form-data'>
@csrf
@method('POST')

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
                id="service{{ $service->id }}">
            
            <label class="form-check-label" for="service{{ $service->id }}">
                {{ $service->name }}
            </label>
        </div>
    @endforeach
    <br>
    <div>
    <input class="my-3" type="submit" value="Cerca">
</form>
    @foreach($apartments as $apartment)
        <div>
            <a href="{{ route('guest.apartments.show', $apartment->id) }}">{{ $apartment->title }}</a>
            <br>
            <img src="{{ asset('storage/uploads/' . $apartment->image) }}" alt="">
        </div>
    @endforeach
</div>

<div class="content">
    <div class="container">
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempora temporibus, dicta nemo aliquam totam nisi deserunt soluta quas voluptatum ab beatae praesentium necessitatibus minus, facilis illum rerum officiis accusamus dolores!</p>
    </div>
</div>
<script type="text/javascript" src="{{ asset('assets/js/search-bar.js') }}"></script>
@endsection
