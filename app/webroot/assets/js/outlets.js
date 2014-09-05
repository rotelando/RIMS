
$(function() {

    try {
    $('.image-list a').vanillabox();
    } catch (e) {};
    
    //Query Parameter for filter box
    var floc = ''//$('#filter-location option:selected').val();
    var fuser = ''//$('#filter-user option:selected').val();
    var fdate = ''//$('#filter-date option:selected').val();
    var sdate = '';
    var edate = '';
    
    if(fdate === 'cust') {
        sdate = $('#sdate').val();
        edate = $('#edate').val();
    }
    
    var param = buildQueryParam(floc, fuser, fdate, sdate, edate);
    
    //Wrap pagination current item with an anchor tag
    $('.pagination .active').wrapInner('<a href="#"></a>');
    
    //Outlet Distribution Data
    var url =  config.URL + 'outlets/outletdistribution';
    function get_outlet_distribution() {
        return $.ajax({
            url: url,
            data: param,
            dataType: 'JSON'
        });
    }
        
    var outlet_distribution = get_outlet_distribution();
    
    outlet_distribution.success(function(distribution_data) {
        $('#advocacy_class').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Advocacy Class'
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
                name: 'Advocacy Class',
                data: distribution_data
            }]
        });
    });
    
    //Outlet Distribution Data
    url =  config.URL + 'outlets/outletchanneldistribution';
    function get_outlet_channel_distribution() {
        return $.ajax({
            url: url,
            data: param,
            dataType: 'JSON'
        });
    }
        
    var outlet_channel_distribution = get_outlet_channel_distribution();
    
    outlet_channel_distribution.success(function(distribution_data) {
    $('#outlet_channels').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Channel Classification'
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
                name: 'Channel',
                data: distribution_data.channel_dist
            }]
        });
        
        $('#outlet_retail').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Retail Type'
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
                name: 'Retail Type',
                data: distribution_data.retailer_dist
            }]
        });
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
    
    
    //data tables
    var oTable1 = $('#sample-table-2').dataTable();

    $('table th input:checkbox').on('click' , function(){
        var that = this;
        $(this).closest('table').find('tr > td:first-child input:checkbox')
        .each(function(){
                this.checked = that.checked;
                $(this).closest('tr').toggleClass('selected');
        });
    });


    $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
    function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
    }


    var outletDataTable = initializeOutletDataTables();


    function initializeOutletDataTables() {
        var all_outlets_url = config.URL + "outlets/loadall";

        var outletTables = $('#outlet_all_table').DataTable( {
            "lengthMenu": [ 25, 50, 75, 100 ],
            //"pagingType": "full_numbers",
            "order": [[ 6, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": all_outlets_url,
               "type": "POST"
            },
            "columnDefs": [ 
                {
                    "targets": 7,
                    "data": "id",
                    "render": function ( data, type, full, meta ) {
                        
                        var link = '<div class="hidden-phone visible-desktop action-buttons">';
                        link += '<a href="/outlets/view/' + full[7] + '" class="blue" data-rel="tooltip" data-placement="top" data-original-title="View"><i class="icon-zoom-in bigger-130"></i> </a> | ';
                        link += '<a href="/outlets/delete/' + full[7] + '" class="red" data-rel="tooltip" data-placement="top" data-original-title="Delete"><i class="icon-trash bigger-130"></i> </a>';                                      
                        link +=  '</div>'
                      return link;
                    }
                },
                {
                    "targets": [ 8, 9, 10, 11 ],
                    "visible": false,
                    "searchable": true
                }
            ]
        });

        return outletTables;
    }

    $("#filter-all-user").minimalect({
            // theme: "bubble", 
        placeholder: "Select a staff",
        onchange: function(value, text) {
            
            outletDataTable.columns(1).search( text, false, false ).draw();
            console.log('value:' + value + ' text:' + text);
        }
    });
    $("#filter-all-location").minimalect({
        placeholder: "Select a Location",
        onchange: function(value, text) {
            
            var locType = value.split('_');
            if(locType[0] === 'nat') {
                outletDataTable.columns(11).search( text ).draw();                
            } else if(locType[0] === 'reg') {
                outletDataTable.columns(10).search( text ).draw();                
            } else if(locType[0] === 'sta') {
                outletDataTable.columns(9).search( text ).draw();                
            } else if(locType[0] === 'loc') {
                outletDataTable.columns(2).search( text ).draw();                
            }

            console.log('value:' + value + ' text:' + text);
        }
    });
    $("#filter-all-date").minimalect({
        placeholder: "Select a Date",
        onchange: function(value) {
            

            if(value == 'yes') {
                console.log('OnChange: ' + value)
                outletDataTable.draw();

            } else if (value == 'cust') {
                $('#dateoption').css('display', 'block');
                $('#dateoption').css('visibility', 'visible');
            } else {
                $('#dateoption').css('display', 'none');
                $('#dateoption').css('visibility', 'hidden');
            }
            
        }
    });


    function getDateString(now) {
        var yyyy = now.getFullYear();
        var mth = now.getMonth() + 1;
        var mm = (mth > 9) ? mth : ('0' + mth);
        var dd = (now.getDate() > 9) ? now.getDate() : ('0' + now.getDate()) ;
        var formatedNowDate = yyyy + '-' + mm + '-' + dd + ' 00:00:00';
        return formatedNowDate;
    }

    //reset the filter values
    $('#btnallreset').on('click', function() {
        $("#filter-all-user").val("").change();
        $("#filter-all-location").val("").change();
        $("#filter-all-date").val("").change();
        
        outletDataTable.columns(1).search( '' ).draw();
        outletDataTable.columns(2).search( '' ).draw();
        outletDataTable.columns(6).search( '' ).draw();
        outletDataTable.columns(9).search( '' ).draw();
        outletDataTable.columns(10).search( '' ).draw();
        outletDataTable.columns(11).search( '' ).draw();
        
    });

});

//range search
$.fn.dataTable.ext.search.push(
function( settings, data, dataIndex ) {
        
        var now = new Date();
        var endDate = getDateString(now);
        console.log('Todays date: ' + endDate);
        now.setDate(now.getDate() - 1);
        var startDate = getDateString(now);
        console.log('From date: ' + startDate);
        var value = $("#filter-all-date option:selected").val();
        console.log('Value: ' + value);
        var created = data[6]; // use data for the age column
 
        if ( created >= startDate && endDate <= endDate )
        {
            return true;
        }

        return false;
    }
);