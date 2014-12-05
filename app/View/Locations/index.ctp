<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>
    <div class="page-content">
        <div class="page-header position-relative">
            <h1>
                Setup
                <small>
                    <i class="icon-double-angle-right"></i>
                    Brands, Outlet Classificaitons, Merchandize, Products & Locations
                </small>
            </h1>
        </div>

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>


        <?php echo $this->element('page_tabs'); ?>

        <div class="row-fluid">
            
            <div class="span12">
                <h3 class="header smaller lighter green">Manage Towns</h3>
                
                <!--Location setup wizard-->
                <?php echo $this->element('_location_setup_progress', array('active' => 'location')); ?>
                <!--End of Location setup wizard-->
                
                <!--Start Main Tab-->
                <div class="span12" style="margin-left: 0px;">
                    
                                <div class="span4">
                                    <!--<h3 class="header smaller lighter green">Add New Brand</h3>-->
                                    <div style="height: 10px;"></div>

                                    <div class="widget-box">
                                        <div class="widget-header">
                                            <h4><?php if (!isset($data['Location']['id'])) echo "Add"; else echo "Edit"; ?> Retail Block</h4>
                                        </div>

                                        <div class="widget-body" style="padding: 15px;">

                                            <?php echo $this->Form->create('Location', array('method' => 'POST', 'controller' => 'locations', 'action' => 'add'));
                                            ?>
                                            <br />

                                            <?php
                                            echo $this->Form->input('id', array('type' => 'hidden'));
                                            ?>

                                            <?php
                                            echo $this->Form->input('locationname', array('label' => 'Retail Block Name', 'required' => true, 'placeholder' => 'Enter name of Retail Block', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>

                                            <label> Local Government Areas
                                            <?php 
                                            echo $this->Html->link(
                                                '<i class="icon-plus"></i> Add', array('controller' => 'lgas', 'action' => 'index'), array('class' => 'btn btn-mini orange', 'escape' => false));
                                            ?>
                                            </label>
                                            <?php 
                                                echo $this->Form->select('lga_id', $lgalist, array('label' => 'Local Government Area', 'required' => false, 'placeholder' => 'Enter LGA', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>

                                            <hr/>
                                            <?php if (!isset($data['Location']['id'])): ?>
                                                <button type="submit" class="btn btn-success">Add Retail Block</button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-info">Update Retail Block</button>
                                            <?php endif; ?>


                                            <?php echo $this->Form->end() ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="span8">
                                    <!--PAGE CONTENT BEGINS-->
                                    <div class="row-fluid">
                                        <h3 class="span12 header smaller lighter green">List of Retail Blocks</h3>
                                        <p class="pull-right">
                                            <?php
                //                            echo $this->Html->link('<i class="icon-tag bigger-160"></i> New', array('controller' => 'locations', 'action' => 'add'), array('class' => 'btn btn-app btn-primary btn-mini', 'escape' => false));
                                            ?>
                                        </p>
                                    </div>
                                    <table id="pop_table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
                                                <th> Retail Block </th>
                                                <th> Local Government Areas </th>
                                                <!--<th> Region </th>-->
                                                <th style="text-align: center"> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($locations as $location):
                                                ?>
                                                <tr>
                                                    <td width="5%"> <?php echo++$i ?> </td>
                                                    <td> <?php echo $location['Location']['locationname']; ?>  </td>
                                                    <td> <?php echo $location['Lga']['lganame']; ?>  </td>
                                                    <td style="text-align: center"> 
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-pencil bigger-130"></i>', 
                                                                    array('controller' => 'locations', 'action' => 'edit', $location['Location']['id']), 
                                                                    array('class' => 'green', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                                            ?> |  
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-trash bigger-130"></i>', 
                                                                    array('controller' => 'locations', 'action' => 'delete', $location['Location']['id']), 
                                                                    array('class' => 'red', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                                            ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php unset($locations); ?>
                                        </tbody>
                                    </table>
                                    
                                    <div class="row-fluid">
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        <p class="pull-right">
                                            <?php
                                            echo $this->Html->link('<i class="icon-chevron-right"></i> Next', array('controller' => 'outletchannels', 'action' => 'index'), array('class' => 'btn btn-success btn-large','escape' => false));
                                            ?>
                                        </p>
                                    </div>
                                    <!--PAGE CONTENT ENDS-->
                                </div><!--/.span-->

                </div>
                
                <!--End Main Tab-->
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

</div><!--/.main-content-->