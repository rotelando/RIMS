<div class="main-content">

    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">

        <!--.page-header-->
        <div class="page-header position-relative">
            <h1>
                Users
                <small>
                    <i class="icon-double-angle-right"></i>
                    Licenses
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
                     echo $this->Html->link('<i class="icon-credit-card bigger-160"></i> Add',
                        array('#'=>''),
                        array('class'=>'btn btn-app btn-primary btn-mini', 'escape'=>false, 'id' => 'addlicence')); 
                    ?>
                </p>

                <?php if(count($licenses) != 0): ?>
                
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="center">#</th>
                            <th class="hidden-480">License Pack</th>
                            <th class="hidden-480">Key</th>
                            <th class="hidden-480">Number of Allowed Users</th>
                            <th class="hidden-480">Status</th>
                            <th class="hidden-480">Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $i = 0;
                        foreach ($licenses as $license):
                            if (intval($license['License']['status']) == 1) {
                                $active_class = "label label-success";
                                $active_text = "Active";
                            } else {
                                $active_class = "label";
                                $active_text = "Inactive";
                            }
                            ?>

                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $license['License']['licensepack']; ?></td>
                                <td><?php echo $license['License']['licensekey']; ?></td>
                                <td><?php echo $license['License']['numberofusers']; ?></td>
                                <td><?php echo "<span class=\"{$active_class}\">{$active_text}</span>"; ?></td>
                                <td><?php echo $license['License']['createdat']; ?></td>
                                <td>
                                    <?php
                                        echo $this->Html->link(
                                                '<i class="icon-trash"></i> ', 
                                                array('controller' => 'licenses', 'action' => 'delete', $license['License']['id']), 
                                                array('class' => 'red', 'escape' => false,
                                                "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => "Delete"));
                                        ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php unset($licenses); 
                            else: 
                                ?>
                                <p>No License available yet. Please click 'Add' to apply a license.</p>
                            <?php
                                endif;
                            ?>
                    </tbody>
                </table>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    
<?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->

<div id="userlicence" class="modal hide fade" style="width: 350px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Apply License</h3>
    </div>
    <!-- Start Modal Body -->
    <div class="modal-body userlicencebody">
        
        <p><strong>Please enter your Company ID and Licence Key</strong></p>
        
        <?php echo $this->Form->create('License', array('method' => 'POST', 'controller' => 'licenses', 'action' => 'add'));
        ?>
        <br />

        <?php
        echo $this->Form->input('id', array('type' => 'hidden'));
        ?>

        <?php
        echo $this->Form->input('companyid', array('label' => 'Company ID', 'required' => true, 'placeholder' => 'Company ID', 'class' => 'block left-stripe', 'type' => 'text', 'disabled'));
        ?>

        <?php
        echo $this->Form->input('licensekey', array('label' => 'License Key', 'required' => true, 'placeholder' => 'XXXX-XXXX-XXXX-XXXX-XXXX', 'class' => 'block left-stripe', 'type' => 'text'));
        ?>

        <hr/>
        <?php if (!isset($data['License']['id'])): ?>
            <button type="submit" class="btn btn-success">Add License</button>
        <?php else: ?>
            <button type="submit" class="btn btn-info">Update License</button>
        <?php endif; ?>
            <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-danger pull-right"> Cancel </button>

        <?php echo $this->Form->end() ?>
            
    </div>   
    <!-- End Modal Body -->
</div>

<?php echo $this->Html->script('/assets/bootstrap/bootstrap-modal'); ?>
