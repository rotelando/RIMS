<div class="main-content">

    <div class="page-content">
        <div class="page-header position-relative">
            <h1>
                Role Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    Definition and assignments of roles
                </small>
            </h1>
        </div>

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <div class="row-fluid">
            <div class="span12">
                <h3 class="span12 header smaller lighter green">Role Management</h3>
                <!--PAGE CONTENT BEGINS-->

                <?php echo $this->Form->create(array('method' => 'POST', 'controller' => 'rolemodules', 'action' => '')); ?>

                <p class="pull-left">
                    <?php
                    echo $this->Html->link('Add New Role', array('controller' => 'rolemodules', 'action' => 'add'), array('class' => 'btn btn-success', 'id'=>'newuserrole','escape' => false));
                    ?>
                    <?php
//                    echo $this->Html->link('Delete Selected Item', array('controller' => 'rolemodules', 'action' => 'delete'), array('class' => 'btn btn-primary', 'escape' => false));
                    ?>
                </p>



                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="5%" class="center"></th>
                            <th class="center">S/N</th>
                            <th class="hidden-480">Role Name</th>
                            <th class="hidden-480">Total Users</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($userroles as $userrole):
                            ?>

                            <tr>
                                <td class="center"> <?php echo $this->Form->checkbox('chkuserroles', array('class'=>'chkuserroles', 'data-id'=>$userrole['Userrole']['id'])); ?> </td>
                                <td class="center"> <?php echo++$i ?> </td>
                                <td> <?php echo $userrole['Userrole']['userrolename']; ?>  </td>
                                <td> <?php echo $userrole[0]['userrolecount']; ?> </td>
                                <td class=" ">
                                    <div class="hidden-phone visible-desktop action-buttons">
                                        <?php
                                        
                                        echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> View', array('action' => 'view', $userrole['Userrole']['id']), array('class' => 'blue', 'escape' => false));
                                        
                                        if($userrole['Userrole']['id'] != 1) {
                                            echo $this->Html->link(
                                                    '| <i class="icon-pencil bigger-130"></i> Edit', array('action' => 'edit', $userrole['Userrole']['id']), array('class' => 'green', 'escape' => false));

                                            echo $this->Html->link(
                                                        '| <i class="icon-trash bigger-130"></i> Delete', array('action' => 'delete', $userrole['Userrole']['id']), array('class' => 'red', 'escape' => false), true);
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php unset($userroles); ?>
                    </tbody>
                </table>
                <?php echo $this->Form->end(); ?>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->


    </div> <!--/.main-content-->
</div> <!--/.main-content-->

