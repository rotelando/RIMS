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
                <h3 class="span12 header smaller lighter green">Edit Role [<?php echo $userrole['Userrole']['userrolename']; ?>]</h3>
                <!--PAGE CONTENT BEGINS-->

                <?php echo $this->Form->create(array('method' => 'POST', 'controller' => 'rolemodules', 'action' => 'edit')); ?>

                <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $userrole['Userrole']['id'])); ?>
                
                <fieldset class="default">
                    <!--                    <legend calss="span1">Role Information</legend>-->
                    <div class="control-group">
                        <label class="control-label">Role Name</label>
                        <div class="controls">
                            <?php echo $this->Form->input('userrolename', array('value' => isset($userrole['Userrole']['userrolename']) ? $userrole['Userrole']['userrolename'] : '', 'label' => false, 'placeholder' => 'Role Name', 'class' => 'span3 left-stripe', 'type' => 'text'));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <?php echo $this->Form->input('description', array('value' => isset($userrole['Userrole']['description']) ? $userrole['Userrole']['description'] : '', 'label' => false, 'placeholder' => 'Description', 'class' => 'span3 left-stripe', 'type' => 'text'));
                            ?>
                        </div>
                    </div>
                </fieldset>   

                <fieldset class="default">
                    <legend>Manage Access Rights</legend>
                    <button type="submit" class="btn btn-primary">Update Role</button>
                        <?php
                            echo $this->Html->link(
                                    'Add New', array('controller' => 'rolemodules', 'action' => 'add'), array('class' => 'btn btn-success'));
                        ?>
                        <?php
                            echo $this->Html->link(
                                    'Back', array('controller' => 'rolemodules', 'action' => 'index'), array('class' => 'btn btn-inverse'));
                        ?>
                    <br />
                    <br />
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="center" width="5%">S/N</th>
                                <th class="hidden-480">Module</th>
                                <th class="hidden-480 center" width="10%">Add <br /><?php echo $this->Form->checkbox('add_selectall', array('class'=>'add_selectall', 'id' => 'add_selectall')); ?> </th>
                                <th class="hidden-480 center" width="10%">View <br /><?php echo $this->Form->checkbox('view_selectall', array('class'=>'view_selectall', 'id' => 'view_selectall')); ?> </th>
                                <th class="hidden-480 center" width="10%">Delete <br /><?php echo $this->Form->checkbox('delete_selectall', array('class'=>'delete_selectall', 'id' => 'delete_selectall')); ?> </th>
                                <th class="hidden-480 center" width="10%">Print <br /><?php echo $this->Form->checkbox('print_selectall', array('class'=>'print_selectall', 'id' => 'print_selectall')); ?> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($rolemodules as $rolemodule):
                                ?>
                                <tr>
                                    <td class="center"> <?php echo ++$i ?> </td>
                                    <td> <?php echo $rolemodule['Adminmodule']['adminmodulename']; ?></td>
                                    <td class="center"> 
                                        <?php
                                            echo $this->Form->checkbox('add_' . $rolemodule['Adminmodule']['adminmodulename'], 
                                                    array('class'=>'add', 'checked' => isset($rolemodule['Rolemodule']['add']) ? $rolemodule['Rolemodule']['add'] : false,
                                                          'data-id'=> 'add-' . $rolemodule['Adminmodule']['id']));
                                        ?>
                                    </td>
                                    <td class="center"> 
                                        <?php 
                                            echo $this->Form->checkbox('view_' . $rolemodule['Adminmodule']['adminmodulename'], 
                                                    array('class'=>'view', 'checked' => isset($rolemodule['Rolemodule']['view']) ? $rolemodule['Rolemodule']['view'] : false,
                                                          'data-id'=> 'view-' . $rolemodule['Adminmodule']['id']));
                                        ?>
                                    </td>
                                    <td class="center"> 
                                        <?php 
                                            echo $this->Form->checkbox('delete_' . $rolemodule['Adminmodule']['adminmodulename'], 
                                                        array('class'=>'del', 'checked' => isset($rolemodule['Rolemodule']['delete']) ? $rolemodule['Rolemodule']['delete'] : false,
                                                              'data-id'=> 'del-' . $rolemodule['Adminmodule']['id']));
                                        ?>
                                    </td>
                                    <td class="center"> 
                                        <?php 
                                            echo $this->Form->checkbox('print_' . $rolemodule['Adminmodule']['adminmodulename'], 
                                                    array('class'=>'prt', 'checked' => isset($rolemodule['Rolemodule']['print']) ? $rolemodule['Rolemodule']['print'] : false,
                                                          'data-id'=> 'prt-' . $rolemodule['Adminmodule']['id']));
                                        ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                            <?php unset($rolemodules); ?>
                        </tbody>
                    </table>
                </fieldset>
                
                 <div class="form-actions span11">
                     <button type="submit" class="btn btn-primary">Update Role</button>
                        <?php
                            echo $this->Html->link(
                                    'Add New', array('controller' => 'rolemodules', 'action' => 'add'), array('class' => 'btn btn-success'));
                        ?>
                        <?php
                            echo $this->Html->link(
                                    'Back', array('controller' => 'rolemodules', 'action' => 'index'), array('class' => 'btn btn-inverse'));
                        ?>
                </div>
                <?php echo $this->Form->end(); ?>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->


    </div> <!--/.main-content-->
</div> <!--/.main-content-->