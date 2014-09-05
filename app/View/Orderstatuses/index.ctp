<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>
    <div class="page-content">
        <div class="page-header position-relative">
            <h1>
                Setup
                <small>
                    <i class="icon-double-angle-right"></i>
                    Brands, Visibility Elements, Products & Locations
                </small>
            </h1>
        </div>

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>


        <?php echo $this->element('page_tabs'); ?>

        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->

                <div class="span4">
                    <!--<h3 class="header smaller lighter green">Add New Brand</h3>-->
                    <div style="height: 10px;"></div>

                    <div class="widget-box">
                        <div class="widget-header">
                            <h4><?php if (!isset($data['Orderstatus']['id'])) echo "Add"; else echo "Edit"; ?> Sales Status</h4>
                        </div>

                        <div class="widget-body" style="padding: 15px;">

                            <?php echo $this->Form->create('Orderstatus', array('method' => 'POST', 'controller' => 'orderstatuses', 'action' => 'add'));
                            ?>
                            <br />

                            <?php
                            echo $this->Form->input('id', array('type' => 'hidden'));
                            ?>

                            <?php
                            echo $this->Form->input('orderstatusname', array('label' => 'Sales Status Name', 'required' => true, 'placeholder' => 'Status Name', 'class' => 'span10 left-stripe', 'type' => 'text'));
                            ?>

                            <hr/>
                            <?php if (!isset($data['Orderstatus']['id'])): ?>
                                <button type="submit" class="btn btn-success">Add Sales Status</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-info">Update Sales Status</button>
                            <?php endif; ?>


                            <?php echo $this->Form->end() ?>
                        </div>
                    </div>
                </div>
                <div class="span8">
                    <!--PAGE CONTENT BEGINS-->
                    <div class="row-fluid">
                        <h3 class="span12 header smaller lighter green">List of Sales Statuses</h3>
                        <p class="pull-right">
                            <?php
//                            echo $this->Html->link('<i class="icon-tag bigger-160"></i> New', array('controller' => 'brands', 'action' => 'add'), array('class' => 'btn btn-app btn-primary btn-mini', 'escape' => false));
                            ?>
                        </p>
                    </div>
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th> S/N </th>
                                <th> Status Name</th>
                                <th width="15%"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($orderstatuses as $orderstatus):
                                ?>
                                <tr>
                                    <td width="5%"> <?php echo++$i ?> </td>
                                    <td> <?php echo $orderstatus['Orderstatus']['orderstatusname']; ?>  </td>
                                    <td style="text-align: center">
                                        <div class="hidden-phone visible-desktop action-buttons center">
                                            <?php
                                            echo $this->Html->link(
                                                    '<i class="icon-pencil bigger-130"></i>', 
                                                    array('controller' => 'orderstatuses', 'action' => 'edit', $orderstatus['Orderstatus']['id']), 
                                                    array('class' => 'green', 'escape' => false,
                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                            ?> |  
                                            <?php
                                            echo $this->Html->link(
                                                    '<i class="icon-trash bigger-130"></i>', 
                                                    array('controller' => 'orderstatuses', 'action' => 'delete', $orderstatus['Orderstatus']['id']), 
                                                    array('class' => 'red', 'escape' => false,
                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php unset($orderstatuses); ?>
                        </tbody>
                    </table>
                    <!--PAGE CONTENT ENDS-->
                </div><!--/.span-->
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->

