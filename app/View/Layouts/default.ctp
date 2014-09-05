<!DOCTYPE html>
<html lang="en">


    <head>
        <!-- Mirrored from 192.69.216.111/themes/preview/ace/ by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 27 Aug 2013 11:13:06 GMT -->
        <!-- Added by HTTrack -->
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

        <meta />
        <title>FieldMax Pro Admin::<?php echo $title_of_page; ?></title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!--basic styles-->
        <?php echo $this->Html->css('bootstrap.min'); ?>
        <?php echo $this->Html->css('bootstrap-responsive.min'); ?>
        <?php echo $this->Html->css('font-awesome.min'); ?>

        <!--[if IE 7]>
          <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!--page specific plugin styles-->

        <!--fonts-->

        <!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />-->


        
        <!--ace styles-->


        <?php echo $this->Html->css('ace-responsive.min'); ?>
        <?php echo $this->Html->css('ace-skins.min'); ?>

        <!--[if lte IE 8]>
          <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
        <![endif]-->

        <!--inline styles related to this page-->

        <!--ace settings handler-->


        <?php echo $this->Html->css('daterangepicker'); ?>
        <?php echo $this->Html->css('bootstrap-timepicker'); ?>
        <?php echo $this->Html->css('datepicker'); ?>


        <?php echo $this->Html->css('/assets/jquery-minicolors/jquery.minicolors') ?>
        

        <?php echo $this->Html->css('/assets/js/minimalect/jquery.minimalect.min'); ?>

        <?php echo $this->Html->css('/assets/daterangepicker/daterangepicker-bs3'); ?>

        <?php echo $this->Html->css('/assets/datepicker/css/datepicker'); ?>
        <?php echo $this->Html->script('ace-extra.min'); ?>

        <?php echo $this->Html->css('ace.min'); ?>
        <?php echo $this->Html->css('multi-select'); ?>

        <?php echo $this->Html->css('mystyle'); ?>

        <?php //echo $this->Html->css('select2-3.4.8/select2'); ?>

        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">

        
        <?php 
        if(isset($active_item)):
            if ($active_item == 'images'): ?>
            <!--This should be loaded when images tab is clicked-->
                <?php echo $this->Html->css('/assets/js/vanillabox/theme/bitter/vanillabox'); ?>
            <?php elseif ($active_item == 'dashboard'): ?>
            <!--This should be loaded when images tab is clicked-->
                <?php echo $this->Html->css('/assets/js/vanillabox/theme/bitter/vanillabox'); ?>
            <?php elseif ($active_item == 'visits'): ?>
            <!--This should be loaded when images tab is clicked-->
                <?php echo $this->Html->css('/assets/js/vanillabox/theme/bitter/vanillabox'); ?>
            <?php elseif ($active_item == 'outlets'): ?>
            <!--This should be loaded when images tab is clicked-->
                <?php echo $this->Html->css('/assets/js/vanillabox/theme/bitter/vanillabox'); ?>
            <?php elseif ($active_item == 'calendars'): ?>
        <!--This should be loaded when calendar's tab is clicked-->
                <?php echo $this->Html->css('fullcalendar'); ?>
        
            <?php endif; ?>
        <?php endif; ?>

    </head>

    <body>

        <?php echo $this->element('top_nav_bar'); ?>


        <div class="main-container container-fluid">
            <a class="menu-toggler" id="menu-toggler" href="#">
                <span class="menu-text"></span>
            </a>

            <?php echo $this->element('sidebar'); ?>

            <?php echo $this->fetch('content'); ?>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
                <i class="icon-double-angle-up icon-only bigger-110"></i>
            </a>
        </div>

        <div id="footer">
            <div class="footercontent">
                <p class="muted credit">&copy; 2013. <a href="http://www.fieldmaxpro.com">All Right Reserved, 2013 &copy; Retail Information Management System (RIMS).</a></p>
            </div>
        </div>
        <!--basic scripts-->

        <!--[if !IE]>-->

        <!--<script src="../../../../ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>-->
        <?php echo $this->Html->script('jquery.min'); ?>

        <!--<![endif]-->

        <!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

        <!--[if !IE]>-->

        <script type="text/javascript">
            window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
        </script>

        <!--<![endif]-->

        <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <?php echo $this->Html->script('bootstrap.min'); ?>
        <!--<script src="assets/js/bootstrap.min.js"></script>-->


        <?php // echo $this->Html->script('ace.min'); ?>
        <?php // echo $this->Html->script('ace-elements.min'); ?>

        <?php //echo $this->Html->script('highchart/highcharts'); ?>
        <?php echo $this->Html->script('Highcharts-4.0.1/js/highcharts'); ?>

        <?php echo $this->Html->script('/assets/Maps/FusionCharts'); ?>
        <?php echo $this->Html->script('/assets/Maps/FusionCharts.jqueryplugin'); ?>
        
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
        
        <?php echo $this->Html->script('init'); ?>

        <?php
        // echo $this->Html->script('highchart/modules/exporting');
        if (isset($active_item)):
        ?>

            <?php if ($active_item == 'dashboard'): ?>
                <!--This should be loaded when dashboard tab is clicked-->
                <?php echo $this->Html->script('easy-pie-chart/jquery.easing.min'); ?>
                <?php echo $this->Html->script('easy-pie-chart/jquery.easypiechart.min'); ?>
                <?php echo $this->Html->script('vanillabox/jquery.vanillabox-0.1.5.min'); ?>
                <?php echo $this->Html->script('dashboard'); ?>
                
            <?php elseif ($active_item == 'visits'): ?>
                <!--This should be loaded when visits tab is clicked-->
                <?php echo $this->Html->script('easy-pie-chart/jquery.easing.min'); ?>
                <?php echo $this->Html->script('easy-pie-chart/jquery.easypiechart.min'); ?>
                <?php echo $this->Html->script('vanillabox/jquery.vanillabox-0.1.5.min'); ?>
                <?php echo $this->Html->script('visits'); ?>
                <?php echo $this->Html->script('visit-map'); ?>

            <?php elseif ($active_item == 'outlets'): 
//                This should be loaded when Outlets tab is clicked
                if($this->params['action'] == 'view') {
                    echo $this->Html->script('outlet-view');
                } else {
                    echo $this->Html->script('outlet-map');
                    echo $this->Html->script('outlets');
                }
                
                echo $this->Html->script('vanillabox/jquery.vanillabox');
                
                ?>
            
            <?php elseif ($active_item == 'settings'): ?>
                <!--This should be loaded when Settings tab is clicked-->
                <?php echo $this->Html->script('settings'); ?>
                <?php echo $this->Html->script('http://maps.google.com/maps/api/js?sensor=true', false); ?>
            
            <?php elseif ($active_item == 'visibilities'): ?>
                <!--This should be loaded when visibilities tab is clicked-->
                <?php echo $this->Html->script('visibilities'); ?>
                <?php echo $this->Html->script('http://maps.google.com/maps/api/js?sensor=true', false); ?>
            
            <?php elseif ($active_item == 'productavailabilities'): ?>
                <!--This should be loaded when productavailabilities tab is clicked-->
                <?php echo $this->Html->script('prodavail'); ?>
                <?php echo $this->Html->script('http://maps.google.com/maps/api/js?sensor=true', false); ?>
                
            <?php elseif ($active_item == 'orders'): ?>
                <!--This should be loaded when orders tab is clicked-->
                <?php echo $this->Html->script('easy-pie-chart/jquery.easing.min'); ?>
                <?php echo $this->Html->script('easy-pie-chart/jquery.easypiechart.min'); ?>
                <?php echo $this->Html->script('sales'); ?>
                <?php echo $this->Html->script('order-map'); ?>

            <?php elseif ($active_item == 'calendars'): ?>
                <!--This should be loaded when calendars tab is clicked-->
                <?php echo $this->Html->script('fullcalendar.min'); ?>
                <?php echo $this->Html->script('bootbox.min'); ?>
                <?php echo $this->Html->script('calendars'); ?>
                
            <?php elseif ($active_item == 'maps'): ?>
                <!--This should be loaded when maps tab is clicked-->
                <?php echo $this->Html->script('maps'); ?>
                <?php echo $this->Html->script('http://maps.google.com/maps/api/js?key=AIzaSyD9mvSGpeyg1gQqLiNr0nTFOstlNhuPx8g&sensor=true', false); ?>
                
            <?php elseif ($active_item == 'images'): ?>
                <!--This should be loaded when orders tab is clicked-->
                <?php echo $this->Html->script('vanillabox/jquery.vanillabox'); ?>
                <?php echo $this->Html->script('jquery.jscroll.min'); ?>
                <?php echo $this->Html->script('images'); ?>
                
            <?php endif; ?>
        <?php endif; ?>
                
        

        <?php echo $this->Html->script('select2-3.4.8/select2'); ?>
        <?php echo $this->Html->script('jquery-ui-1.10.3.custom.min'); ?>

        <?php echo $this->Html->script('jquery.ui.touch-punch.min'); ?>
        <?php echo $this->Html->script('jquery.slimscroll.min'); ?>

        <?php echo $this->Html->script('jquery.sparkline.min'); ?>
        <?php echo $this->Html->script('chosen.jquery.min'); ?>

        <?php echo $this->Html->script('date-time/bootstrap-datepicker.min'); ?>
        <?php echo $this->Html->script('date-time/bootstrap-timepicker.min'); ?>
        <?php echo $this->Html->script('date-time/moment.min'); ?>
        <?php echo $this->Html->script('date-time/daterangepicker.min'); ?>

        <?php echo $this->Html->script('/assets/datepicker/js/bootstrap-datepicker'); ?>

        <?php echo $this->Html->script('minimalect/jquery.minimalect.min'); ?>
        <?php echo $this->Html->script('papyrus-script'); ?>
        <?php echo $this->Html->script('/assets/jquery-minicolors/jquery.minicolors'); ?>
        <?php echo $this->Html->script('jquery.autocomplete.min'); ?>


        <!--This should be loaded when Settings tab is clicked-->
        <?php echo $this->Html->script('fuelux/fuelux.spinner.min'); ?>

        <?php //echo $this->Html->script('jquery.multi-select'); ?>

        <?php echo $this->Html->script('jquery.dataTables.min'); ?>
        <?php echo $this->Html->script('jquery.dataTables.bootstrap'); ?>

        
        <script type="text/javascript">

            //Wrap pagination current item with an anchor tag
            $('.pagination .active').wrapInner('<a href="#"></a>');

            var open = $('#toggleFilter').attr('data-open');
            if(open === "on") {
                $('#toggleFilter').attr('checked', true);
                $('.filter-bar').fadeIn(2000);
            } else {
                $('#toggleFilter').attr('checked', false);
                $('.filter-bar').fadeOut(10);
            }
            
            $('#toggleFilter').change(function() {

                if ($(this).is(":checked")) {
                    $('.filter-bar').fadeIn(2000);
                } else {
                    $('.filter-bar').fadeOut(10);
                }
            });

            $("#locationfilter").select2();

            //Map Toggle button
            $('#toggleMap').attr('checked', false);
            $('#gmap').css('visibility', 'hidden');
            $('#toggleMap').change(function() {

                if ($(this).is(":checked")) {
                    $('#fmap').css('visibility', 'hidden');
                    $('#gmap').css('visibility', 'visible');
                } else {
                    $('#gmap').css('visibility', 'hidden');
                    $('#fmap').css('visibility', 'visible');
                }
            });

            //This function is used to reset the filter values for another round of filtering
            //It uses the change function of the minimalect selection plugin
            $('#btnreset').on('click', function() {
                console.log('BtnReset');
                $("#filter-user").val("").change();
                $("#filter-location").val("").change();
                $("#filter-date").val("").change();
            });

            //Create new link when filter select inputs + dates are clicked
            function createNewLink(pKey, value) {
                var btnlink = $('#btnfilter').attr('href');
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
                $('#btnfilter').attr('href', btnlink);
            }

            $("#filter-user").minimalect({
                // theme: "bubble", 
                placeholder: "Select a staff",
                onchange: function(value) {
                    createNewLink('fuid', value);
                    $("#fusr").val(value);
                }
            });
            $("#filter-location").minimalect({
                placeholder: "Select a Location",
                onchange: function(value) {
                    createNewLink('floc', value);
                    $("#floc").val(value);
                }
            });
            $("#filter-date").minimalect({
                placeholder: "Select a Date",
                onchange: function(value) {
                    if (value == 'cust') {
                        $('#dateoption').css('display', 'block');
                        $('#dateoption').css('visibility', 'visible');
                    } else {
                        $('#dateoption').css('display', 'none');
                        $('#dateoption').css('visibility', 'hidden');
                    }
                    createNewLink('fdate', value);
                }
            });

            // $("#filter-all-user").minimalect({
            //     // theme: "bubble", 
            //     placeholder: "Select a staff",
            //     onchange: function(value) {
            //         //createNewLink('fuid', value);
            //         $("#fusr").val(value);
            //     }
            // });
            // $("#filter-all-location").minimalect({
            //     placeholder: "Select a Location",
            //     onchange: function(value) {
            //         //createNewLink('floc', value);
            //         $("#floc").val(value);
            //     }
            // });
            // $("#filter-all-date").minimalect({
            //     placeholder: "Select a Date",
            //     onchange: function(value) {
            //         if (value == 'cust') {
            //             $('#dateoption').css('display', 'block');
            //             $('#dateoption').css('visibility', 'visible');
            //         } else {
            //             $('#dateoption').css('display', 'none');
            //             $('#dateoption').css('visibility', 'hidden');
            //         }
            //         //createNewLink('fdate', value);
            //     }
            // });

            var nowTemp = new Date();
            var sdate = nowTemp;
            var edate = nowTemp;
            var sdatepicker = $('#sdate').datepicker({
                'format': 'dd-mm-yyyy'
            })
                    .on('show', function() {
                        $('#edate').datepicker('hide');
                    })
                    .on('changeDate', function(ev) {
                        if (ev.date.valueOf() > edate.valueOf()) {
                            alert('The start date can not be greater than the end date');
                            sdatepicker.setValue(sdate);
                        } else {
                            sdate = new Date(ev.date);
                            $('#edate').datepicker('show');
                            //                    $('#sdate').text($('#sdate, .startdatespan').data('date'));
                        }
                        $('#sdate').datepicker('hide');

                    });

            var edatepicker = $('#edate').datepicker({
                'format': 'dd-mm-yyyy'
            })
                    .on('changeDate', function(ev) {
                        if (ev.date.valueOf() < sdate.valueOf()) {
                            alert('The end date can not be less than the start date')
                            edatepicker.setValue(edate);
                        } else {
                            edate = new Date(ev.date);
                        }
                        $('#edate').datepicker('hide');
                    });

        </script> 

        <?php // echo $this->element('sql_dump');   ?>
    </body>

    
</html>