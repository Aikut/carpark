
var mymap = L.map('mapid', {zoomSnap: 0.5}).setView([39.800, 70.75499], 8.5);

// L.tileLayer('http://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
// L.tileLayer('http://korona.geog.uni-heidelberg.de/tiles/roads/x={x}&y={y}&z={z}', {
// L.tileLayer('http://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
// L.tileLayer('http://vec{s}.maps.yandex.net/tiles?l=map&v=4.55.2&z={z}&x={x}&y={y}&scale=2&lang=ru_RU', {
//     attribution: '',
//     maxZoom: 18,
//     minZoom: 8,
//     id: 'your.mapbox.project.id',
//     accessToken: 'your.mapbox.public.access.token'
// }).addTo(mymap);

L.tileLayer(
    'http://vec{s}.maps.yandex.net/tiles?l=map&v=4.55.2&z={z}&x={x}&y={y}&scale=2&lang=ru_RU', {
        subdomains: ['01', '02', '03', '04'],
        // attribution: '<a http="yandex.ru" target="_blank">Яндекс</a>',
        reuseTiles: true,
        updateWhenIdle: false,
        maxZoom: 18,
        minZoom: 8,
    }
).addTo(mymap);

L.geoJson(statesData).addTo(mymap);

function getColor(d) {
    return d > 5 ? '#084594' :
        d > 4 ? '#2171b5' :
            d > 3 ? '#4292c6' :
                d > 2 ? '#6baed6' :
                    d > 1 ? '#9ecae1' :
                        d > 0 ? '#c6dbef' :
                            d >=0 ? '#deebf7' :
                                '#f7fbff';
}

function style(feature) {
    return {
        fillColor: getColor(feature.properties.density),
        weight: 1,
        opacity: 1,
        // color: '#2f65ca',
        color: '#4292c6',
        dashArray: '1',
        fillOpacity: 0.1
    };
}
L.geoJson(statesData, {style: style}).addTo(mymap);

var geojson;

function highlightFeature(e) {
    var layer = e.target;

    layer.setStyle({
        fillColor: '#FF6384',
        weight: 1,
        // color: '#D40011',
        color: '#FF6384',
        dashArray: '1',
        fillOpacity: 0.2
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }

    info.update(layer.feature.properties);
}

function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
}

function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: zoomToFeature
    });
}

function zoomToFeature(e) {
    mymap.fitBounds(e.target.getBounds());
}

geojson = L.geoJson(statesData, {
    style: style,
    onEachFeature: onEachFeature
}).addTo(mymap);

//CONTROL
   var info = L.control({position: 'topleft'});

   info.onAdd = function (map) {
       this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
       this.update();
       return this._div;
   };

// method that we will use to update the control based on feature properties passed
   info.update = function (props) {
       this._div.innerHTML = '<h4>Баткенская область</h4>' +  (props ?
           '<b>' + props.name + '</b><br />' + props.density + ' тыc. чел.'
               : 'Наведите на регион');
   };

   info.addTo(mymap);

// LEGEND
//    var legend = L.control({position: 'bottomright'});
//
//    legend.onAdd = function (map) {
//
//        var div = L.DomUtil.create('div', 'info legend'),
//            grades = [0, 10, 20, 50, 100, 200, 500, 1000],
//            labels = [];
//
//        // loop through our density intervals and generate a label with a colored square for each interval
//        for (var i = 0; i < grades.length; i++) {
//            div.innerHTML +=
//                '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
//                grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
//        }
//
//        return div;
//    };
//
//    legend.addTo(mymap);