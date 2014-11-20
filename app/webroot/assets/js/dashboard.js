$(document).ready(function() {

    try {
        $('.image-list a').vanillabox();
    } catch (e) {};

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
    //End Query Parameter for filter box
    
    $('.pagination .active').wrapInner('<a href="#"></a>');
                
    $('.actual-plan-chart').easyPieChart({
        scaleColor: false,
        lineWidth: 5,
        size: 100,
        easing: 'easeOutBounce',
        lineCap: 'circle',
        trackColor: '#f4f4f4',
        barColor: '#87b880'
    });
    
    
    var size = $('.actual-plan-chart').data('size');
    $('span.percent').css('position','relative');
    $('span.percent').css('left',(size / 2) + 15);
    $('span.percent').css('top',- size / 2);
    
    $('.actual-target-chart').easyPieChart({
        scaleColor: false,
        lineWidth: 5,
        size: 100,
        easing: 'easeOutBounce',
        lineCap: 'circle',
        trackColor: '#f4f4f4',
        barColor: '#f99406'
    });
    
    $('.plan-target-chart').easyPieChart({
        scaleColor: false,
        lineWidth: 5,
        size: 100,
        easing: 'easeOutBounce',
        lineCap: 'circle',
        trackColor: '#f4f4f4',
        barColor: '#dc3813'
    });


    var oUrl =  config.URL + 'outlets/outletperformance';
    //Outlet Performance Data
    function get_outlet_performance() {
        return $.ajax({
            url: oUrl,
            data: param,
            dataType: 'JSON'
        });
    }

    var outlet_performance = get_outlet_performance();

    outlet_performance.success(function(outlet_performance_data) {

        $('#outlet_perfomance').highcharts({
            chart: {
                zoomType: 'x',
                spacingRight: 20
            },
            title: {
                text: 'Performance by outlet additions for last 2 weeks'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' :
                    'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime',
                maxZoom: 7 * 24 * 3600000, // fourteen days
                title: {
                    text: null
                }
            },
            yAxis: {
                title: {
                    text: 'Total Number of Outlets'
                },
                min: 0
            },
            tooltip: {
                shared: true
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    lineWidth: 1,
                    marker: {
                        enabled: false
                    },
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [ outlet_performance_data ]
        });
    });

    /*$('#performance').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: 'Performance by Count'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {// don't display the dummy year
                month: '%e. %b',
                year: '%b'
            }
        },
        yAxis: {
            title: {
                text: 'Total No added'
            },
            min: 0
        },
        tooltip: {
            formatter: function() {
                return '<b>' + this.series.name + '</b><br/>' +
                        Highcharts.dateFormat('%e. %b', this.x) + ': ' + 
                        this.y + ' ' + this.series.name.toString().toLowerCase() + '(s) added';
            }
        },
        series: [
{
name: "Pay & Go",
data: [
        [1406588400000,50],[1406674800000,53],[1406761200000,42],[1406847600000,40],[1406934000000,41],[1407020400000,37],[1407106800000,45],
        [1407193200000,27],[1407279600000,50],[1407366000000,45],[1407452400000,45],[1407538800000,44],[1407625200000,50],[1407711600000,48],
        [1407798000000,42]],
        color: "#438eb8"
        },
        {
        name: "Shop & Browse",
        data: [
        [1406588400000,11],[1406674800000,7],[1406761200000,15],[1406847600000,10],[1406934000000,20],[1407020400000,14],[1407106800000,17],
        [1407193200000,19],[1407279600000,14],[1407366000000,15],[1407452400000,17],[1407538800000,18],[1407625200000,12],[1407711600000,14],
        [1407798000000,16]],
        color: "#109619"
        },
        {
        name: "Entertainment",
        data: [
        [1406588400000,17],[1406674800000,11],[1406761200000,14],[1406847600000,17],[1406934000000,25],[1407020400000,14],[1407106800000,17],
        [1407193200000,26],[1407279600000,19],[1407366000000,23],[1407452400000,20],[1407538800000,23],[1407625200000,23],[1407711600000,23],
        [1407798000000,21]],
        color: "#dc3813"
        }
      ]
    });*/

    mapDashboardFunction('');
    var mapurl = config.URL + 'dashboard/mapdata';

    $("#fusionMapContainer").insertFusionCharts({
        swfUrl: "assets/Maps/FCMap_Nigeria.swf",
        dataSource: mapurl,
        dataFormat: "jsonurl",
        width: "100%",
        height: "650",
        id: "myMapId"
    });

    //Outlet Distribution Data
    //Outlet Distribution Data
    var url =  config.URL + 'dashboard/outletmerchandizedistribution';
    function get_merchandize_distribution() {
        return $.ajax({
            url: url,
            data: param,
            dataType: 'JSON'
        });
    }

    var merchandize_distribution = get_merchandize_distribution();

    merchandize_distribution.success(function(distribution_data) {
        $('#outlet_merchandize').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Brand Merchandize Share'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.y})</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        distance: -30,
                        color: 'white',
                        format: '{point.percentage:.1f} %'
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Merchandize Share',
                data: distribution_data
            }]
        });
    });

    //Retail Distribution Data
    url =  config.URL + 'outlets/retailtypedistribution';
    function get_retailtype_distribution() {
        return $.ajax({
            url: url,
            data: param,
            dataType: 'JSON'
        });
    }

    var outlet_retailtype_distribution = get_retailtype_distribution();
    outlet_retailtype_distribution.success(function(distribution_data) {

        $('#outlet_retail').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Retail Classification'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.y})</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        distance: -30,
                        color: '#ffffff',
                        connectorColor: '#000000',
                        format: '{point.percentage:.1f} %'
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Retail Classification',
                data: distribution_data
            }]
        });
    });

    //Retail Distribution Data
    url =  config.URL + 'dashboard/outletproductdistribution';
    function get_outletproduct_distribution() {
        return $.ajax({
            url: url,
            data: param,
            dataType: 'JSON'
        });
    }

    var outletproduct_distribution = get_outletproduct_distribution();
    outletproduct_distribution.success(function(distribution_data) {

        $('#outlet_product').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Product Share'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.y})</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        distance: -30,
                        color: '#ffffff',
                        connectorColor: '#000000',
                        format: '{point.percentage:.1f} %'
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Product Share',
                data: distribution_data
            }]
        });
    });

});

function mapDashboardFunction(id) {
    var vaurl = config.URL + 'dashboard/visitaccuracy/' + id;
    function get_accuracy_by_location() {
            return $.ajax({
                url: vaurl,
                dataType: 'json',
                cache: false
            });
        }

        var accuracy_by_location = get_accuracy_by_location();

        accuracy_by_location.success(function(accuracy_data) {
//            $('#avp').data('data-percent', accuracy_data.actual_vs_planned + '%');
            
            $('#avp').attr('data-percent', accuracy_data.actual_vs_planned + '%');
            $('#avp div').css('width', accuracy_data.actual_vs_planned + '%');
            
            $('#avt').attr('data-percent', accuracy_data.actual_vs_target + '%')
            $('#avt div').css('width', accuracy_data.actual_vs_target + '%');
            
            $('#pvt').attr('data-percent', accuracy_data.planned_vs_target + '%')
            $('#pvt div').css('width', accuracy_data.planned_vs_target + '%');
            
            $('#outletcount').html(accuracy_data.outletcount);
            $('#planned').html(accuracy_data.planned);
            $('#actual').html(accuracy_data.actual);
            $('#target').html(accuracy_data.target);
            $('#ordercount').html(accuracy_data.ordercount);
            $('#visitperday').html('1 visit per day');
            if(accuracy_data.statename) {
                $('#statename').html(accuracy_data.statename);
            } else {
                $('#statename').html('Overall');
            }
        });
}