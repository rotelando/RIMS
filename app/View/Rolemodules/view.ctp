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
                <h3 class="span12 header smaller lighter green">Role [<?php echo $userrole['Userrole']['userrolename']; ?>]</h3>
                <!--PAGE CONTENT BEGINS-->

                <?php echo $this->Form->create(array('method' => 'POST', 'controller' => 'rolemodules', 'action' => 'edit')); ?>

                <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $userrole['Userrole']['id'])); ?>
                
                <fieldset class="default">
                    <!--                    <legend calss="span1">Role Information</legend>-->
                    <div class="control-group">
                        <h4 class="control-label"><strong>Role Name<strong></h4>
                        <label class="text-success"><?php echo isset($userrole['Userrole']['userrolename']) ? $userrole['Userrole']['userrolename'] : ''; ?></label>
                    </div>
                    <div class="control-group">
                        <h4 class="control-label"><strong>Description<strong></h4>
                        <label class="text-success"><?php echo isset($userrole['Userrole']['description']) ? $userrole['Userrole']['description'] : ''; ?></label>
                    </div>
                </fieldset>   

                <fieldset class="default">
                    <legend>Manage Access Rights</legend>
                    <?php
                        if($userrole['Userrole']['id'] != 1):
                            echo $this->Html->link(
                                    'Edit', array('controller' => 'rolemodules', 'action' => 'edit', $userrole['Userrole']['id']), array('class' => 'btn btn-primary'));
                        endif;
                            echo ' ';
                            echo $this->Html->link(
                                    'Add New ', array('controller' => 'rolemodules', 'action' => 'add'), array('class' => 'btn btn-success'));
                            echo ' ';
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
                                <th class="hidden-480 center" width="10%">Add </th>
                                <th class="hidden-480 center" width="10%">View</th>
                                <th class="hidden-480 center" width="10%">Delete </th>
                                <th class="hidden-480 center" width="10%">Print </th>
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
                                        if(isset($rolemodule['Rolemodule']['add']) && $rolemodule['Rolemodule']['add']) {
                                            echo $this->Html->image('yes.png');
                                        } else {
                                            echo $this->Html->image('no.png');
                                        }
                                        ?>
                                    </td>
                                    <td class="center"> 
                                        <?php 
                                            if(isset($rolemodule['Rolemodule']['view']) && $rolemodule['Rolemodule']['view']) {
                                                echo $this->Html->image('yes.png');
                                            } else {
                                                echo $this->Html->image('no.png');
                                            }
                                        ?>
                                    </td>
                                    <td class="center"> 
                                        <?php
                                        
                                            if(isset($rolemodule['Rolemodule']['delete']) && $rolemodule['Rolemodule']['delete']) {
                                                echo $this->Html->image('yes.png');
                                            } else {
                                                echo $this->Html->image('no.png');
                                            }
                                        ?>
                                    </td>
                                    <td class="center"> 
                                        <?php 
                                            if(isset($rolemodule['Rolemodule']['print']) && $rolemodule['Rolemodule']['print']) {
                                                echo $this->Html->image('yes.png');
                                            } else {
                                                echo $this->Html->image('no.png');
                                            }
                                        ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                            <?php unset($rolemodules); ?>
                        </tbody>
                    </table>
                </fieldset>
                
                 <div class="form-actions span11">
                        <?php

                            if($userrole['Userrole']['id'] != 1):
                            echo $this->Html->link(
                                    'Edit', array('controller' => 'rolemodules', 'action' => 'edit', $userrole['Userrole']['id']), array('class' => 'btn btn-primary'));
                        endif;
                            echo ' ';
                            echo $this->Html->link(
                                    'Add New ', array('controller' => 'rolemodules', 'action' => 'add'), array('class' => 'btn btn-success'));
                            echo ' ';
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