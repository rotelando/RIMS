$(function() {

    try {
    $('.image-list a').vanillabox();
    } catch (e) {};

    //start Merchandizing data
    loadMerchandizeListData();

    editMerchandize();

    onLoadDeleteMerchandizeDialog();

    deleteMerchandize();


    function loadMerchandizeListData() {
        var meUrl =  config.URL + 'visibilityevaluations/get_list_data';
            //Get data list
            function get_list_data() {
                return $.ajax({
                    url: meUrl,
                    dataType: 'JSON'
                });
            }
            
            var list_data = get_list_data();
            brandelement_options = '';
            brand_options = '';

            list_data.success(function(data) {

                for (var i = 0; i < data.brands.length; i++) {

                    brand_options += '<option value="' + data.brands[i].id + '">' + data.brands[i].name + '</option>';
                }

                for (var i = 0; i < data.brandelements.length; i++) {

                    brandelement_options += '<option value="' + data.brandelements[i].id + '">' + data.brandelements[i].name + '</option>';
                }

                $('#brands').html(brand_options);
                $('#brandelements').html(brandelement_options);

            });
    }

    function  onLoadDeleteMerchandizeDialog() {
        $('.mer-delete').on('click', function(){
            var id = $(this).data('id');
            $('#del-id').val(id);
        });
    }

    function deleteMerchandize() {

        $('#delBtn').on('click', function(){
            
            var id = $('#del-id').val();
            var deUrl =  config.URL + 'visibilityevaluations/delete';
            var param = 'del-id=' + id;
            //delete data
            $.ajax({
                url: deUrl,
                data: param,
                type: 'POST',
                dataType: 'JSON',
                success: function(response) {
                    
                    if(response.status == 1) {
                        var alert = '<div class="alert alert-success fade in">';
                        alert += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                        alert += '<strong>Success!</strong> ' + response.message + '</div>';
                        $('#merch-not').html(alert);
                        var row = $('#tbl-merch tr[data-id=' + id + ']');
                        console.log(row);
                        $(row).remove();
                    } else {
                        var alert = '<div class="alert alert-success fade in">';
                        alert += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                        alert += '<strong>Error!</strong> ' + response.message + '</div>';
                        $('#merch-not').html(alert);
                    }

                    $('#mer-dialog-del').modal('hide');
                }
            });
        });
    }

    function editMerchandize() {
        $('.edit-merch').on('click', function(){

            $('div#mer-dialog > div.modal-header > h3').html('Edit Visibility Data');
            var trs = $(this).parent().parent().parent();
            var tds = trs.children("td");
            var tddata_1 = $(tds[1]).html().toString().trim();
            var tddata_2 = $(tds[2]).html().toString().trim();
            var tddata_3 = $(tds[3]).html().toString().trim();
            var id = $(this).data('id');

            $("select#brands option").each(function() { 
                this.selected = (this.text.toString().trim() == tddata_1.toString().trim()); 
            });

            $("select#brandelements option").each(function() { 
                this.selected = (this.text.toString().trim() == tddata_2.toString().trim()); 
            });

            $('#element_count').val(tddata_3);
            $('#id').val(id);
        });
    }


    $('.saveBtn').on('click', function(){
        saveMerchandize();
    });

    $('#add-merch').on('click', function(){
        $('div#mer-dialog > div.modal-header > h3').html('Add New Visibility Data');
        $('#id').val('');
    });


    function saveMerchandize() {
            
            var id = $('#id').val();
            var vid = $('#visitid').val();
            var bn = $('#brands').find('option:selected').val();
            var bn_text = $('#brands').find('option:selected').html();;
            var ben = $('#brandelements').find('option:selected').val();
            var ben_text = $('#brandelements').find('option:selected').html();;
            var amt = $('#element_count').val();
            
            console.log(bn + ' ' + bn_text + ' ' + ben + ' ' + ben_text + " " + vid + ' ' + amt);
            var meUrl =  config.URL + 'visibilityevaluations/save?';
            var param = 'id=' + id + '&vid=' + vid + '&bn=' + bn + '&ben=' + ben + '&amt=' + amt;
            
            //save data
            $.ajax({
                url: meUrl,
                data: param,
                dataType: 'JSON',
                success: function(response) {
                    if(response.status == 1) {

                        var alert = '<div class="alert alert-success fade in">';
                        alert += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                        alert += '<strong>Success!</strong> ' + response.message + '</div>';
                        $('#merch-not').html(alert);
                        var rid = response.data.Visibilityevaluation.id;
                        var rvid = response.data.Visibilityevaluation.visitid;
                        var rbrandname = response.data.Brand.brandname;
                        var rbrandelement = response.data.Brandelement.brandelementname;
                        var ramount = response.data.Visibilityevaluation.elementcount;

                        if(!id) {

                            var opentr = '<tr data-id="' + rid + '">';
                            var td0 = '<td>' + 'new' + '</td>';
                            var td1 = '<td>' + rbrandname + '</td>';
                            var td2 = '<td>' + rbrandelement + '</td>';
                            var td3 = '<td>' + ramount + '</td>';
                            var buttons = '<div class="hidden-phone visible-desktop action-buttons">';
                            buttons += '<a href="/visits/view/' + vid + '" class="blue" data-rel="tooltip" data-placement="top" data-original-title="Visit Details"><i class="icon-zoom-in bigger-130"></i></a> | ';
                            buttons += '<a href="#mer-dialog" data-id="' + rid + '" data-toggle="modal" class="green edit-merch" data-rel="tooltip" data-placement="top" data-original-title="Edit"><i class="icon-pencil bigger-130"></i></a> | ';
                            buttons += '<a href="#mer-dialog-del" data-id="' + rid + '" class="red mer-delete" data-toggle="modal" data-rel="tooltip" data-placement="top" data-original-title="Delete"><i class="icon-trash bigger-130"></i></a>';
                            buttons += '</div>';
                            var td4 = '<td>' + buttons + '</td>';
                            var closetr = '</tr>';

                            var table = $('#tbl-merch');
                            if(!table) {                    
                                $('#merch-not').html('');
                                $('#tbl-merch p').remove();          
                            }

                            $('#tbl-merch tbody').append(opentr + td0 + td1 + td2 + td3 + td4 + closetr);

                            


                        } else {

                            var row = $('#tbl-merch tr[data-id=' + rid + ']');
                            var rtds = $(row).children();
                            $(rtds[1]).html(rbrandname);
                            $(rtds[2]).html(rbrandelement);
                            $(rtds[3]).html(ramount);

                            var buttons = '<div class="hidden-phone visible-desktop action-buttons">';
                            buttons += '<a href="/visits/view/' + vid + '" class="blue" data-rel="tooltip" data-placement="top" data-original-title="Visit Details"><i class="icon-zoom-in bigger-130"></i></a> | ';
                            buttons += '<a href="#mer-dialog" data-id="' + rid + '" data-toggle="modal" class="green edit-merch" data-rel="tooltip" data-placement="top" data-original-title="Edit"><i class="icon-pencil bigger-130"></i></a> | ';
                            buttons += '<a href="#mer-dialog-del" data-id="' + rid + '" class="red mer-delete" data-toggle="modal" data-rel="tooltip" data-placement="top" data-original-title="Delete"><i class="icon-trash bigger-130"></i></a>';
                            buttons += '</div>';
                            $(rtds[4]).html(buttons);

                        }
                        
                        editMerchandize();

                        onLoadDeleteMerchandizeDialog();
                        deleteMerchandize();
                        $('#mer-dialog').modal('hide')

                    } else {

                    }
                }
            });
    }
    //end merchandizing data

    //start product availability

    //end product availability
        
});