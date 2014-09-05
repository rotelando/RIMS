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
                <h3 class="header smaller lighter green">Locations - State Groups (Regions)</h3>
                
                <!--Location setup wizard-->
                <div id="fuelux-wizard" class="row-fluid hide" data-target="#step-container" style="display: block;">
                    <ul class="wizard-steps">
                        <li data-target="#step1" class="complete" style="min-width: 20%; max-width: 20%;">
                            <span class="step">1</span>
                            <span class="title">Country</span>
                        </li>

                        <li data-target="#step2" class="complete" style="min-width: 20%; max-width: 20%;">
                            <span class="step">2</span>
                            <span class="title">State</span>
                        </li>

                        <li data-target="#step3" class="active" style="min-width: 20%; max-width: 20%;">
                            <span class="step">3</span>
                            <span class="title">State Groups (Regions)</span>
                        </li>

                        <li data-target="#step4" style="min-width: 20%; max-width: 20%;">
                            <span class="step">4</span>
                            <span class="title">Location</span>
                        </li>
                        <li data-target="#step5" style="min-width: 20%; max-width: 20%;">
                            <span class="step">5</span>
                            <span class="title">Location Groups</span>
                        </li>
                    </ul>
                </div>
                <!--End of Location setup wizard-->
                
                <!--Start Main Tab-->
                <div class="span12" style="margin-left: 0px;">
                    
                    <div class="span4">
                                    <!--<h3 class="header smaller lighter green">Manage Regions</h3>-->
                                    <div style="height: 10px;"></div>

                                    <div class="widget-box">
                                        <div class="widget-header">
                                            <h4><?php if (!isset($data['Region']['id'])) echo "Add"; else echo "Edit"; ?> Region</h4>
                                        </div>

                                        <div class="widget-body" style="padding: 15px;">

                                            <?php echo $this->Form->create('Region', array('method' => 'POST', 'controller' => 'regions', 'action' => 'add'));
                                            ?>
                                            <br />

                                            <?php
                                            echo $this->Form->input('id', array('type' => 'hidden'));
                                            ?>

                                            <?php
                                            echo $this->Form->input('regionname', array('label' => 'Region Name', 'required' => true, 'placeholder' => 'Enter name of Region', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>

                                            <label>Add States to Group (Region)</label>
                                            <div class="multiple_select_container span10" style="margin-left: 0px;">
                                                <?php foreach ($states as $state): ?>
                                                    <input type="checkbox" name="data[Region][stateids][]" 
                                                           value=<?php echo '"'.$state['State']['id'].'" '; 
                                                           if(isset($state['Region']['member']) && $state['Region']['member'] == true) { echo "checked"; } ?> />
                                                           
                                                        <?php echo $state['State']['statename']; ?> <br />
                                               <?php endforeach; ?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <br />
                                            <?php if (!isset($data['Region']['id'])): ?>
                                                <button type="submit" class="btn btn-success">Add Region</button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-info">Update Region</button>
                                            <?php endif; ?>


                                            <?php echo $this->Form->end() ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="span8">
                                    <!--PAGE CONTENT BEGINS-->
                                    <div class="row-fluid">
                                        <h3 class="span12 header smaller lighter green">List of Regions</h3>
                                        <p class="pull-right">
                                            <?php
                //                            echo $this->Html->link('<i class="icon-tag bigger-160"></i> New', array('controller' => 'locations', 'action' => 'add'), array('class' => 'btn btn-app btn-primary btn-mini', 'escape' => false));
                                            ?>
                                        </p>
                                    </div>
                                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
                                                <th> Region Name</th>
                                                <th> States </th>
                                                <th style="text-align: center"> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($regions as $region):
                                                ?>
                                                <tr>
                                                    <td width="5%"> <?php echo++$i ?> </td>
                                                    <td> <?php echo $region['Region']['regionname']; ?>  </td>
                                                    <td> <?php echo $region['Region']['states']; ?>  </td>
                                                    <td style="text-align: center"> 
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-pencil bigger-130"></i>', 
                                                                    array('controller' => 'regions', 'action' => 'edit', $region['Region']['id']), 
                                                                    array('class' => 'green', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                                            ?> | 
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-trash bigger-130"></i>', 
                                                                    array('controller' => 'regions', 'action' => 'delete', $region['Region']['id']), 
                                                                    array('class' => 'red', 'escape' => false,
                                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                                            ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php unset($regions); ?>
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
                                            echo $this->Html->link('<i class="icon-chevron-right"></i> Next', array('controller' => 'locations', 'action' => 'index'), array('class' => 'btn btn-success btn-large','escape' => false));
                                            ?>
                                        </p>
                                    </div>
                                    <!--PAGE CONTENT ENDS-->
                                </div><!--/.span-->
                                <!--End Locations tab-->

<!--                            <div id="dropdown2" class="tab-pane">
                                <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin.</p>
                            </div>-->
               
                </div>
                
                <!--End Main Tab-->
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->
    