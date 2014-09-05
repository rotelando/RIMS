var param = '';

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
    
    param = buildQueryParam(floc, fuser, fdate, sdate, edate);
//    alert('Query Param: ' + param);
    //End Query Parameter for filter box

    
    //============= Product Availability Distribution Data =============//
    var url = config.URL + 'productavailabilities/distribution';
    function get_availability_distribution() {
        return $.ajax({
            url: url,
            dataType: 'json',
            data: param,
            cache: false
        });
    }

    var availability_distribution = get_availability_distribution();

    availability_distribution.success(function(distribution_data) {

        $('#availability_dist').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
//                text: 'Product Availability Distribution by Brand'
                text: ''
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
                    name: 'Product Available',
                    data: distribution_data
                }]
        });
    });
    //============= End Product Availability Distribution Data =============//

//============= Product Availability Distribution by Product Data =============//
    url = config.URL + 'productavailabilities/distributionbybrandproduct';
    function get_availability_distribution() {
        return $.ajax({
            url: url,
            dataType: 'json',
            data: param,
            cache: false
        });
    }

    var availability_distribution = get_availability_distribution();

    availability_distribution.success(function(distribution_data) {

        $('#availability_dist_by_product').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
//                text: 'Product Availability Distribution by Brand Products'
                text: ''
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
                    name: 'Product Available',
                    data: distribution_data
                }]
        });
    });
    //============= End Product Availability Distribution by Product Data =============//
    
    
    //============= Product availability comparison chart =============//
    url = config.URL + 'productavailabilities/comparison';
    function get_availability_comparison() {
        return $.ajax({
            url: url,
            dataType: 'json',
            data: param,
            cache: false
        });
    }

    var availability_comparison = get_availability_comparison();

    availability_comparison.success(function(comparison_data) {
        
        var series_data = comparison_data.series;
        var category_data = comparison_data.categories;
        
        $('#prod_availability_comp').highcharts({
            
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: category_data
            },
            yAxis: {
                //                min: 0,
                title: {
                    text: 'Total Product Available'
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
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            series: series_data
            
        });
    });
    //============= End Product availability comparison chart =============//
    
    //============= Performance =============//
        var spurl = config.URL + 'productavailabilities/performance';
        function get_performance() {
            return $.ajax({
                url: spurl,
                dataType: 'json',
                data: param,
                cache: false
            });
        }

        var prodavail_performance = get_performance();

        prodavail_performance.success(function(performance_data) {
            $('#performance').highcharts({
                chart: {
                    type: 'spline'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: 'Daily Performance'
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
                        text: 'Total No'
                    },
                    min: 0
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                                Highcharts.dateFormat('%e. %b', this.x) + ': ' + 
                                this.y + ' product(s) available';
                    }
                },
                series: performance_data
            });
        });
        //============= End Performance =============//
        
        var prodavailurl = config.URL + 'productavailabilities/mapdata?' + param;
        var swfUrl = "assets/Maps/FCMap_Nigeria.swf";
        $("#availability-map").insertFusionCharts({
            swfUrl: swfUrl,
            dataSource: prodavailurl,
            dataFormat: "jsonurl",
            width: "100%",
            height: "650",
            id: "prodMapId"
        });
});

function getAvailDetailFromMap(id) {
    
    var paurl = config.URL + 'productavailabilities/mapitemdata/' + id;
    function get_availability_by_location() {
            return $.ajax({
                url: paurl,
                dataType: 'json',
                cache: false
            });
        }

        var availability_by_location = get_availability_by_location();

        availability_by_location.success(function(availability_data) {
            
            var html = '';
            var statename = '';
            for (var i = 0; i < availability_data.length; i++) {
                statename = availability_data[i].statename;
                html += '<tr>';
                html += '<td>' + availability_data[i].brandname + '</td>';
                html += '<td>' + availability_data[i].productname + '</td>';
                html += '<td>' + availability_data[i].value + '</td>';
                html += '</tr>';
            }
            
            $('#mapcontent').html(html);
            $('#pavstatename').html(statename);
        });
}