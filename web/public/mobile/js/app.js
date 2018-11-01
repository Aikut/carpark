
// Dom7
var $$ = Dom7;

// Framework7 App main instance
var app  = new Framework7({
  root: '#app', // App root element
  id: 'com.aio.serebro', // App bundle ID
  name: 'Serebro', // App name
  theme: 'auto', // Automatic theme detection
  cache: false,
  material : true,
  baseUrl : baseUrl,
  data: function () {
    return {
      user: ''
    };
  },
  routes: routes,
});

// Init/Create main view
var mainView = app.views.create('.view-main', {
  url: '/'
});

var toastLargeMessage = app.toast.create({
    text: '<div class="row">' +
    '<h3>Сектор: <span id="title"></span></h3>' +
    '<p class="col-10">' +
    '<a href="#" class="toast-close" onclick="toastClose()"><i class="icon material-icons md-only">close</i></a>' +
    '</p>' +
    '</div>' +
    '<p>Емкость: <span id="capacity"></span> авто</p>' +
    '<p class="row">\n' +
    ' <a href="/info/1/" id="info" onclick="toastClose()" class="col-50 button button-raised button-round">Информация</a>\n' +
    ' <a href="/form/1"  id="session" onclick="toastClose()" class="col-50 button button-raised button-fill button-round">Начать обход</a>\n' +
    '</p>'
});

function toastClose() {
    toastLargeMessage.close();
    $$('.map-icon').animate({'bottom': '15px'});
}



var myLocationLat = null;
var myLocationLng = null;
var map;

app.preloader.show('green');

function initMap() {

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: {lat : 53.8537544, lng : 27.6019759},
        //mapTypeId: 'satellite',

        mapTypeId: google.maps.MapTypeId.HYBRID,
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.RIGHT_TOP
        },
        fullscreenControl: false,
        streetViewControl : false,
    });

    app.request({
        url: baseUrl + 'zone/list',
        dataType : 'json',
        async : false,
        success : function (data) {



            for(var i = 0; i < data.length; i++){
                var contentString = '<a onclick="showInfo(' + data[i]['id'] + ',\''+ data[i]['title'] + '\',' + data[i]['capacity'] + ',' + data[i]['center'].lat + ',' + data[i]['center'].lng + ')" class="infoWindow">' + data[i]['title']  + '</a>';

                var polygons = new google.maps.Polygon({
                    paths: data[i]['area'],
                    strokeColor: '#FFF',
                    strokeOpacity: 1,
                    strokeWeight: 1,
                    fillColor: 'green',
                    fillOpacity: 0.3,
                    title : data[i]['title'],
                    label : data[i]['title'],
                    capacity : data[i]['capacity'],
                    zoneId : data[i]['id']
                });
                polygons.setMap(map);


                var markers = new google.maps.Marker({
                    position: new google.maps.LatLng(data[i]['center'].lat, data[i]['center'].lng),
                    label: {
                        text: data[i]['title'],
                        color: "white",
                        fontSize : "18px"
                    },
                    link: contentString,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 0
                    }
                });

                markers.setMap(map);


                google.maps.event.addListener(polygons, 'click', function (event) {
                    toastLargeMessage.open();

                    var height = ($$('.toast').height() + 15).toString() + ' px';
                    $$('.map-icon').animate({'bottom': height});

                    $$('#title').html(this.title);
                    $$('#capacity').html(this.capacity);

                    $$('#info').attr('href', '/info/' + this.zoneId + '/');
                    $$('#session').attr('href', '/form/' + this.zoneId + '/');

                    var bounds = new google.maps.LatLngBounds();
                    this.getPath().forEach(function (path, index) {
                        bounds.extend(path);
                    });
                    map.fitBounds(bounds);
                    map.setZoom(16);

                    //alert(this.title);
                });
            }
        }/*,
        complete : function (data) {
        }*/
    });

    google.maps.event.addListenerOnce(map, 'idle', function(){
        app.preloader.hide();
    });
}

function showInfo(id, title, capacity, lat, lng){
    toastLargeMessage.open();

    var height = ($$('.toast').height() + 15).toString() + ' px';
    $$('.map-icon').animate({'bottom': height});

    $$('#title').html(title);
    $$('#capacity').html(capacity);

    $$('#info').attr('href', '/info/' + id + '/');
    $$('#session').attr('href', '/form/' + id + '/');


    var pos = {
        lat: lat,
        lng: lng
    };
    map.setCenter(pos);
    map.setZoom(16);
}


$$('.map-icon').on('click', function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            // var pos = google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            var icon = {
                url: 'images/my-location-icon.png', // url
                scaledSize: new google.maps.Size(50, 50), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };

            var markers = new google.maps.Marker({
                position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                icon: icon
            });

            markers.setMap(map);

            var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            map.panTo(latLng);


            //map.setCenter(pos);
            map.setZoom(16);

        }, function() {
            app.dialog.alert('Доступ к геоданным отключен на устройстве!');
        });
    }
    else {

        app.dialog.alert('Доступ к геоданным отключен на устройстве!');
    }
});


if (!localStorage.getItem("user_token")){
    app.loginScreen.open("#my-login-screen");
}

$$('#my-login-screen .login-button').on('click', function () {
    var username = $$('#my-login-screen [name="username"]').val();
    var password = $$('#my-login-screen [name="password"]').val();


    if (!username || !password) return;

    app.preloader.show('green');

    app.request({
        url: baseUrl + 'login',
        dataType : 'json',
        method : 'post',
        data : {
            username : username,
            password : password
        },
        async : false,
        success : function (data) {

            localStorage.setItem("user_token", data.token);
            localStorage.setItem("user", data.username);

            app.data.user.token = data.token;
            app.data.user.username = data.username;
            app.loginScreen.close('#my-login-screen');
            app.preloader.hide();

        },
        error : function (data) {
            $$('#login-message').show();
        }
    });

    app.preloader.hide();
});


$(document).ready(function(){
    $('input.timepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 10,
        minTime: '07:00',
        maxTime: '21:00',
        defaultTime: '7',
        startTime: '07:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
});