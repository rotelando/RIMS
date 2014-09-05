<div class="main-content">

    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">

        <!--.page-header-->
        <div class="page-header position-relative">
            <h1>
                Users Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    Reset Password
                </small>
            </h1>
        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->
                <!-- Start Form -->
                <?php echo $this->Form->create('User', array('method' => 'POST', 'controller' => 'users', 'action' => 'changepassword', 'class' => 'form-horizontal')); ?>
                
                <?php echo $this->Form->input('id', array('type' => 'hidden'));
                            ?>
                
                <fieldset class="default">
                    <legend>Reset Password for <span class="text-info"><?php echo $fullname; ?></span></legend>
                    <div class="control-group">
                        <label class="control-label">Old Password</label>
                        <div class="controls">
                            <?php echo $this->Form->input('old_password', 
                                    array('label' => false, 'placeholder' => 'New Password', 'value'=>'', 'class' => 'span4 left-stripe', 'type' => 'password'));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">New Password</label>
                        <div class="controls">
                            <?php echo $this->Form->input('password', 
                                    array('label' => false, 'placeholder' => 'New Password', 'value'=>'', 'class' => 'span4 left-stripe', 'type' => 'password'));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Retype Password</label>
                        <div class="controls">
                            <?php echo $this->Form->input('confirm_password', 
                                    array('label' => false, 'placeholder' => 'Confirm New Password', 'value'=>'', 'class' => 'span4 left-stripe', 'type' => 'password'));
                            ?>
                        </div>
                    </div>
                </fieldset>

                    <div class="form-actions span10">
                        <button type="submit" class="btn btn-success">&nbsp;&nbsp;Save&nbsp;&nbsp;</button>
                    </div>
   
                <?php echo $this->Form->end(); ?>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->
</div><!--/.main-content-->
