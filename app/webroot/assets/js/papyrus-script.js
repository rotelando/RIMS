/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {

    //$("#filter-user").multipleSelect();
    //$("#filter-location").multipleSelect();
    $("#filter-user").chosen({width: "170px"}).on('change', function() {
        var value = $(this).find('option:selected').val();
        createNewLink('fuser', value);
    });

    $("#filter-location").chosen({width: "170px"}).on('change', function() {
        var value = $(this).find('option:selected').val();
        createNewLink('floc', value);
    });

    $("#filter-retailtype").chosen({width: "170px"}).on('change', function() {
        var optionvalues = $.map( $('#filter-retailtype option:selected'),
            function(e) { return $(e).val(); } );
        var value = optionvalues.join(',');
        createNewLink('fret', value);
    });


    $("#filter-noType").chosen({width: "170px"}).on('change', function() {
        var value = $(this).find('option:selected').val();
        createNewLink('noType', value);
    });

    var $dateFilter = $("#filter-date").chosen({
        width: "215px",
        disable_search_threshold: 10
    }).on('change', function() {

        var value = $(this).find('option:selected').val();
        if (value === 'cust') {
            $('#dateoption').show();
        } else {
            $('#dateoption').hide();
        }
        createNewLink('fdate', value);
    });

    var $daterange = $('input[name=custdate]').daterangepicker(
        {
            format: 'YYYY/MM/DD',
            'applyClass' : 'btn-sm btn-success',
            'cancelClass' : 'btn-sm btn-default',
            locale: {
                applyLabel: 'Apply',
                cancelLabel: 'Cancel'
            }
        },
        function(startDate, endDate) {
            var start = startDate.format('YYYY-MM-DD');
            var end = endDate.format('YYYY-MM-DD');
            createNewLink('sdate', start);
            createNewLink('edate', end);
        }

    ).prev().on(ace.click_event, function(){
            $(this).next().focus();
        });

    $('#dateoption').hide();

    //This function is used to reset the filter values for another round of filtering
    //It uses the change function of the minimalect selection plugin
    $('#btnreset').on('click', function() {
        console.log('BtnReset');
        $("#filter-user").val("").trigger("chosen:updated");
        $("#filter-location").val("").trigger("chosen:updated");
        $("#filter-retailtype").val("").trigger("chosen:updated");
        $("#filter-noType").val("").trigger("chosen:updated");
        $("#filter-date").val("").trigger("chosen:updated");
        $("#getparam").val("");
    });

    //Create new link when filter select inputs + dates are clicked
    /*function createNewLink(pKey, value) {
        var btnlink = $('#getparam').val() || '';
        if (btnlink.indexOf('?') == -1)
            btnlink += '?' + pKey + '=' + value;
        else if (btnlink.indexOf(pKey) == -1) {
            btnlink += '&' + pKey + '=' + value;
        } else {
            var lPos = btnlink.indexOf(pKey);
            var amper = btnlink.indexOf('&', lPos + 1);
            var fullstr = '';
            if (amper == -1) {
                fullstr = btnlink.substr(lPos, btnlink.length - 1);
                btnlink = btnlink.replace(fullstr, '');
                btnlink += pKey + '=' + value;
            }
            else {
                fullstr = btnlink.substr(lPos, amper - lPos + 1);
                btnlink = btnlink.replace(fullstr, '');
                btnlink += '&' + pKey + '=' + value;
            }
        }
        $('#getparam').val(btnlink);
        console.log('getparam: ' + btnlink);
    }*/
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

    var all_users_url = config.URL + "users/loadusers";

    //open the add license dialog modal
    $('#addlicence').on('click', function() {
        $('#userlicence').modal();
    });

    function deactivateUser() {
        //Activation / Deactivation dialog
        $('.deactivateuser').on('click', function() {
            var url = "";
            var activationtitle = 'Deactivate User';
            var activationbody = 'This action will deactivate this user. Continue?';
            url = $(this).attr('href').toString();

            if (url.indexOf('deactivate') === -1) {
                activationtitle = 'Activate User';
                activationbody = 'This action will activate this user. Continue?';
            }
            $('#myModalLabel').html(activationtitle);
            $('.useractivationbody p strong').html(activationbody);
            $('#deactivatebtn').attr('href', url);
            $('#deactivateuser').modal();
        });
    }

    $('#usestate').on('click', function() {
        if ($(this).is(':checked')) {
            $('#LocationLocationname').attr('disabled', true);
        } else {
            $('#LocationLocationname').attr('disabled', false);
        }
    });

//    alert("Am in!");
    //Check availability of Outlet types
    var content = $('#OutlettypeTypename').val();

    $('#OutlettypeOutlettypename').keyup(checkavailability);

    function checkavailability() {

        if ($('#OutlettypeOutlettypename').val() != content) {
            content = $('#OutlettypeOutlettypename').val();
            var url = config.URL + 'outlettypes/exists/' + content;
            $.getJSON(url, function(data) {
                if (data.meta.status) {
                    $('.input.text').append('<div class="error-message" style="width: 70%;">' + data.meta.message + '</div>');
                    $('form button').css('visibility', 'collapse');
                } else {
                    $('.error-message').remove();
                    $('form button').css('visibility', 'visible');
                }
            });
        }
    }

    $('#id-date-range-picker-1').daterangepicker().prev().on(ace.click_event, function() {
        $(this).next().focus();
    });

    $('#reportrange').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().subtract('days', 29),
                endDate: moment()
            },
    function(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    );


    var sUrl = config.URL + 'locations/states';
    function getStates() {
        var states = [];
        $.ajax({
            url: sUrl,
            dataType: "json",
            async: false,
            success: function(data) {
                states = $.map(data.states, function(item) {
                    return {
                        value: item.State.statename,
                        data: item.State.statename
                    }
                });
            }
        });

        //        alert(states[0].value);
        return states;
    }

    var rUrl = config.URL + "locations/regions";
    function getRegions() {
        var regions = [];
        $.ajax({
            url: rUrl,
            dataType: "json",
            async: false,
            success: function(data) {
                regions = $.map(data.regions, function(item) {
                    return {
                        value: item.Region.regionname,
                        data: item.Region.regionname
                    }
                });
            }
        });
        return regions;
    }

    $('#LocationState').autocomplete({
        lookup: getStates(),
        onSelect: function(suggestion) {
            var thehtml = '<strong>Currency Name:</strong> ' + suggestion.value + ' <br> <strong>Symbol:</strong> ' + suggestion.data;
            $('#outputcontent').html(thehtml);
        }
    });

    $('#LocationRegion').autocomplete({
        lookup: getRegions(),
        onSelect: function(suggestion) {
            var thehtml = '<strong>Currency Name:</strong> ' + suggestion.value + ' <br> <strong>Symbol:</strong> ' + suggestion.data;
            $('#outputcontent').html(thehtml);
        }
    });


    $.minicolors = {
        defaults: {
            animationSpeed: 50,
            animationEasing: 'swing',
            change: null,
            changeDelay: 0,
            control: 'hue',
            defaultValue: '',
            hide: null,
            hideSpeed: 100,
            inline: false,
            letterCase: 'lowercase',
            opacity: false,
            position: 'bottom left',
            show: null,
            showSpeed: 100,
            theme: 'default'
        }
    };

    $('INPUT.minicolors').minicolors();


    //For Popovers and Tooltips
    $('[data-rel=tooltip]').tooltip({
        container: 'body'
    });
    $('[data-rel=popover]').popover({
        container: 'body'
    });

    $('#add_selectall').click(function() {
        var classname = $(this).attr('class');
        var selector = '.' + classname;
        if (this.checked) {

            $(selector).each(function(index) {
                $(this).attr('checked', true);
            });

        } else {

            $(selector).each(function(index) {
                $(this).attr('checked', false);
            });
//            $(selector).attr('checked', false);
        }
    });

    mapStateFunction('');
    var stateurl = config.URL + 'states/mapdata';
    var mapurl = config.URL + "assets/Maps/FCMap_Nigeria.swf";
        $("#statesMapContainer").insertFusionCharts({
        swfUrl: mapurl,
        dataSource: stateurl,
        dataFormat: "jsonurl",
        width: "100%",
        height: "650",
        id: "myMapId"
    });


    $('.deletestate').on('click', function() {

        var deleteurl = $(this).attr('href');
        $.ajax({
            url: deleteurl,
            dataType: 'json',
            cache: false
        });

        $(this).parent().parent().remove();
    });

    //tree view

//    $('#tree1').ace_tree({
//        dataSource: treeDataSource,
//        multiSelect: true,
//        loadingHTML: '<div class="tree-loading"><i class="icon-refresh icon-spin blue"></i></div>',
//        'open-icon': 'icon-minus',
//        'close-icon': 'icon-plus',
//        'selectable': true,
//        'selected-icon': 'icon-ok',
//        'unselected-icon': 'icon-remove'
//    });
//
//    $('#tree2').ace_tree({
//        dataSource: treeDataSource2,
//        loadingHTML: '<div class="tree-loading"><i class="icon-refresh icon-spin blue"></i></div>',
//        'open-icon': 'icon-folder-open',
//        'close-icon': 'icon-folder-close',
//        'selectable': false,
//        'selected-icon': null,
//        'unselected-icon': null
//    });



    /**
     $('#tree1').on('loaded', function (evt, data) {
     });

     $('#tree1').on('opened', function (evt, data) {
     });

     $('#tree1').on('closed', function (evt, data) {
     });

     $('#tree1').on('selected', function (evt, data) {
     });
     */
});

    
function mapStateFunction(id) {

    var vaurl = config.URL + 'states/select/' + id;
    function add_and_get_states() {
        return $.ajax({
            url: vaurl,
            dataType: 'json',
            cache: false
        });
    }
    var selectedstates = add_and_get_states();

    selectedstates.success(function(statelists) {
        var html = '';
        for (var p = 0; p < statelists.length; p++) {

            html += '<tr>';
            html += '<td>' + (p + 1) + '</td>';
            html += '<td>' + statelists[p].State.statename + '</td>';
            html += '<td>' + statelists[p].State.shortname + '</td>';
            html += '<td><a onclick="{return false;}" class="red deletestate" href="states/delete/' + statelists[p].State.id + '" data-rel="tooltip" data-placement="top"' +
                    ' data-original-title="Delete"><i class="icon-trash bigger-130"></i></a></td>';
            html += '</tr>';
        }

        $('table tbody').html(html);

        $('.deletestate').on('click', function() {

            var deleteurl = $(this).attr('href');
            $.ajax({
                url: deleteurl,
                dataType: 'json',
                cache: false
            });
            $(this).parent().parent().remove();
        });
    });
}

//Create new link when filter select inputs + dates are clicked
function createLink(pKey, value, buttonselector) {
    var btnlink = $(buttonselector).attr('href');
    if (btnlink.indexOf('?') == -1)
        btnlink += '?' + pKey + '=' + value;
    else if (btnlink.indexOf(pKey) == -1) {
        btnlink += '&' + pKey + '=' + value;
    } else {
        var lPos = btnlink.indexOf(pKey);
        var amper = btnlink.indexOf('&', lPos + 1);
        var fullstr = '';
        if (amper == -1) {
            fullstr = btnlink.substr(lPos, btnlink.length - 1);
            btnlink = btnlink.replace(fullstr, '');
            btnlink += pKey + '=' + value;
        }
        else {
            fullstr = btnlink.substr(lPos, amper - lPos + 1);
            btnlink = btnlink.replace(fullstr, '');
            btnlink += '&' + pKey + '=' + value;
        }
    }
    $(buttonselector).attr('href', btnlink);
}

$("#fieldrepid-1").minimalect({
    //     theme: "bubble", 
    placeholder: "Select a staff",
    onchange: function(value) {

        createLink('id1', value, '#btnstaffcompare');
    }
});
$("#fieldrepid-2").minimalect({
    //     theme: "bubble", 
    placeholder: "Select a staff",
    onchange: function(value) {
        createLink('id2', value, '#btnstaffcompare');
    }
});
$("#fieldrepid-3").minimalect({
    //     theme: "bubble", 
    placeholder: "Select a staff",
    onchange: function(value) {
        createLink('id3', value, '#btnstaffcompare');
    }
});
$("#fieldrepid-4").minimalect({
    //     theme: "bubble", 
    placeholder: "Select a staff",
    onchange: function(value) {
        createLink('id4', value, '#btnstaffcompare');
    }
});
$("#fieldrepid-5").minimalect({
    //     theme: "bubble", 
    placeholder: "Select a staff",
    onchange: function(value) {
        createLink('id5', value, '#btnstaffcompare');
    }
});

var clickcount = 0;
$('.staffselect').click(function() {

    if ($(this).is(':checked')) {
        if (clickcount > 5) {
            alert('Checkbox count more than 5');
            $(this).attr('checked', false);
            return;
        } else {
            ++clickcount;
        }
    } else {
        if (clickcount != 0)
            --clickcount;
        else
            return;
    }

    var sid = $(this).data('id');
    createLink('id' + clickcount, sid, '#fieldstaffcompare');

});

$('[data-rel=tooltip]').tooltip({
    container: 'body'
});
$('[data-rel=popover]').popover({
    container: 'body'
});

//This helps to build the query parameters to be used in ajax calls for graphs etc.
function buildQueryParam(floc, fuser, fret, fdate, sdate, edate) {

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

    if (fret !== '') {
        if (param === '') {
            param += 'fret=' + fret;
        }
        else {
            param += '&fret=' + fret;
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

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}