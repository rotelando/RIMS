
<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">

            <h1>
                Settings
                <small>
                    <i class="icon-double-angle-right"></i>
                    Application & Users settings
                </small>
            </h1>

        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <?php echo $this->Form->create('Setting', array('controller' => 'settings', 'action' => 'savesettings', 'class' => 'form-horizontal')) ?>

        <?php
        echo $this->Form->input('id', array('type' => 'hidden'));
        ?>

        <div class="row-fluid">
            <!--<form class="form-horizontal">-->
            <div class="span12">
                <h3 class="span12 header smaller lighter green">Application Settings</h3>
                <div class="row-fluid">


                    <div id="accordion2" class="accordion accordion-style2">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a href="#general" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
                                    General
                                </a>
                            </div>

                            <div class="accordion-body" id="general" style="height: 0px;">
                                <div class="accordion-inner">
                                    <div class="space-20"></div>

                                    <div class="span5">
                                        <!--==========================Field Rep. Settings ==================================-->
                                        <div class="control-group">
                                            <label class="control-label">Field Rep.</label>

                                            <div class="controls">
                                                <div class="ace-spinner">
                                                    <div class="input-append">
                                                        <?php echo $this->Form->select('fieldrepid', $fieldrepid, array('class' => 'span3 left-stripe', 'style' => 'width: 150px;')); ?>
                                                    </div>
                                                </div>
                                                <span class="help-button pull-right" data-rel="popover" data-trigger="hover" data-placement="right" data-content="This sets the option for representing the Field rep to be used to list all field reps..." title="" data-original-title="Field Reps.">?</span>
                                            </div>
                                        </div>
                                        <!--==========================End Field Rep. Settings ==================================-->

                                        <!--==========================Target Visit Settings ==================================-->
                                        <div class="control-group">
                                            <label class="control-label">Target Visit</label>

                                            <div class="controls">
                                                <div class="ace-spinner">
                                                    <div class="input-append">
                                                        <?php echo $this->Form->input('TargetVisit', array('type' => 'number', 'step' => '10', 'label' => false, 'class' => 'input spinner-input span8', 'maxlength' => '10')) ?>
                                                        <!--<input type="text" id="SettingTargetVisit" name="data[Setting][TargetVisit]" class="input spinner-input" maxlength="10" style="width: 150px;">-->
                                                    </div>
                                                </div>
                                                <span class="help-button pull-right" data-rel="popover" data-trigger="hover" data-placement="right" data-content="These are targeted visits expected by field representative to meet every month. It is perculiar to the manager of a region..." title="" data-original-title="Target Visit">?</span>
                                            </div>
                                        </div>
                                        <!--==========================End Target Visit Settings ==================================-->

                                        <!--==========================Target Order Settings ==================================-->
                                        <div class="control-group">
                                            <label class="control-label">Target Order</label>

                                            <div class="controls">
                                                <div class="ace-spinner">
                                                    <div class="input-append">
                                                        <?php echo $this->Form->input('TargetOrder', array('type' => 'number', 'step' => '10', 'label' => false, 'class' => 'input spinner-input span8', 'maxlength' => '10')) ?>
                                                        <!--<input type="text" id="SettingTargetVisit" name="data[Setting][TargetVisit]" class="input spinner-input" maxlength="10" style="width: 150px;">-->
                                                    </div>
                                                </div>
                                                <span class="help-button pull-right" data-rel="popover" data-trigger="hover" data-placement="right" data-content="These are targeted orders expected by field representative to meet every month. It is perculiar to the manager of a region..." title="" data-original-title="Target Order">?</span>
                                            </div>
                                        </div>
                                        <!--==========================End Target Visit Settings ==================================-->

                                        <!--==========================Delete Visit Settings ==================================-->
                                        <div class="control-group">
                                            <label class="control-label" for="SettingDeleteVisit">Delete Visits</label>
                                            <div class="controls">
                                                <div class="span3">
                                                    <label>
                                                        <input name="data[Setting][DeleteVisit]" id="SettingDeleteVisit" class="ace ace-switch ace-switch-2" type="checkbox">
                                                        <span class="lbl"></span>
                                                    </label>
                                                </div>
                                                <span class="help-button pull-right" data-rel="popover" data-trigger="hover" data-placement="right" data-content="This settings determines if a visits data can be deleted or not" title="" data-original-title="Delete Visits">?</span>
                                            </div>
                                        </div>
                                        <!--==========================End Delete Visit Settings ==================================-->
                                        
                                        <!--==========================Change Password Settings ==================================-->
                                        <div class="control-group">
                                            <label class="control-label" for="SettingDeleteVisit">Change Password</label>
                                            <div class="controls">
                                                <div class="span3">
                                                    <label>
                                                        <?php
                                                        echo $this->Html->link('<i class="icon-lock"></i>', array('action' => 'changepassword'), array('class' => 'btn btn-mini btn-inverse', 'escape' => false));
                                                        ?>
                                                    </label>
                                                </div>
                                                <span class="help-button pull-right" data-rel="popover" data-trigger="hover" data-placement="right" data-content="This settings determines if a visits data can be deleted or not" title="" data-original-title="Delete Visits">?</span>
                                            </div>
                                        </div>
                                        <!--==========================End Delete Visit Settings ==================================-->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/.row-fluid-->

            <div class="row-fluid">
                <!--<div class="form-actions">-->
                <div class="offset2">
                    <button class="btn btn-info" type="submit">
                        <i class="icon-ok bigger-110"></i>
                        Save Changes
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="icon-undo bigger-110"></i>
                        Cancel
                    </button>
                </div>
            </div>

            
        </div>

        <?php echo $this->Form->end(); ?>
    </div><!--/.page-content-->
</div><!--/.main-content-->
