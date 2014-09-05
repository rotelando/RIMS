<div class="main-content">

    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">

        <!--.page-header-->
        <div class="page-header position-relative">
            <h1>
                Users
                <small>
                    <i class="icon-double-angle-right"></i>
                    Management &amp; views
                </small>
            </h1>
        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->
                <p class="pull-right">
                    <?php
                     echo $this->Html->link('<i class="icon-user bigger-160"></i> New',
                        array('controller'=>'users','action'=>'add'),
                        array('class'=>'btn btn-app btn-primary btn-mini', 'escape'=>false)); 
                    ?>
                </p>

                <table id="all_users_table" class="table table-striped table-bordered table-hover display">
                    <thead>
                        <tr>
                            <th class="hidden-480">Full Name</th>
                            <th class="hidden-480">Username</th>
                            <th class="hidden-480">Role</th>
                            <th class="hidden-480">Location Group</th>
                            <th class="hidden-480">Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($users as $user):
                            if (intval($user['User']['active']) == 1) {
                                $active_class = "label label-success";
                                $active_text = "Active";
                                $action = "deactivate";
                                $action_text = '<i class="icon-lock bigger-130"></i> ';
                            } else {
                                $active_class = "label";
                                $active_text = "Inactive";
                                $action = "activate";
                                $action_text = '<i class="icon-unlock bigger-130"></i> ';
                            }
                            ?>

                            <tr>
                                <!-- <td class="center"> <?php //echo++$i ?> </td> -->
                                <td> <?php echo $user['User']['firstname'] . ' ' . $user['User']['lastname']; ?>  </td>
                                <td> <?php echo $user['User']['username']; ?> </td>
                                <td> <?php echo $user['Userrole']['userrolename']; ?> </td>
                                <td> <?php echo $user['Locationgroup']['locationgroupname']; ?> </td>
                                <td><span class="<?php echo $active_class; ?>"><?php echo $active_text; ?></td>
                                <td width="15%">
                                    <div class="hidden-phone visible-desktop action-buttons">
                                        <?php
                                        echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> ', 
                                                array('controller' => 'users', 'action' => 'view', $user['User']['id']), 
                                                array('class' => 'blue', 'escape' => false, 
                                                    "data-rel" => "tooltip", "data-placement" => "left", "data-original-title" => "View"));
                                        ?>
                                        <?php
                                        echo $this->Html->link(
                                                '| <i class="icon-pencil bigger-130"></i> ', 
                                                array('controller' => 'users', 'action' => 'edit', $user['User']['id']), 
                                                array('class' => 'green', 'escape' => false,
                                                "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => "Edit"));
                                        ?> 
                                        <?php
                                        if($user['Userrole']['id'] != 1 && $user['User']['id'] != 2) {
                                            echo $this->Html->link(
                                                    '| ' . $action_text, 
                                                    array('controller' => 'users', 'action' => $action, $user['User']['id']), 
                                                    array('class' => 'orange deactivateuser', 'escape' => false, 'onClick' => 'return false',
                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => ucfirst($action)));
                                        }
                                        ?> 
                                        <?php
                                        echo $this->Html->link(
                                                '| <i class="icon-key"></i> ', 
                                                array('controller' => 'users', 'action' => 'passwordreset', $user['User']['id']), 
                                                array('class' => 'grey', 'escape' => false,
                                                "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => "Reset Password"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
<?php endforeach; ?>
<?php unset($user); ?>
                    </tbody>
                </table>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    
<?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->

<div id="deactivateuser" class="modal hide fade" style="width: 350px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Deactivate User</h3>
    </div>
    <!-- Start Modal Body -->
    <div class="modal-body useractivationbody">
        
        <p><strong>This action will deactivate this user. Continue?</strong></p>
        
        <?php
            echo $this->Html->link('Yes', array('controller' => 'users', 'action' => 'deactivate'), array('class' => 'btn btn-danger', 'escape' => false, 'id' => 'deactivatebtn'));
        ?>
        
        <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-inverse pull-right"> No </button>
        
    </div>   
    <!-- End Modal Body -->
</div>

<?php echo $this->Html->script('/assets/bootstrap/bootstrap-modal'); ?>
