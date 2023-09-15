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
    var popup = new tt.Popup({
        offset: 30
    }).setText(popupText);
    // add marker to map
    new tt.Marker({
            element: markerElement,
            anchor: 'bottom'
        })
        .setLngLat(position)
        .setPopup(popup)
        .addTo(map);
}
createMarker([resultFieldLO.value, resultFieldLA.value], '#5327c3', 'SVG icon');
// nel caso volessimo mettere un'icona all'interno del marker questa è la versiona con l'automobilina
// createMarker('accident.colors-white.svg', [resultFieldLO.value, resultFieldLA.value], '#5327c3', 'SVG icon');
