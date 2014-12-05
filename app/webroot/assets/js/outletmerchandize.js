
$(document).ready(function() {

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
    
    var param = buildQueryParam(floc, fuser, fdate, sdate, edate);
    
//    alert('Query Param: ' + param);
    
//    alert('Location ID: ' + floc + 
//            ', User ID: ' + fuser + 
//            ', Date ID: ' + fdate +
//            ', SDate: ' + sdate +
//            ', EDate ID: ' + edate);
    
    //Wrap pagination current item with an anchor tag
    $('.pagination .active').wrapInner('<a href="#"></a>');

    //Visibility Share Data
    var url = '';
    url = config.URL + 'outletmerchandize/brandshares';
    //url = 'visibilityevaluations/visibilityshares';
    function get_visibility_share() {
        return $.ajax({
            url: url,
            data: param,
            dataType: 'JSON'
        });
    }

    var visibility_share = get_visibility_share();

    visibility_share.success(function(share_data) {

        //Visibility Shares by brands
        $('#visibility_share_brands').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Visibility Shares by Brands'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.y})</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
//                        enabled: true,
                        color: 'white',
                        distance: -30,
//                        connectorColor: '#000000',
                        format: '{point.percentage:.1f} %'
                    },
                    showInLegend: true
                }
            },
            series: [{
                    type: 'pie',
                    name: 'Outlet Distribution',
                    data: share_data
                }]
        });
    });
    
    //Visibility Share Data
    var url = '';
    //url = 'visibilityevaluations/merchandizegiveoutshare';
    url = config.URL + 'visibilityevaluations/merchandizegiveoutshare';
    function get_merchandizegiveout_share() {
        return $.ajax({
            url: url,
            data: param,
            dataType: 'JSON'
        });
    }

    var merchandizegiveout_share = get_merchandizegiveout_share();

    merchandizegiveout_share.success(function(merchandize_data) {

        //Visibility Shares by brands
        $('#merchandize_giveout').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Merchandize Giveout share'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.y})</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
//                        enabled: true,
                        color: 'white',
                        distance: -30,
//                        connectorColor: '#000000',
                        format: '{point.percentage:.1f} %'
                    },
                    showInLegend: true
                }
            },
            series: [{
                    type: 'pie',
                    name: 'Outlet Distribution',
                    data: merchandize_data
                }]
        });
    });
    

    //Visibility Performance Chart
    //============= Element Performance =============//
    var epurl = config.URL + 'outletmerchandize/elementperformance';
    function get_element_performance() {
        return $.ajax({
            url: epurl,
            dataType: 'json',
            data: param,
            cache: false
        });
    }

    var element_performance = get_element_performance();

    element_performance.success(function(performance_data) {
        $('#element_perfomance').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: performance_data.categories
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Percentage visibility elements ( % )'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                column: {
                    stacking: 'percent'
                }
            },
            series: performance_data.series
        });
    });


var mapurl = config.URL + 'outletmerchandize/mapdata?' + param;
//var swfUrl = "assets/Maps/FCMap_Nigeria.swf";
$("#visibility-map").insertFusionCharts({
    swfUrl: "assets/Maps/FCMap_Nigeria.swf",
    dataSource: mapurl,
    dataFormat: "jsonurl",
    width: "100%",
    height: "650",
    id: "visibilityMapId"
});

    url = config.URL + 'outletmerchandize/merchandizeshare';
    function get_brandelement_share() {
        return $.ajax({
            url: url,
            data: param,
            dataType: 'JSON'
        });
    }

    var brandelement_share = get_brandelement_share();

    brandelement_share.success(function(share_data) {

        var allChartCanvas = '<div class="row-fluid">';
        for(var i = 0; i < share_data.length; i++) {

            if((i % 4) == 0 && i != 0) {
                allChartCanvas += '</div><div class="row-fluid">';
            }

            var chartItemCanvas = '<div class="span3"><div id="pieItem_' + i + '" style="min-width: 250px; height: 400px"></div></div>'
            allChartCanvas += chartItemCanvas;

        }

        console.log(allChartCanvas);
        allChartCanvas += '</div>';
        $('#chartCanvas').append(allChartCanvas);
        // alert(allChartCanvas);

        for(var i = 0; i < share_data.length; i++) {

            //Visibility Shares by element by brands
            $('#pieItem_' + i).highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: share_data[i].elementname
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.y})</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            color: 'white',
                            distance: -30,
                            format: '{point.percentage:.1f} %'
                        },
                        showInLegend: true
                    }
                },
                series: [{
                        type: 'pie',
                        name: 'Outlet Distribution',
                        data: share_data[i].data
                    }]
            });
        }
    });

});

function getVisibilityDetailFromMap(id) {

    var veurl = config.URL + 'outletmerchandize/mapitemdata/' + id;
    function get_visibility_by_location() {
        return $.ajax({
            url: veurl,
            dataType: 'json',
            cache: false
        });
    }

    var visibility_by_location = get_visibility_by_location();

    visibility_by_location.success(function(visibility_data) {

        var html = '';
        var statename = '';
        for (var i = 0; i < visibility_data.length; i++) {
            statename = visibility_data[i].statename;
            html += '<tr>';
            html += '<td>' + visibility_data[i].brandname + '</td>';
            html += '<td>' + visibility_data[i].merchandize + '</td>';
            html += '<td>' + visibility_data[i].count + '</td>';
            html += '</tr>';
        }

        $('#mapcontent').html(html);
        $('#vstatename').html(statename);
    });
}