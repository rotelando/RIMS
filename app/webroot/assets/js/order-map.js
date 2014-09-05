var allMarkers = [];
var infowindow;
var map = null;
var param = '';
//Query Parameter for filter box
var floc = $('#filter-location option:selected').val();
var fuser = $('#filter-user option:selected').val();
var fdate = $('#filter-date option:selected').val();
var sdate = '';
var edate = '';

if(fdate === 'cust') {
    sdate = $('#sdate').val();
    edate = $('#edate').val();
}

param = buildQueryParam(floc, fuser, fdate, sdate, edate);
console.log(param);

//This helps to build the query parameters to be used in ajax calls for graphs etc.
function buildQueryParam(floc, fuser, fdate, sdate, edate) {

    var param = '';
    if (floc !== '') {
        if (param === '') {
            param += 'floc=' + floc;
        }
    }

    if (fuser !== '') {
        if (param === '') {
            param += 'fuser=' + fuser;
        }
        else {
            param += '&fuser=' + fuser;
        }
    }

    if (fdate !== '') {
        if (param === '') {
            param += 'fdate=' + fdate;
        }
        else {
            param += '&fdate=' + fdate;
        }
        if (fdate === 'cust') {
            param += '&sdate=' + sdate;
            param += '&edate=' + edate;
        }
    }

    return param;
}

//Maps API for Visits
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

    map = new google.maps.Map(document.getElementById('order-map-canvas'),
            mapOptions);

    var url = config.URL + 'maps/salesmapinformation';
    ordermapdisplay(url, true);
    
}

function loadScript() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyD9mvSGpeyg1gQqLiNr0nTFOstlNhuPx8g&sensor=false&' +
            'callback=initialize';
    document.body.appendChild(script);
}

window.onload = loadScript;


function ordermapdisplay(url, check) {
    
    $.ajax({
        url: url,
        dataType: 'JSON',
        data: param,
        success: function(sales_data) {
            var data = sales_data.sales_location;            
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
            + '<h5 class="text-info">Location:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].location + '</p>'
            + '<h5 class="text-info">Total Order Value:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].totalsalesvalue + '</p><hr />'
            + '<a class="btn btn-info btn-small" href="' + config.URL + 'outlets/view/' + data[i].outletid + '"> More </a> | '
            + '<a class="btn btn-inverse btn-small" onclick="closeInfowindow();"> Close </a>';

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