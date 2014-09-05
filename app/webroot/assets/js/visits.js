
$(document).ready(function(){
    
    var all_visits_url = config.URL + "visits/loadall";

    $('#visit_all_table').DataTable( {
        "lengthMenu": [ 25, 50, 75, 100 ],
        //"pagingType": "full_numbers",
        "order": [[ 5, "desc" ]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": all_visits_url,
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
                "targets": 6,
                "data": "id",
                "render": function ( data, type, full, meta ) {
                    
                    var render5 = '<div class="hidden-phone visible-desktop action-buttons">';
                    render5 += '<a href="/visits/view/' + full[6] + '" class="blue" data-rel="tooltip" data-placement="top" data-original-title="View"><i class="icon-zoom-in bigger-130"></i> </a> | ';
                    render5 += '<a href="/visits/delete/' + full[6] + '" class="red" data-rel="tooltip" data-placement="top" data-original-title="Delete"><i class="icon-trash bigger-130"></i> </a>';                                      
                    render5 +=  '</div>'
                  return render5;
                }
          } 
        ]
    });

    $('.image-list a').vanillabox();
    
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
    
    //Wrap pagination current item with an anchor tag
    $('.pagination .active').wrapInner('<a href="#"></a>');
                
    $('.actual-plan-chart').easyPieChart({
        scaleColor: false,
        lineWidth: 20,
        size: 200,
        easing: 'easeOutBounce',
        lineCap: 'circle',
        trackColor: '#f4f4f4',
        barColor: '#87b880'
    });
    
    
    var size = $('.actual-plan-chart').data('size');
    $('span.percent').css('position','relative');
    $('span.percent').css('height',size);
    $('span.percent').css('top',size / 2);
    
    $('.actual-target-chart').easyPieChart({
        scaleColor: false,
        lineWidth: 20,
        size: 200,
        easing: 'easeOutBounce',
        lineCap: 'circle',
        trackColor: '#f4f4f4',
        barColor: '#f99406'
    });
    
    $('.plan-target-chart').easyPieChart({
        scaleColor: false,
        lineWidth: 20,
        size: 200,
        easing: 'easeOutBounce',
        lineCap: 'circle',
        trackColor: '#f4f4f4',
        barColor: '#dc3813'
    });    
    
    var url =  config.URL + 'visits/visitperformance';
    function get_performance() {
        return $.ajax({
            url: url,
            data: param,
            dataType: 'JSON'
        });
    }
        
    var performance_value = get_performance();
    
    performance_value.success(function(performance_data) {
                
        $('#visit_performance_chart_2').highcharts({
            chart: {
                type: 'area'
            },
            title: {
                text: ''
            },
            //        subtitle: {
            //            text: 'Source: <a href="http://thebulletin.metapress.com/content/c4120650912x74k7/fulltext.pdf">'+
            //        'thebulletin.metapress.com</a>'
            //        },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            //            labels: {
            //                formatter: function() {
            //                    return this.value; // clean, unformatted number for year
            //                }
            //            }
            },
            yAxis: {
                title: {
                    text: 'No of Visits'
                },
                min: 0
            //            title: {
            //                text: 'Nuclear weapon states'
            //            },
            //            labels: {
            //                formatter: function() {
            //                    return this.value / 1000 +'k';
            //                }
            //            }
            },
            tooltip: {
                formatter: function() {
                    return this.y + ' <b>'+ this.series.name +'</b><br/>'+
                    'on ' + Highcharts.dateFormat('%e. %b', this.x);
                }
            },
            //        tooltip: {
            //            pointFormat: '{series.name} produced <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
            //        },
            plotOptions: {
                area: {
                    //                pointStart: 1940,
                    marker: {
                        enabled: false,
                        symbol: 'circle',
                        radius: 2,
                        states: {
                            hover: {
                                enabled: true
                            }
                        }
                    }
                }
            },
            series: [{
                name: 'Planned Visits',
                // Define the data points. All series have a dummy year
                // of 2012/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: performance_data.planned
            }, {
                name: 'Actual Visits',
                data: performance_data.actual
            }]
        });
    });

    
});
