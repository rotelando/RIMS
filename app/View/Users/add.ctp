<div class="main-content">

    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">

        <!--.page-header-->
        <div class="page-header position-relative">
            <h1>
                Users Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    Add New User
                </small>
            </h1>
        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->
                <!-- Start Form -->
                <?php echo $this->Form->create('User', array('method' => 'POST', 'controller' => 'users', 'action' => 'add', 'class' => 'form-horizontal')); ?>
                <fieldset class="default">
                    <legend>Basic Information</legend>
                    <div class="control-group">
                        <label class="control-label">Firstname</label>
                        <div class="controls">
                            <?php echo $this->Form->input('firstname', array('label' => false, 'placeholder' => 'Firstname', 'class' => 'span3 left-stripe', 'type' => 'text'));
                            ?>
                            <!--<input type="text" name="firstname" placeholder="Firstname" class="span5 left-stripe">-->
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Lastname</label>
                        <div class="controls">
                            <?php echo $this->Form->input('lastname', array('label' => false, 'placeholder' => 'Lastname', 'class' => 'span3', 'type' => 'text'));
                            ?>
                            <!--<input type="text" name="lastname" placeholder="Lastname" class="span5">-->
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email Address</label>
                        <div class="controls">
                            <?php echo $this->Form->input('emailaddress', array('label' => false, 'placeholder' => 'Email Address', 'class' => 'span3', 'type' => 'text'));
                            ?>
                            <!--<input type="text" name="emailaddress" placeholder="Email Address" class="span5">-->
                        </div>
                    </div>
                </fieldset>

                <fieldset class="default">
                    <legend>Account Information</legend>
                    <div class="control-group">
                        <label class="control-label">Username</label>
                        <div class="controls">
                            <?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'Username', 'class' => 'span3 left-stripe', 'type' => 'text'));
                            ?>
                            <!--<input type="text" name="username" placeholder="Username" class="span5 left-stripe">-->
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Password</label>
                        <div class="controls">
                            <?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'Password', 'class' => 'span3 left-stripe', 'type' => 'password'));
                            ?>
                            <!--<input type="password" name="password" placeholder="Password" class="span5 left-stripe">-->
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Confirm Password</label>
                        <div class="controls">
                            <?php echo $this->Form->input('confirm_password', array('label' => false, 'placeholder' => 'Confirm Password', 'class' => 'span3 left-stripe', 'type' => 'password'));
                            ?>
                            <!--<input type="password" name="confirm_password" placeholder="Confirm Password" class="span5 left-stripe">-->
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Activate User</label>
                        <div class="controls">
                            <label class="checkbox span6">
                                <input type="checkbox" name="data[User][active]" checked="true" value="checked">
                                User will be activated automatically when account is created</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">User Role</label>
                        <div class="controls">
                            <?php echo $this->Form->select('userroleid', $user_roles, array('class' => 'span3 left-stripe'));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Location Group</label>
                        <div class="controls">
                            <?php echo $this->Form->select('locationgroupid', $locationgroups, array('class' => 'span3 left-stripe'));
                            ?>
                        </div>
                    </div>
                    <div class="form-actions span10">
                        <button type="submit" class="btn btn-success">Create User</button>
                        <button type="clear" class="btn btn-inverse">Cancel</button>
                    </div>
                </fieldset>
                <?php echo $this->Form->end(); ?>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->
</div><!--/.main-content-->
