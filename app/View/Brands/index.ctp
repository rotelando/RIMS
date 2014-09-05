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
                            <h4><?php if (!isset($data['Brand']['id'])) echo "Add New"; else echo "Edit"; ?> Brand</h4>
                        </div>

                        <div class="widget-body" style="padding: 15px;">

                            <?php
                            echo $this->Form->create('Brand', array('method' => 'POST', 'controller' => 'brands', 'action' => 'add'));
                            ?>
                            <br />

                            <?php
                            echo $this->Form->input('id', array('type' => 'hidden'));
                            ?>
                            
                            <?php
                            echo $this->Form->input('brandname', array('label' => 'Brand Name', 'required' =>
                                true, 'placeholder' => 'Brand Name', 'class' => 'span8', 'type' => 'text'));
                            ?>

                            <div class="control-group">
                                <label class="control-label">Brand Color</label>
                                <div class="controls">
                                    <input name="data[Brand][brandcolor]" id="BrandBrandcolor" maxlength="6" type="text" class="minicolors span5" value="<?php if(isset($data['Brand']['brandcolor'])) echo $data['Brand']['brandcolor'];?>">
                                </div>
                            </div>

                            <label class="checkbox" style="margin-left: 20px;">
                                <?php 
                                if(isset($data['Brand']['current']) && $data['Brand']['current'] == 1) { 
                                    $current = true; 
                                } else { 
                                    $current = false; 
                                }
                                
                                echo $this->Form->checkbox('current', 
                                        array('checked' => $current)); ?>
                                This is my company</label>

                            <hr/>
                            
                            <?php if (!isset($data['Brand']['id'])): ?>
                                <button type="submit" class="btn btn-success">Add Brand</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-info">Update Brand</button>
                            <?php endif; ?>
                            
                            <?php echo $this->Form->end() ?>
                        </div>
                    </div>
                </div>
                <div class="span8">
                    <!--PAGE CONTENT BEGINS-->
                    <div class="row-fluid">
                        <h3 class="span12 header smaller lighter green">List of Brands</h3>
                        <p class="pull-right">
                            <?php
//                            echo $this->Html->link('<i class="icon-tag bigger-160"></i> New', array('controller' => 'brands', 'action' => 'add'), array('class' => 'btn btn-app btn-primary btn-mini', 'escape' => false));
                            ?>
                        </p>
                    </div>
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th class="hidden-480">Brand Name</th>
                                <th class="hidden-480">Brand Color</th>
                                <th class="hidden-480">Status</th>
                                <th style="text-align: center" width="15%">  Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($brands as $brand):
                                if (intval($brand['Brand']['current'])) {
                                    $active_class = "label label-success";
                                    $active_text = "My company";
                                } else {
                                    $active_class = "label";
                                    $active_text = "My competitor";
                                }
                                ?>

                                <tr>
                                    <td class="center"> <?php echo++$i ?> </td>
                                    <td> <?php echo $brand['Brand']['brandname']; ?>  </td>
                                    <td style="text-align: left;">
                                        <div style="background-color: <?php echo $brand['Brand']['brandcolor']; ?>; width: 20px; height: 20px; display: inline-table;">
                                        </div> <?php echo $brand['Brand']['brandcolor']; ?> </td>
                                    <td><span class="<?php echo $active_class; ?>"><?php echo $active_text; ?></span></td>
                                    <td style="text-align: center">
                                        <div class="hidden-phone visible-desktop action-buttons center">

                                            <?php
                                            echo $this->Html->link(
                                                    '<i class="icon-pencil bigger-130"></i>', 
                                                    array('controller' => 'brands', 'action' => 'edit', $brand['Brand']['id']), 
                                                    array('class' => 'green', 'escape' => false,
                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                            ?> | 
                                            <?php
                                            echo $this->Html->link(
                                                    '<i class="icon-trash bigger-130"></i>', 
                                                    array('controller' => 'brands', 'action' => 'delete', $brand['Brand']['id']), 
                                                    array('class' => 'red', 'escape' => false,
                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php unset($brand); ?>
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
