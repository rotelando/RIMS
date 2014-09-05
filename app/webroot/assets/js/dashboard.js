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


    $('#performance').highcharts({
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
    });

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