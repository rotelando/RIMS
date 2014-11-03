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

<script>

    $(document).ready(function() {

        /*var all_users_url = config.URL + "users/loadusers";

        //all user's table
        $('#all_users_table').DataTable( {
            "lengthMenu": [ 25, 50, 75, 100 ],
            //"pagingType": "full_numbers",
            "order": [[ 0, "asc" ]],
            "processing": true,
            *//*"serverSide": true,
            "ajax": {
             "url": all_users_url,
             "type": "POST"
             },*//*
            "columnDefs": [
                {
                    "targets": 0,
                    "data": "out_id",
                    "render": function ( data, type, full, meta ) {

                        return full[0].capitalize() + ' ' + full["lastname"].capitalize();
                    }
                },
                {
                    "targets": 4,
                    "data": "active",
                    "render": function ( data, type, full, meta ) {
                        var render4 = '';
                        if(full[4] === '1')
                            render4 = '<span class="label label-success">Active</span>';
                        else
                            render4 = '<span class="label">Inactive</span>';

                        return render4;
                    }
                },
                {
                    "targets": 5,
                    "data": "id",
                    "render": function ( data, type, full, meta ) {

                        var link = '<div class="hidden-phone visible-desktop action-buttons">';
                        link += '<a href="/users/view/' + full[5] + '" class="blue" data-rel="tooltip" data-placement="top" data-original-title="View"><i class="icon-zoom-in bigger-130"></i> </a> | ';
                        link += '<a href="/users/edit/' + full[5] + '" class="green" data-rel="tooltip" data-placement="top" data-original-title="Edit"><i class="icon-pencil bigger-130"></i> </a> | ';

                        if(full["role_id"] !== '1') {
                            if(full[4] === '1')
                                link += '<a href="/users/deactivate/' + full[5] + '" class="orange deactivateuser" onclick="return false" data-rel="tooltip" data-placement="top" data-original-title="Deactivate"><i class="icon-lock bigger-130"></i> </a> | ';
                            else
                                link += '<a href="/users/activate/' + full[5] + '" class="orange" data-rel="tooltip" data-placement="top" data-original-title="Activate"><i class="icon-unlock bigger-130"></i> </a> | ';
                        }
                        link += '<a href="/users/passwordreset/' + full[5] + '" class="grey" data-rel="tooltip" data-placement="top" data-original-title="Reset Password"><i class="icon-key"></i> </a>';
                        link +=  '</div>';

                        deactivateUser();
                        return link;
                    }
                }
            ]
        });*/


        //deactivate a user
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

    });
</script>
