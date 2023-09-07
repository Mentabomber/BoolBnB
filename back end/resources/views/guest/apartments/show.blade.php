@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="text-center">

            <span>Title: {{ $apartment->title }}</span>
            <br>
            @if ($apartment->image)
                <img src="{{ asset('storage/images/' . $apartment->image) }}" alt="">
            @endif
            <br>
            <span>Stanze:{{ $apartment->rooms }}</span>
            <br>
            <span>Letti:{{ $apartment->beds }}</span>
            <br>
            <span>Bagni:{{ $apartment->bathrooms }}</span>
            <br>
            <span>Metri Quadri:{{ $apartment->square_meters }}</span>
            <br>
            <span>Piano:{{ $address->floor }}</span>
            <br>
            <span>Via:{{ $address->street }}</span>
            <br>
            <span>Numero Civico:{{ $address->street_number }}</span>
            <br>
            <span>CAP:{{ $address->cap }}</span>
            <br>
            <span>Città:{{ $address->city }}</span>
            <br>
            <span>Provincia:{{ $address->province }}</span>
            <br>
            <span>Servizi:
                <ul>
                        @foreach ($apartment->services as $service)
                            <li>
                                {{ $service->name }}
                            </li>
                        @endforeach
                </ul>
            </span>
            <br>
            <a href="{{ route('welcome') }}">Ritorna alla Home</a>

        </div>
    </div>
@endsection
