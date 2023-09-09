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

                <label for="address">Indirizzo</label>
                <br>
                {{-- <input type="text" name="address" id="address" value="{{ $address->street }}"> --}}
                <input type="hidden" name="address" id="resultField">
                <input type="hidden" name="latitude" id="resultFieldLA">
                <input type="hidden" name="longitude" id="resultFieldLO">
                <br>

                {{-- <label for="address">Indirizzo</label>
                <br>
                <input type="text" name="address" id="address">
                <br> --}}

                <!-- <label for="street">Via / Località</label>
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
                    <br> -->
                <label for="floor">Piano</label>
                <br>
                <input type="number" name="floor" id="floor">
                <br>

                <input class="my-3" type="submit" value="create">
            </form>
            <a href="{{ route('dashboard') }}">Torna alla Dashboard</a>
            <div>
                <div class='map-view'>
                    <div class='tt-side-panel'>
                        <header class='tt-side-panel__header'>
                        </header>
                        <div class='tt-tabs js-tabs'>
                            <div class='tt-tabs__panel'>
                                <div class='js-results' hidden='hidden'></div>
                                <div class='js-results-loader' hidden='hidden'>
                                    <div class='loader-center'><span class='loader'></span></div>
                                </div>
                                <div class='tt-tabs__placeholder js-results-placeholder'></div>
                            </div>
                        </div>
                    </div>
                    <div id='map' class='map' style=""></div>
                </div>

                <script>
                    tt.setProductInfo('[BoolBnB]', '[6]');

                    var selectedResult = [];


                    var map = tt.map({
                        key: 'tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1',
                        container: 'map',
                        center: [15.4, 53.0],
                        zoom: 3,
                        dragPan: !window.isMobileOrTablet()
                    });

                    var infoHint = new InfoHint('info', 'bottom-center', 5000).addTo(document.getElementById('map'));
                    var errorHint = new InfoHint('error', 'bottom-center', 5000).addTo(document.getElementById('map'));

                    // Options for the fuzzySearch service
                    var searchOptions = {
                        key: 'tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1',
                        language: 'it-IT',
                        limit: 5
                    };

                    // Options for the autocomplete service
                    var autocompleteOptions = {
                        key: 'tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1',
                        language: 'it-IT'
                    };

                    var searchBoxOptions = {
                        minNumberOfCharacters: 0,
                        searchOptions: searchOptions,
                        autocompleteOptions: autocompleteOptions,
                        distanceFromPoint: [15.4, 53.0]
                    };
                    var ttSearchBox = new tt.plugins.SearchBox(tt.services, searchBoxOptions);
                    document.querySelector('.tt-side-panel__header').appendChild(ttSearchBox.getSearchBoxHTML());

                    var state = {
                        previousOptions: {
                            query: null,
                            center: null
                        },
                        callbackId: null,
                        userLocation: null
                    };

                    // map.addControl(new tt.FullscreenControl({
                    //     container: document.querySelector('body')
                    // }));
                    map.addControl(new tt.NavigationControl());
                    new SidePanel('.tt-side-panel', map);

                    var geolocateControl = new tt.GeolocateControl({
                        positionOptions: {
                            enableHighAccuracy: false
                        }
                    });

                    geolocateControl.on('geolocate', function(event) {
                        var coordinates = event.coords;
                        state.userLocation = [coordinates.longitude, coordinates.latitude];
                        ttSearchBox.updateOptions(Object.assign({}, ttSearchBox.getOptions(), {
                            distanceFromPoint: state.userLocation
                        }));
                    });

                    map.addControl(geolocateControl);

                    var resultsManager = new ResultsManager();
                    var searchMarkersManager = new SearchMarkersManager(map);

                    map.on('load', handleMapEvent);
                    map.on('moveend', handleMapEvent);

                    ttSearchBox.on('tomtom.searchbox.resultscleared', handleResultsCleared);
                    ttSearchBox.on('tomtom.searchbox.resultsfound', handleResultsFound);
                    ttSearchBox.on('tomtom.searchbox.resultfocused', handleResultSelection);
                    ttSearchBox.on('tomtom.searchbox.resultselected', handleResultSelection);

                    function handleMapEvent() {
                        // Update search options to provide geobiasing based on current map center
                        var oldSearchOptions = ttSearchBox.getOptions().searchOptions;
                        var oldautocompleteOptions = ttSearchBox.getOptions().autocompleteOptions;
                        var newSearchOptions = Object.assign({}, oldSearchOptions, {
                            center: map.getCenter()
                        });
                        var newAutocompleteOptions = Object.assign({}, oldautocompleteOptions, {
                            center: map.getCenter()
                        });
                        ttSearchBox.updateOptions(Object.assign({}, searchBoxOptions, {
                            placeholder: 'Query e.g. Washington',
                            searchOptions: newSearchOptions,
                            autocompleteOptions: newAutocompleteOptions,
                            distanceFromPoint: state.userLocation
                        }));
                    }

                    function handleResultsCleared() {
                        searchMarkersManager.clear();
                        resultsManager.clear();
                    }

                    function handleResultsFound(event) {
                        // Display fuzzySearch results if request was triggered by pressing enter
                        if (event.data.results && event.data.results.fuzzySearch && event.data.metadata.triggeredBy === 'submit') {
                            var results = event.data.results.fuzzySearch.results;

                            if (results.length === 0) {
                                handleNoResults();
                            }
                            searchMarkersManager.draw(results);
                            resultsManager.success();
                            fillResultsList(results);
                            fitToViewport(results);
                        }

                        if (event.data.errors) {
                            errorHint.setMessage('There was an error returned by the service.');
                        }
                    }

                    function handleResultSelection(event) {
                        if (isFuzzySearchResult(event)) {
                            // Display selected result on the map
                            var result = event.data.result;
                            console.log(result);
                            var resultField = document.getElementById('resultField');
                            resultField.value = JSON.stringify(result["address"]["freeformAddress"]);
                            var resultFieldLA = document.getElementById('resultFieldLA');
                            resultFieldLA.value = JSON.stringify(result["position"]["lat"]);
                            var resultFieldLO = document.getElementById('resultFieldLO');
                            resultFieldLO.value = JSON.stringify(result["position"]["lng"]);
                            selectedResult = result;
                            resultsManager.success();
                            searchMarkersManager.draw([result]);
                            fillResultsList([result]);
                            searchMarkersManager.openPopup(result.id);
                            fitToViewport(result);
                            state.callbackId = null;
                            infoHint.hide();

                        } else if (stateChangedSinceLastCall(event)) {
                            var currentCallbackId = Math.random().toString(36).substring(2, 9);
                            state.callbackId = currentCallbackId;
                            // Make fuzzySearch call with selected autocomplete result as filter
                            handleFuzzyCallForSegment(event, currentCallbackId);
                        }
                    }

                    function isFuzzySearchResult(event) {
                        return !('matches' in event.data.result);
                    }

                    function stateChangedSinceLastCall(event) {
                        return Object.keys(searchMarkersManager.getMarkers()).length === 0 || !(
                            state.previousOptions.query === event.data.result.value &&
                            state.previousOptions.center.toString() === map.getCenter().toString());
                    }

                    function getBounds(data) {
                        var southWest;
                        var northEast;
                        if (data.viewport) {
                            southWest = [data.viewport.topLeftPoint.lng, data.viewport.btmRightPoint.lat];
                            northEast = [data.viewport.btmRightPoint.lng, data.viewport.topLeftPoint.lat];
                        }
                        return [southWest, northEast];
                    }

                    function fitToViewport(markerData) {
                        if (!markerData || markerData instanceof Array && !markerData.length) {
                            return;
                        }
                        var bounds = new tt.LngLatBounds();
                        if (markerData instanceof Array) {
                            markerData.forEach(function(marker) {
                                bounds.extend(getBounds(marker));
                            });
                        } else {
                            bounds.extend(getBounds(markerData));
                        }
                        map.fitBounds(bounds, {
                            padding: 100,
                            linear: true
                        });
                    }

                    function handleFuzzyCallForSegment(event, currentCallbackId) {
                        var query = ttSearchBox.getValue();
                        var segmentType = event.data.result.type;

                        var commonOptions = Object.assign({}, searchOptions, {
                            query: query,
                            limit: 15,
                            center: map.getCenter(),
                            typeahead: true,
                            language: 'it-IT'
                        });

                        var filter;
                        if (segmentType === 'category') {
                            filter = {
                                categorySet: event.data.result.id
                            };
                        }
                        if (segmentType === 'brand') {
                            filter = {
                                brandSet: event.data.result.value
                            };
                        }
                        var options = Object.assign({}, commonOptions, filter);

                        infoHint.setMessage('Loading results...');
                        errorHint.hide();
                        resultsManager.loading();
                        tt.services.fuzzySearch(options)
                            .then(function(response) {
                                if (state.callbackId !== currentCallbackId) {
                                    return;
                                }
                                if (response.results.length === 0) {
                                    handleNoResults();
                                    return;
                                }
                                resultsManager.success();
                                searchMarkersManager.draw(response.results);
                                fillResultsList(response.results);
                                map.once('moveend', function() {
                                    state.previousOptions = {
                                        query: query,
                                        center: map.getCenter()
                                    };
                                });
                                fitToViewport(response.results);
                            })
                            .catch(function(error) {
                                if (error.data && error.data.errorText) {
                                    errorHint.setMessage(error.data.errorText);
                                }
                                resultsManager.resultsNotFound();
                            })
                            .finally(function() {
                                infoHint.hide();
                            });
                    }

                    function handleNoResults() {
                        resultsManager.clear();
                        resultsManager.resultsNotFound();
                        searchMarkersManager.clear();
                        infoHint.setMessage(
                            'No results for "' +
                            ttSearchBox.getValue() +
                            '" found nearby. Try changing the viewport.'
                        );
                    }

                    function fillResultsList(results) {
                        resultsManager.clear();
                        var resultList = DomHelpers.createResultList();
                        results.forEach(function(result) {
                            var distance = state.userLocation ? SearchResultsParser.getResultDistance(result) : undefined;
                            var addressLines = SearchResultsParser.getAddressLines(result);
                            var searchResult = this.DomHelpers.createSearchResult(
                                addressLines[0],
                                addressLines[1],
                                distance ? Formatters.formatAsMetricDistance(distance) : ''
                            );
                            var resultItem = DomHelpers.createResultItem();
                            resultItem.appendChild(searchResult);
                            resultItem.setAttribute('data-id', result.id);
                            resultItem.onclick = function(event) {
                                var id = event.currentTarget.getAttribute('data-id');
                                searchMarkersManager.openPopup(id);
                                searchMarkersManager.jumpToMarker(id);
                            };
                            resultList.appendChild(resultItem);
                        });
                        resultsManager.append(resultList);
                    }
                </script>
            </div>
        </div>
    </div>
@endsection
