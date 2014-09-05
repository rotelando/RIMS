

var infowindow;
var allMarkers = [];
var map = null;

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
        zoom: 7,
        center: new google.maps.LatLng(9.061478, 7.512906),
        zoomControl: true,
        scrollwheel: false
    };

    map = new google.maps.Map(document.getElementById('mapbg'),
            mapOptions);

    var url = config.URL + 'maps/outletmapinformation';
    outletdisplay(url, true);
    
}

function loadScript() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyD9mvSGpeyg1gQqLiNr0nTFOstlNhuPx8g&sensor=false&' +
            'callback=initialize';
    document.body.appendChild(script);
}

window.onload = loadScript;



$('#filteroutlettype').css('visibility','visible');
$('#filtervisitstatus').css('visibility','hidden');
$('#filterbrands').css('visibility','hidden');

//    $('btnoutlet').css('class', 'active');

$('#btnoutlet').click(function() {
    
});

$('#maps-modules').on('change', function() {
    var url =  config.URL;
    var module = $(this).val();
    var is_create = true;
    
    clearMarkers();
    
    if(module.toString() === 'outlet') {
        
        url +=  'maps/outletmapinformation';
        outletdisplay(url, is_create);
        
    } else if(module.toString() === 'visit') {
        
        url +=  'maps/visitmapinformation';
        visitdisplay(url, is_create);
        
    } else if(module.toString() === 'merch') {
        
        url +=  'maps/merchandizemapinformation';
        merchandizemapdisplay(url, is_create);
        
    } else if(module.toString() === 'avail') {
        
        url +=  'maps/pavailmapinformation';
        pavailmapdisplay(url, is_create);
        
    } else if(module.toString() === 'order') {
        
        url +=  'maps/salesmapinformation';
        ordermapdisplay(url, is_create);
    }
});


$('#btnmapfilter').on('click', function() {
    
    var url =  config.URL;
    var module = $('#maps-modules').find(':selected').val();
    var is_create = false;
    
    if(module == 'outlet') {
        url +=  'maps/outletmapinformation';
        var cls = $('#outletclass').find(':selected').val();
        var chan = $('#outletchannel').find(':selected').val();
        var loc = $('#locations').find(':selected').val();
        if(cls != '0') { url +=  '?cls=' + cls; }
        if(chan != '0') { 
            if(url.indexOf('?') !== -1) //if ? is found in the url
                url +=  '&chan=' + chan; 
            else    //? not found in the url
                url +=  '?chan=' + chan; 
        }
        //append location param
        if(loc != '0') { 
            if(url.indexOf('?') !== -1) //if ? is found in the url
                url +=  '&loc=' + loc; 
            else    //? not found in the url
                url +=  '?loc=' + loc; 
        }
        clearMarkers();
        outletdisplay(url, is_create);
        
    } else if(module == 'visit') {
        
        url +=  'maps/visitmapinformation';
        var vs = $('#visitstate').find(':selected').val();
        var loc = $('#locations').find(':selected').val();
        if(vs != '0') { url +=  '?vs=' + vs; }
        //append location parameter
        if(loc != '0') { 
            if(url.indexOf('?') !== -1) //if ? is found in the url
                url +=  '&loc=' + loc; 
            else    //? not found in the url
                url +=  '?loc=' + loc; 
        }
        clearMarkers();
        visitdisplay(url, is_create);
        
    } else if(module == 'merch') {
        
        url +=  'maps/merchandizemapinformation';
        var mb = $('#merchandize_brand').find(':selected').val();
        var mbe = $('#merchandize_brandelement').find(':selected').val();
        var loc = $('#locations').find(':selected').val();
        if(mb != '0') { url +=  '?mb=' + mb; }
        if(mbe != '0') { 
            if(url.indexOf('?') !== -1) //if ? is found in the url
                url +=  '&mbe=' + mbe; 
            else    //? not found in the url
                url +=  '?mbe=' + mbe; 
        }
        //append location parameter
        if(loc != '0') { 
            if(url.indexOf('?') !== -1) //if ? is found in the url
                url +=  '&loc=' + loc; 
            else    //? not found in the url
                url +=  '?loc=' + loc; 
        }

        clearMarkers();
        merchandizemapdisplay(url, is_create);
        
    } else if(module == 'avail') {
        
        url +=  'maps/pavailmapinformation';
        var ap = $('#pavail_product').find(':selected').val();
        var loc = $('#locations').find(':selected').val();
        if(ap != '0') { url +=  '?ap=' + ap; }
        if(loc != '0') { 
            if(url.indexOf('?') !== -1) //if ? is found in the url
                url +=  '&loc=' + loc; 
            else    //? not found in the url
                url +=  '?loc=' + loc; 
        }

        clearMarkers();
        pavailmapdisplay(url, is_create);
        
    } else if(module == 'order') {
        
         url +=  'maps/salesmapinformation';
        var sp = $('#sales_product').find(':selected').val();
        var loc = $('#locations').find(':selected').val();
        if(sp != '0') { url +=  '?sp=' + sp; }
        if(loc != '0') { 
            if(url.indexOf('?') !== -1) //if ? is found in the url
                url +=  '&loc=' + loc; 
            else    //? not found in the url
                url +=  '?loc=' + loc; 
        }
        clearMarkers();
        ordermapdisplay(url, is_create);
    }
});

$('#btnmapsearch').on('click', function() {
    
    var qtext = $('#qtext').val();
    if(qtext === null || qtext === '') return;
    var url =  config.URL + 'maps/outletmapinformation?q=' + qtext;
    clearMarkers();
    outletdisplay(url, false);
});

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

function outletdisplay(url, check) {
    
//    var isCheck = check;
    
    $.ajax({
        url: url,
        dataType: 'JSON',
//        isCheck: isCheck,
        success: function(outlet_data) {
            var data = outlet_data.outlets_location;
            
            if(check) {
                $('#map-filters').html('');
                createFilterOption('outletclass', outlet_data.outlets_class);
                createFilterOption('outletchannel', outlet_data.outlets_channel);
                createLocationFilter('locations', outlet_data.locations);
            }
            
            buildResponseMarker(data);
        }
    });

}

function visitdisplay(url, check) {
    
    $.ajax({
        url: url,
        dataType: 'JSON',
        success: function(visit_data) {
            var data = visit_data.visit_location;
            
             if(check) {
                $('#map-filters').html('');
                createFilterOption('visitstate', visit_data.visit_state);
                createLocationFilter('locations', visit_data.locations);
             }
             
            buildResponseMarker(data);
        }
    });
}

function merchandizemapdisplay(url, check) {
    $.ajax({
        url: url,
        dataType: 'JSON',
        success: function(merchandize_data) {
            var data = merchandize_data.merchandize_location;
            
            if(check) {
                $('#map-filters').html('');
                createFilterOption('merchandize_brand', merchandize_data.merchandize_brands);
                createFilterOption('merchandize_brandelement', merchandize_data.merchandize_brandelements);
                createLocationFilter('locations', merchandize_data.locations);
            }
        
            buildResponseMarker(data);
        }
    });
}

function pavailmapdisplay(url, check) {
    $.ajax({
        url: url,
        dataType: 'JSON',
        success: function(pavail_data) {
            var data = pavail_data.pavail_location;
            $('#map-filters').html('');
            
            createFilterOption('pavail_product', pavail_data.pavail_product);
            createLocationFilter('locations', pavail_data.locations);
            buildResponseMarker(data);
        }
    });
}

function ordermapdisplay(url, check) {
    
    $.ajax({
        url: url,
        dataType: 'JSON',
        success: function(sales_data) {
            var data = sales_data.sales_location;
            
            if(check) {
                $('#map-filters').html('');
                createFilterOption('sales_product', sales_data.sales_product);
                createLocationFilter('locations', sales_data.locations);
            }
            buildResponseMarker(data);
        }
    });
}

function createFilterOption(filter_name, filter_data) {
    $('#map-filters').append($('<select>', {id: filter_name}));
    var id_name = '#' + filter_name;
    for (var i = 0; i < filter_data.length; i++) {
        $(id_name).append('<option value="' + filter_data[i].id + '">'+ filter_data[i].name + '</option>');
    }
    //Create a space between the filter options
    $('#map-filters').append('&nbsp;');
}

function createLocationFilter(filter_name, location_data) {
    $('#map-filters').append($('<select>', {id: filter_name}));
    var id_name = '#' + filter_name;
    console.log(location_data.length);
    for (var i = 0; i < location_data.length; i++) {
        if(location_data[i].Default) {
            $(id_name).append('<option value="' + location_data[i].Default.id + '">'+ location_data[i].Default.name + '</option>');
        }
        // Countries
        if(location_data[i].Nationals) {
            $(id_name).append('<optgroup label="Nationals">');
            for(j = 0; j < location_data[i].Nationals.length; j++) {
                $(id_name).append('<option value="' + location_data[i].Nationals[j].id + '">'+ location_data[i].Nationals[j].name + '</option>');
            }   
            $(id_name).append('</optgroup>');  
        }
        //Regions
        if(location_data[i].Regions) {
            $(id_name).append('<optgroup label="Regions">');
            for(j = 0; j < location_data[i].Regions.length; j++) {
                $(id_name).append('<option value="' + location_data[i].Regions[j].id + '">'+ location_data[i].Regions[j].name + '</option>');
            }   
            $(id_name).append('</optgroup>');  
        }
        //States
        if(location_data[i].States) {
            $(id_name).append('<optgroup label="States">');
            for(j = 0; j < location_data[i].States.length; j++) {
                $(id_name).append('<option value="' + location_data[i].States[j].id + '">'+ location_data[i].States[j].name + '</option>');
            }   
            $(id_name).append('</optgroup>');  
        }
        //Locations
        if(location_data[i].Locations) {
            $(id_name).append('<optgroup label="Locations">');
            for(j = 0; j < location_data[i].Locations.length; j++) {
                $(id_name).append('<option value="' + location_data[i].Locations[j].id + '">'+ location_data[i].Locations[j].name + '</option>');
            }   
            $(id_name).append('</optgroup>');  
        }

        $('#map-filters').append('&nbsp;');
    }
    //Create a space between the filter options
    $('#map-filters').append('&nbsp;');   
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
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].phonenumber + '</p><hr />';
    
        if(data[i].totalsalesvalue) {
            contentString += '<h5 class="text-info">Total Sales Value:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].totalsalesvalue + '</p>';
        } else if(data[i].totalvalue) {
            contentString += '<h5 class="text-info">Total Value:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].totalvalue + '</p>';
        } else if(data[i].totalcount) {
            contentString += '<h5 class="text-info">Element Count:</h5>'
            + '<p style="margin-top: 0px; padding: 0px;">' + data[i].totalcount + '</p>';
        }
        
        contentString += '<a class="btn btn-info btn-small" href="' + config.URL + 'outlets/view/' + data[i].outletid + '"> More </a> | '
            + '<a class="btn btn-inverse btn-small" onclick="closeInfowindow();"> Close </a>';
        
        
        
        if (data[i].visited) {
            allMarkers[i] = createMarker(data[i].outletname, data[i].latitude, data[i].longitude, map, data[i].iconUrl, contentString);
        } else {
            allMarkers[i] = createMarker(data[i].outletname, data[i].latitude, data[i].longitude, map, data[i].iconUrl, contentString);
        }
    }
}