
//Query Parameter for filter box
/*var floc = $('#filter-location option:selected').val();
var fuser = $('#filter-user option:selected').val();
var optionvalues = $.map( $('#filter-retailtype option:selected'),
    function(e) {
        return $(e).val();
    });
var fret = optionvalues.join(',');
var fdate = $('#filter-date option:selected').val();
var sdate = '';
var edate = '';

$('input[name=custdate]').on('apply.daterangepicker', function(ev, picker) {
    sdate = picker.startDate.format('YYYY-MM-DD');
    edate = picker.endDate.format('YYYY-MM-DD');
});

if(fdate !== 'cust') {
    sdate = '';
    edate = '';
}

var param = buildQueryParam(floc, fuser, fret, fdate, sdate, edate);
console.log(param);*/


$(function() {

    //var _s = require('underscore.string');

    try {
    $('.image-list a').vanillabox();
    } catch (e) {};

    var param = $('#getparam').val();
    if(typeof param == 'undefined') {
        param = '';
    }
    console.log(param);

    //Wrap pagination current item with an anchor tag
    $('.pagination .active').wrapInner('<a href="#"></a>');
    
    //Outlet Distribution Data
    var url =  config.URL + 'outlets/outletclassdistribution';
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
                text: 'Outlet Type'
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
                name: 'Outlet Type',
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
            var $parent = $source.closest('table');
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
    }


    showLoader();
    getOutlets(param);

    function getOutlets(param) {

        var all_outlets_url = config.URL + "outlets/paginatedoutlets";

        showLoader();
        $.ajax({

            url: all_outlets_url,
            type: 'GET',
            data: param,
            dataType: 'JSON',
            success: function(data){

                console.log(data);
                createTableFromResponse(data);

            }
        });

    }

    function createTableFromResponse(data) {

        $('#all_outlet_table').html('');

        createTableHead();

        createTableBody(data.outlets);

        createPaginationLinks(data.pagination);

        hideLoader();
    }

    function createTableHead () {

        var thead = '<thead>';
        thead += '<tr>';
        thead += '<th> Name</th>';
        thead += '<th width="10%"> Added by</th>';
        thead += '<th width="10%"> Location </th>';
        thead += '<th width="10%"> Phone Number </th>';
        thead += '<th width="10%"> Type </th>';
        thead += '<th width="17%"> Retailtype </th>';
        thead += '<th width="13%"> Date Added </th>';
        thead += '<th width="10%" style="text-align: center"> Actions </th>';
        thead += '</tr>';
        thead += '</thead>';

        $('#all_outlet_table').append(thead);
    }

    function createTableBody (data) {

        var tbody = '<tbody>';
        for(var i = 0; i < data.length; i++) {
            tbody += '<tr>';
            //tbody += '<td>' + _s.capitalize(data[i].Outlet.outletname) + '</td>';
            tbody += '<td>' + data[i].Outlet.outletname + '</td>';
            tbody += '<td>' + data[i].User.username + '</td>';
            tbody += '<td>' + data[i].Location.locationname + '</td>';
            tbody += '<td>' + data[i].Outlet.contactphonenumber + '</td>';
            tbody += '<td>' + data[i].Outletclass.outletclassname + '</td>';
            tbody += '<td>' + data[i].Retailtype.retailtypename + '</td>';
            tbody += '<td>' + data[i].Outlet.created_at + '</td>';
            var link = '<div class="hidden-phone visible-desktop action-buttons">';
            link += '<a href="/outlets/view/' + data[i].Outlet.id + '" class="blue" data-rel="tooltip" data-placement="top" data-original-title="View"><i class="icon-zoom-in bigger-130"></i> </a> | ';
            link += '<a href="/outlets/delete/' + data[i].Outlet.id + '" class="red" data-rel="tooltip" data-placement="top" data-original-title="Delete"><i class="icon-trash bigger-130"></i> </a>';
            link +=  '</div>';
            tbody += '<td>' + link + '</td>';
            tbody += '</tr>';
            console.log('got here' + data[i].Outlet['outletname']);
        }
        tbody += '</tbody>';
        $('#all_outlet_table').append(tbody);
    }

    function isDefined(value) {

        return (typeof value !== 'undefined');
    }

    //sample data: {"first":0, "last":29, "previous":0, "next":1, "currentPage":0, "links_label":[0,1,2,3,4],"total_items":"292"}}}
    function createPaginationLinks(pagObject) {

        var pag = {
            first: 0,
            last: 0,
            prev: 0,
            next: 0,
            curr: 0,
            total: 0,
            links_label: [],
            html: ''
        };



        if(isDefined(pagObject.total_items)) pag.total = parseInt(pagObject.total_items); //only this is returned as a string

        if(isDefined(pagObject.first)) pag.first = pagObject.first;

        if(isDefined(pagObject.previous)) pag.prev = pagObject.previous;

        if(pag.total != 0) {

            if (pag.prev == pag.first) {

                pag.html += '<li class="disabled"><a href="#" data-page="' + pag.first + '">&laquo;</a></li>';
                pag.html += '<li class="disabled"><a href="#" data-page="' + pag.prev + '">&lsaquo;</a></li>';

            } else {

                pag.html += '<li><a href="#" data-page="' + pag.first + '">&laquo;</a></li>';
                pag.html += '<li><a href="#" data-page="' + pag.prev + '">&lsaquo;</a></li>';
            }

            if (isDefined(pagObject.currentPage)) pag.curr = parseInt(pagObject.currentPage);

            if (isDefined(pagObject.links_label)) pag.links_label = pagObject.links_label;

            var len = pag.links_label.length;
            var iPageLabel;

            for (var i = 0; i < len; i++) {

                iPageLabel = parseInt(pag.links_label[i]);

                if (iPageLabel == pag.curr) {

                    pag.html += '<li class="active"><a href="#" data-page="' + iPageLabel + '">' + (iPageLabel + 1) + '</a></li>';

                } else {

                    pag.html += '<li><a href="#" data-page="' + iPageLabel + '">' + (iPageLabel + 1) + '</a></li>';
                }
            }


            if (isDefined(pagObject.last)) pag.last = parseInt(pagObject.last);

            if (isDefined(pagObject.next)) pag.next = parseInt(pagObject.next);

            if (pag.last == pag.next) {

                pag.html += '<li class="disabled"><a href="#" data-page="' + pag.next + '">&rsaquo;</a></li>';
                pag.html += '<li class="disabled"><a href="#" data-page="' + pag.last + '">&raquo;</a></li>';

            } else {

                pag.html += '<li><a href="#" data-page="' + pag.next + '">&rsaquo;</a></li>';
                pag.html += '<li><a href="#" data-page="' + pag.last + '">&raquo;</a></li>';
            }
        }

        console.log(pag.html);

        $('div.pagination ul').html(pag.html);

        //get page size
        var pageSize = $('#pgSize').find('option:selected').val();

        pageSize = parseInt(pageSize);

        var pag_text = '';

        if(pag.total == 0) {

            pag_text = "<strong>No Result found!</strong>";

        } else {

            if(pag.total < pageSize) {

                var start = 1;
                var end = pag.total;
                var total = pag.total;
                if(total > 1) {
                    var item_text = "items";
                } else {
                    var item_text = "item";
                }
                pag_text = 'Showing <strong>' + 1 + '</strong> to <strong>' + end + '</strong> of <strong>' + total + '</strong> ' + item_text;
            } else {

                var start = pag.curr * pageSize;
                var end = start + pageSize;
                if(end > pag.total) end = pag.total;

                var total = pag.total;
                if(total > 1) {
                    var item_text = "items";
                } else {
                    var item_text = "item";
                }
                pag_text = 'Showing <strong>' + (start+1) + '</strong> to <strong>' + end + '</strong> of <strong>' + total + '</strong> ' + item_text;
            }


        }

        //set the pagination text showing at the top and/or bottom
        $('h4.text-info').html(pag_text);

        //register the click event for any of the bottom pager links clicked!
        $('div.pagination ul li a').on('click', function(event) {

            //get the page number from the bottom pager links
            var pg = $(this).attr('data-page');

            //pass the page number to be fetched to the refresh button and trigger its click event
            createNewLink('page', pg);
            var param = $('#getparam').val();
            getOutlets(param);
            $("html, body").delay(1000).animate({scrollTop: $('#top_page').offset().top }, 1000);
            event.preventDefault();
        });
    }


    $('#pgSize').on('change', function() {

        var pgSize = $(this).find('option:selected').val();
        createNewLink('page', 0);
        createNewLink('pgSize', pgSize);
        var param = $('#getparam').val();
        getOutlets(param);

    });

    $('#q').on("keypress", function(e) {
        if (e.keyCode == 13) {
            var q = $(this).val();
            createNewLink('page', 0);
            createNewLink('q', q);
            var param = $('#getparam').val();
            getOutlets(param);
            return false; // prevent the button click from happening
        }
    });

    /*$('#btnOutletfilter').on('click', function(){
        createNewLink('page', 0);
        var param = $('#getparam').val();
        getOutlets(param);
        return false
    });
    $('#btnPhonefilter').on('click', function(){
        createNewLink('page', 0);
        var param = $('#getparam').val();
        getOutlets(param);
        return false
    });*/

    function getDateString(now) {
        var yyyy = now.getFullYear();
        var mth = now.getMonth() + 1;
        var mm = (mth > 9) ? mth : ('0' + mth);
        var dd = (now.getDate() > 9) ? now.getDate() : ('0' + now.getDate()) ;
        var formatedNowDate = yyyy + '-' + mm + '-' + dd + ' 00:00:00';
        return formatedNowDate;
    }

    //Create new link when filter select inputs + dates are clicked
    function createNewLink(pKey, value) {
        var btnlink = $('#getparam').val() || '';
        if (btnlink == '')
            btnlink += pKey + '=' + value;
        else if (btnlink.indexOf(pKey) == -1) {
            btnlink += '&' + pKey + '=' + value;
        } else {
            var lPos = btnlink.indexOf(pKey);
            var amper = btnlink.indexOf('&', lPos + 1);
            var fullstr = '';
            if (amper == -1) {
                fullstr = btnlink.substr(lPos, btnlink.length);
                btnlink = btnlink.replace(fullstr, pKey + '=' + value);
            }
            else {
                fullstr = btnlink.substr(lPos, amper - lPos);
                btnlink = btnlink.replace(fullstr, pKey + '=' + value);
            }
        }
        $('#getparam').val(btnlink);
        console.log('getparam: ' + btnlink);
    }

    function showLoader() {

        $('#ajax-loader').html('<img src="/assets/images/ajax-loader.gif" />');
    }

    function hideLoader() {

        $('#ajax-loader').html('');
    }
});