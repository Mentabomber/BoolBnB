@extends('layouts.app')
@section('content')
<head>
    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/maps/maps.css'>
    <link rel='stylesheet' type='text/css' href='../assets/ui-library/index.css'/>
</head>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="text-center">

            <span>Title: {{ $apartment->title }}</span>
            <br>
            @if ($apartment->image)
                <img src="{{ asset('storage/uploads/' . $apartment->image) }}" alt="">
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
            <span>Via:{{ $address->address }}</span>
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
            
            <br>
            <a href="{{ route('welcome') }}">Ritorna alla Home</a>

        </div>
    </div>
    <script src='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/maps/maps-web.min.js'></script>
    <script type='text/javascript' src='../assets/js/mobile-or-tablet.js'></script>
    <script>
        var map = tt.map({
            key: 'tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1',
            container: 'map',
            dragPan: !isMobileOrTablet()
        });
        map.addControl(new tt.FullscreenControl());
        map.addControl(new tt.NavigationControl());
    </script>
@endsection
