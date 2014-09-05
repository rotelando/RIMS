var param = '';

$(function() {

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
    
    $('.image-list a').vanillabox();

    $('#ajax-loader').hide();
    $('.loadmore').on('click', function(){
        var loadmorebutton = $('.loadmore').clone(true);
        $('.loadmore').hide();
        $('#ajax-loader').show();
        
        $('#ui-loadmore').append("<p>............... Loaded.......................</p>"); 
    });

    //This helps to build the query parameters to be used in ajax calls for graphs etc.
function buildQueryParam(floc, fuser, fdate, sdate, edate) {

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
});

