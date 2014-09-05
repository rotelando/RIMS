<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">

            <h1>
                Calendar
                <small>
                    <i class="icon-double-angle-right"></i>
                    planned visits
                    <?php 
                            if(isset($filtertext) && $filtertext != '') {
                                echo " [Filter: {$filtertext}]";
                            }
                        ?>
                </small>
                <div class="pull-right">
                    <form class="form-inline">
                        <label>Filter </label>            
                        <label>
                            <input id="toggleFilter" 
                                   <?php 
                                if(isset($filtertext) && $filtertext != '') {
                                    echo 'data-open="on"'; 
                                } else {
                                    echo 'data-open="off"'; 
                                }    ?> 
                                   name="toggleFilter" class="ace ace-switch ace-switch-4" type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </form>
                </div>
            </h1>

        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <?php echo $this->element('filter_bar'); ?>

        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->

                <div class="row-fluid">
                    <div class="span7">
                        <?php
                         echo $this->Html->link('<i class="icon-plus"></i> Schedule Visit',
                                    array('action'=>'schedulevisit'),
                                    array('class'=>'btn btn-mini btn-success', 'escape'=>false)); 
                        ?>
                        <div class="space"></div>

                        <div id="calendar"></div>
                    </div>

                    <div class="span5">
                        <div class="widget-box transparent">
                            <div class="widget-header" id="detailsheader">
                                <h3 class="text-success">Details</h3>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="calendar-details">
                                        <h4>Total Planned Visits</h4>
                                        <p id="vcount"><?php echo $visitcount; ?></p>
                                        <h4>Total Actual Visits</h4>
                                        <p id="scount"><?php echo $schedulecount; ?></p>
                                        <h4>Total Outlet Count</h4>
                                        <p id="ocount"><?php echo $outletcount; ?></p>
                                        <hr />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                                    <!--PAGE CONTENT ENDS-->
                                </div><!--/.span-->
                            </div><!--/.row-fluid-->

                        </div><!--/.page-content-->
                    </div><!--/.main-content-->
                    
                    
<div id="calendarclick" class="modal hide fade" style="width: 350px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel" class="calendardetailtitle">  </h5>
    </div>
    <!-- Start Modal Body -->
    <div class="modal-body oncalendarclick">
        
        <div id="cal-outlets"></div>
        <br />
        <br />
    </div>   
    <!-- End Modal Body -->
</div>

<?php echo $this->Html->script('/assets/bootstrap/bootstrap-modal'); ?>