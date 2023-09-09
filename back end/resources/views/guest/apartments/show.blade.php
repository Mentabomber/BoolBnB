@extends('layouts.app')
@section('content')
<head>
    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/maps/maps.css'>
    <link rel='stylesheet' type='text/css' href='../assets/ui-library/index.css'/>
    <style>
        .marker-icon {
            background-position: center;
            background-size: 22px 22px;
            border-radius: 50%;
            height: 22px;
            left: 4px;
            position: absolute;
            text-align: center;
            top: 3px;
            transform: rotate(45deg);
            width: 22px;
        }
        .marker {
            height: 30px;
            width: 30px;
        }
        .marker-content {
            background: #c30b82;
            border-radius: 50% 50% 50% 0;
            height: 30px;
            left: 50%;
            margin: -15px 0 0 -15px;
            position: absolute;
            top: 50%;
            transform: rotate(-45deg);
            width: 30px;
        }
        .marker-content::before {
            
            border-radius: 50%;
            content: "";
            height: 24px;
            margin: 3px 0 0 3px;
            position: absolute;
            width: 24px;
        }
    </style>
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
            <div id='map' class='map'>
            <br>
            <a href="{{ route('welcome') }}">Ritorna alla Home</a>
            <input type="hidden" name="latitude" id="resultFieldLA" value="{{$address->latitude}}">
            <input type="hidden" name="longitude" id="resultFieldLO" value="{{$address->longitude}}">

        </div>
    </div>
    <script src='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/maps/maps-web.min.js'></script>
    <script type='text/javascript' src='../assets/js/mobile-or-tablet.js'></script>
    <script>

        var resultFieldLA = document.getElementById('resultFieldLA');
        var resultFieldLO = document.getElementById('resultFieldLO');


        var map = tt.map({
            key: 'tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1',
            container: 'map',
            center: [resultFieldLO.value, resultFieldLA.value],
            zoom: 20,
            dragPan: !isMobileOrTablet()
        });
        map.addControl(new tt.FullscreenControl());
        map.addControl(new tt.NavigationControl());
        function createMarker(position, color, popupText) {
        var markerElement = document.createElement('div');
        markerElement.className = 'marker';
        var markerContentElement = document.createElement('div');
        markerContentElement.className = 'marker-content';
        markerContentElement.style.backgroundColor = color;
        markerElement.appendChild(markerContentElement);
        // var iconElement = document.createElement('div');
        // iconElement.className = 'marker-icon';
        // iconElement.style.backgroundImage =
        //     'url(https://api.tomtom.com/maps-sdk-for-web/cdn/static/' + icon + ')';
        // markerContentElement.appendChild(iconElement);
        var popup = new tt.Popup({offset: 30}).setText(popupText);
        // add marker to map
        new tt.Marker({element: markerElement, anchor: 'bottom'})
            .setLngLat(position)
            .setPopup(popup)
            .addTo(map);
        }
        createMarker([resultFieldLO.value, resultFieldLA.value], '#5327c3', 'SVG icon');
        // nel caso volessimo mettere un'icona all'interno del marker questa è la versiona con l'automobilina
        // createMarker('accident.colors-white.svg', [resultFieldLO.value, resultFieldLA.value], '#5327c3', 'SVG icon');

    </script>
@endsection
