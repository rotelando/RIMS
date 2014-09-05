var allMarkers = [];
var infowindow;
var map = null;


function loadScript() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyD9mvSGpeyg1gQqLiNr0nTFOstlNhuPx8g&sensor=false&' +
            'callback=initialize';
    document.body.appendChild(script);
}

window.onload = loadScript;

//Maps API for Visit
function createMarker(outletname, latitude, longitude, map, icon, contentString) {

    var latlng = new google.maps.LatLng(latitude, longitude);
    var marker = new google.maps.Marker({
        position: latlng,
        title: outletname,
        icon: icon
    });

    google.maps.event.addListener(marker, 'click', function() {
        closeInfowindow();
        
        infowindow = new google.maps.InfoWindow({
            content: contentString,
            maxWidth: 350
        });
        infowindow.open(map, marker);
    });

    marker.setMap(map);
    return marker;
}

function initialize() {
    
    var mapOptions = {
        zoom: 6,
        center: new google.maps.LatLng(9.061478, 7.512906),
        zoomControl: true,
        scrollwheel: false
    };

    map = new google.maps.Map(document.getElementById('visit-map-canvas'),
            mapOptions);

    var url = config.URL + 'maps/visitmapinformation';
    visitdisplay(url, true);    
}

function visitdisplay(url, check) {
    
    $.ajax({
        url: url,
        dataType: 'JSON',
        success: function(data) {
            buildResponseMarker(data);
        }
    });
}

function buildResponseMarker(data) {

    for (var i = 0; i < data.length; i++) {
                    
        var contentString = '<h5 class="text-info">Outlet Name:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].outletname + '</p>'
            + '<h5 class="text-info">Outlet Type:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].outlettype + '</p>'
            + '<h5 class="text-info">Contact Name:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].contactname + '</p>'
            + '<h5 class="text-info">Address:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].address + '</p>'
            + '<h5 class="text-info">Location:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].location + '</p>'
            + '<h5 class="text-info">Phone Number:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].phonenumber + '</p><hr />'
            + '<a class="btn btn-info btn-small" href="' + config.URL + 'outlets/view/' + data[i].outletid + '"> More </a>';

        if (data[i].visited) {
            allMarkers[i] = createMarker(data[i].outletname, data[i].latitude, data[i].longitude, map, data[i].iconUrl, contentString);
        } else {
            allMarkers[i] = createMarker(data[i].outletname, data[i].latitude, data[i].longitude, map, data[i].iconUrl, contentString);
        }
    }   
}

function clearMarkers() {

    for (var i = 0; i < allMarkers.length; i++) {
        allMarkers[i].setMap(null);
    }

    allMarkers = new Array();
}

function closeInfowindow() {
    if(infowindow) {
        infowindow.close();
    }
}



// var allMarkers = [];
// var map = null;

// //Maps API for Visits
// function createMarker(outletname, latitude, longitude, map, icon, contentString) {

//     var latlng = new google.maps.LatLng(latitude, longitude);
//     var marker = new google.maps.Marker({
//         position: latlng,
//         title: outletname,
//         icon: icon,
//         animation: google.maps.Animation.DROP

//     });

//     var infowindow = new google.maps.InfoWindow({
//         content: contentString,
//         maxWidth: 350,
//     });

//     google.maps.event.addListener(marker, 'click', function() {
//         infowindow.open(map, marker);
//     });

//     marker.setMap(map);
//     return marker;
// }
      
// function initialize() {
//     var mapOptions = {
//         zoom: 6,
//         center: new google.maps.LatLng(9.10000, 7.50000),
//         zoomControl: true,
//         scaleControl: true
//     };

//     map = new google.maps.Map(document.getElementById('visit-map-canvas'),
//             mapOptions);

//     var url =  config.URL + 'maps/visitmapinformation';
//     $.ajax({
//         url: url,
//         dataType: 'JSON',
//         success: function(data) {
//             $('#maploading').css('visibility', 'visible');
//             for (var i = 0; i < data.length; i++) {
                
//                 var contentString = '<h5 class="text-info">Outlet Name:</h5>'
//                     + '<p style="margin-top: 0px; padding: 0px;">' + data[i].outletname + '</p>'
//                     + '<h5 class="text-info">Outlet Type:</h5>'
//                     + '<p style="margin-top: 0px; padding: 0px;">' + data[i].outlettype + '</p>'
//                     + '<h5 class="text-info">Contact Name:</h5>'
//                     + '<p style="margin-top: 0px; padding: 0px;">' + data[i].contactname + '</p>'
//                     + '<h5 class="text-info">Address:</h5>'
//                     + '<p style="margin-top: 0px; padding: 0px;">' + data[i].address + '</p>'
//                     + '<h5 class="text-info">Location:</h5>'
//                     + '<p style="margin-top: 0px; padding: 0px;">' + data[i].location + '</p>'
//                     + '<h5 class="text-info">Phone Number:</h5>'
//                     + '<p style="margin-top: 0px; padding: 0px;">' + data[i].phonenumber + '</p><hr />'
//                     + '<a class="btn btn-info btn-small" href="' + config.URL + 'outlets/view/' + data[i].outletid + '"> More </a>';
    
//                 if (data[i].visited) {
//                     allMarkers[i] = createMarker(data[i].outletname, data[i].latitude, data[i].longitude, map, data[i].iconUrl, contentString);
//                 } else {
//                     allMarkers[i] = createMarker(data[i].outletname, data[i].latitude, data[i].longitude, map, data[i].iconUrl, contentString);
//                 }
//             }
//             $('#maploading').css('visibility', 'collapse');
//         }
//     });
// }

// function loadScript() {
//     var script = document.createElement('script');
//     script.type = 'text/javascript';
//     script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyD9mvSGpeyg1gQqLiNr0nTFOstlNhuPx8g&sensor=false&' +
//     'callback=initialize';
//     document.body.appendChild(script);
// }

// window.onload = loadScript;