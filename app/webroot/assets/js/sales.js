
$(document).ready(function(){
    
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
    
    //Wrap pagination current item with an anchor tag
    $('.pagination .active').wrapInner('<a href="#"></a>');
    
//    $('.actual-target-chart').easyPieChart({
//        scaleColor: false,
//        lineWidth: 10,
//        easing: 'easeOutBounce',
//        lineCap: 'circle',
//        trackColor: '#f2f2f2'
//    });
    
    var size = $('.actual-target-chart').data('size');
    $('span.percent').css('position','relative');
    $('span.percent').css('height', size);
    $('span.percent').css('width', size);
    $('span.percent').css('align', 'middle');
    $('span.percent').css('top',-(size / 2) + 10);
    $('span.percent').css('left',(size / 2) + 20);

    
    $('.actual-target-chart').easyPieChart({
        scaleColor: false,
        lineWidth: 20,
        size: 200,
        easing: 'easeOutBounce',
        lineCap: 'circle',
        trackColor: '#f2f2f2',
        barColor: '#f99406'
    });
    
    //============= Order Distribution By Product Data =============//
    var url = config.URL + 'sales/distribution';
    function get_order_distribution() {
        return $.ajax({
            url: url,
            dataType: 'json',
            data: param,
            cache: false
        });
    }

    var order_distribution = get_order_distribution();

    order_distribution.success(function(distribution_data) {

        $('#order_dist').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.y})</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
//                    dataLabels: {
//                        enabled: true,
//                        color: '#000000',
//                        connectorColor: '#000000',
//                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
//                    },
                    dataLabels: {
//                        distance: -30,
//                        color: 'white',
                        format: '<b>{point.name}</b> <br />{point.percentage:.1f} %'
                    },
                    showInLegend: true
                }
            },
            series: [{
                    type: 'pie',
                    name: 'Product Orders',
                    data: distribution_data
                }]
        });
    });
    //============= End Order Distribution By Product Data =============//
    
    //============= Order Performance =============//
        var spurl = config.URL + 'sales/performance';
        function get_sales_performance() {
            return $.ajax({
                url: spurl,
                dataType: 'json',
                data: param,
                cache: false
            });
        }

        var sales_performance = get_sales_performance();

        sales_performance.success(function(performance_data) {
            $('#sales_performance').highcharts({
                chart: {
                    type: 'spline'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: 'Performance by product'
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
                        text: 'Total No of Orders'
                    },
                    min: 0
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                                Highcharts.dateFormat('%e. %b', this.x) + ': ' + this.y + ' order(s)';
                    }
                },
                series: performance_data
            });
        });
        //============= End Order Performance =============//


    var all_sales_url = config.URL + "sales/loadsales";

    $('#order_all_table').DataTable( {
        "lengthMenu": [ 25, 50, 75, 100 ],
        //"pagingType": "full_numbers",
        "order": [[ 3, "desc" ]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": all_sales_url,
            "type": "POST"
        },
        "columnDefs": [ 
            {
                "targets": 0,
                "data": "out_id",
                "render": function ( data, type, full, meta ) {
                    var render0 = '';
                    if(full[0] != null)
                        render0 = '<a href="/outlets/view/' + full["out_id"] + '">'+ full[0] + ' </a>';
                        
                    return render0;
                }
            },
            {
                "targets": 5,
                "data": "id",
                "render": function ( data, type, full, meta ) {
                    
                    var link = '<div class="hidden-phone visible-desktop action-buttons">';
                    link += '<a href="/visits/delete/' + full[5] + '" class="blue" data-rel="tooltip" data-placement="top" data-original-title="View"><i class="icon-zoom-in bigger-130"></i> </a> | ';
                    link += '<a href="/sales/delete/' + full["sales_id"] + '" class="red" data-rel="tooltip" data-placement="top" data-original-title="Delete"><i class="icon-trash bigger-130"></i> </a>';
                    link +=  '</div>'
                  return link;
                }
            } 
        ]
    });
});

