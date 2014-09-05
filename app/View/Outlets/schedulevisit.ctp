<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">

            <h1>
                Outlets Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    creation and views
                </small>
            </h1>

        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <?php echo $this->element('filter_bar'); ?>

        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->

                <div class="row-fluid">
                    <div class="span12">
                        
                        <?php echo $this->Form->create('Calendar', array('method' => 'POST', 'controller' => 'calendars', 'action' => 'schedulevisit', 'class' => 'form-horizontal')); ?>
                        
                        <fieldset class="default">
                            <legend>Schedule a visit</legend>
                            <div class="span5">
                                <div class="control-group">
                                    <label class="control-label">Outlet Name</label>
                                    <div class="controls">
                                        <?php echo $this->Form->select('outletid', $outlets, array('class' => 'span3', 'id' => 'schedule-outlets'));
                                        ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Scheduled Date</label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('scheduledate', array('placeholder' => 'Pick a Date', 
                                            'class' => 'datepicker input-small input-mask-date',
                                            'id' => 'scheduledate',
                                            'label' => false,
                                            'type'=>'text', 
                                            'readonly')); 
                                        ?>
                                        <!--<input type="text" name="firstname" placeholder="Firstname" class="span5 left-stripe">-->
                                    </div>
                                </div>
                            </div>
                           
                            <div class="form-actions span10">
                                <button type="submit" class="btn btn-success">Schedule</button>
                                <button type="clear" class="btn btn-inverse">Cancel</button>
                            </div>
                        </fieldset>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>

                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->

    </div><!--/.page-content-->
</div><!--/.main-content-->