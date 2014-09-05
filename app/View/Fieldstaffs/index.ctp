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
                <h3 class="span12 header smaller lighter green">Field Staff</h3>
                <!--PAGE CONTENT BEGINS-->

                <?php echo $this->Form->create(array('method' => 'POST', 'controller' => 'fieldstaffs', 'action' => 'compare')); ?>
                <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => '10')); ?>

                <p class="pull-right">
                    <?php
                    echo $this->Html->link('<i class="icon-exchange bigger-160"></i> Compare', array('controller' => 'fieldstaffs', 'action' => 'compare'), array('class' => 'btn btn-warning', 'id'=>'fieldstaffcompare','escape' => false));
                    ?>
                    <?php
//                    echo $this->Html->link('<i class="icon-plus bigger-160"></i> New', array('controller' => 'users', 'action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false));
                    ?>
                </p>



                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="center"></th>
                            <th class="center">S/N</th>
                            <th class="hidden-480">Full Name</th>
                            <th class="hidden-480">Username</th>
                            <th class="hidden-480">Role</th>
                            <th width="30%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($fieldreps as $fieldrep):
                            ?>

                            <tr>
                                <td class="center"> <?php echo $this->Form->checkbox('fieldstaff', array('class'=>'staffselect', 'data-id'=>$fieldrep['User']['id'])); ?> </td>
                                <td class="center"> <?php echo++$i ?> </td>
                                <td> <?php echo $fieldrep['User']['firstname'] . ' ' . $fieldrep['User']['lastname']; ?>  </td>
                                <td> <?php echo $fieldrep['User']['username']; ?> </td>
                                <td> <?php echo $fieldrep['Userrole']['userrolename']; ?> </td>
                                <td class=" ">
                                    <div class="hidden-phone visible-desktop action-buttons">
                                        <?php
                                        echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> View', array('controller' => 'users', 'action' => 'view', $fieldrep['User']['id']), array('class' => 'blue', 'escape' => false));
                                        ?> 
                                        <?php
//                                        echo $this->Html->link(
//                                                '| <i class="icon-pencil bigger-130"></i> Edit', array('controller' => 'users', 'action' => 'edit', $fieldrep['User']['id']), array('class' => 'green', 'escape' => false));
                                        ?> 
                                        <?php
//                                        echo $this->Html->link(
//                                                '| <i class="icon-trash bigger-130"></i> Delete', array('controller' => 'users', 'action' => 'delete', $fieldrep['User']['id']), array('class' => 'red', 'escape' => false), true);
                                        ?>  
                                        <?php
                                        echo $this->Html->link(
                                                '| <i class="icon-key"></i> Activities', array('controller' => 'auditlogs', 'action' => 'index'), array('class' => 'purple', 'escape' => false));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php unset($fieldrep); ?>
                    </tbody>
                </table>
                <?php echo $this->Form->end(); ?>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->