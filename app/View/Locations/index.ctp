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
                <h3 class="header smaller lighter green">Manage Towns</h3>
                
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

                        <li data-target="#step3" class="complete" style="min-width: 20%; max-width: 20%;">
                            <span class="step">3</span>
                            <span class="title">State Groups (Regions)</span>
                        </li>

                        <li data-target="#step4" class="active" style="min-width: 20%; max-width: 20%;">
                            <span class="step">4</span>
                            <span class="title">Towns</span>
                        </li>
                        <li data-target="#step5" style="min-width: 20%; max-width: 20%;">
                            <span class="step">5</span>
                            <span class="title">Town Groups</span>
                        </li>
                    </ul>
                </div>
                <!--End of Location setup wizard-->
                
                <!--Start Main Tab-->
                <div class="span12" style="margin-left: 0px;">
                    
                                <div class="span4">
                                    <!--<h3 class="header smaller lighter green">Add New Brand</h3>-->
                                    <div style="height: 10px;"></div>

                                    <div class="widget-box">
                                        <div class="widget-header">
                                            <h4><?php if (!isset($data['Location']['id'])) echo "Add"; else echo "Edit"; ?> Town</h4>
                                        </div>

                                        <div class="widget-body" style="padding: 15px;">

                                            <?php echo $this->Form->create('Location', array('method' => 'POST', 'controller' => 'locations', 'action' => 'add'));
                                            ?>
                                            <br />

                                            <?php
                                            echo $this->Form->input('id', array('type' => 'hidden'));
                                            ?>

                                            <?php
                                            echo $this->Form->input('locationname', array('label' => 'Town Name', 'required' => true, 'placeholder' => 'Enter name of Town', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>
                                            
                                            <input type="checkbox" name="data[Location][usestate]" id="usestate">
                                            Use predefined locations. <br /><br />
                                            
                                            <label> State 
                                            <?php 
                                            echo $this->Html->link(
                                                '<i class="icon-plus"></i> Add', array('controller' => 'states', 'action' => 'index'), array('class' => 'btn btn-mini orange', 'escape' => false));
                                            ?>
                                            </label>
                                            <?php 
                                                echo $this->Form->select('stateid', $statelist, array('label' => 'State', 'required' => false, 'placeholder' => 'Enter State', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>
                                            
                                            <!--<label> Region--> 
                                            <?php 
//                                            echo $this->Html->link(
//                                                '<i class="icon-plus"></i> Add', array('controller' => 'regions', 'action' => 'index'), array('class' => 'btn btn-mini orange', 'escape' => false));
                                            ?>
                                            <!--</label>-->
                                            <?php 
//                                                echo $this->Form->select('regionid', $regionlist, array('label' => 'Regoin', 'required' => true, 'placeholder' => 'Enter State', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>
                                            <?php
//                                            echo $this->Form->input('state', array('label' => 'State', 'required' => true, 'placeholder' => 'Enter State', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>

                                            <?php
//                                            echo $this->Form->input('region', array('label' => 'Region', 'required' => true, 'placeholder' => 'Enter Region', 'class' => 'span10 left-stripe', 'type' => 'text'));
                                            ?>

                                            <hr/>
                                            <?php if (!isset($data['Location']['id'])): ?>
                                                <button type="submit" class="btn btn-success">Add Town</button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-info">Update Town</button>
                                            <?php endif; ?>


                                            <?php echo $this->Form->end() ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="span8">
                                    <!--PAGE CONTENT BEGINS-->
                                    <div class="row-fluid">
                                        <h3 class="span12 header smaller lighter green">List of Towns</h3>
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
                                                <th> Town Name</th>
                                                <th> State </th>
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
                                                    <td> <?php echo $location['State']['statename']; ?>  </td>
                                                    <!--<td> <?php // echo $location['Region']['regionname']; ?>  </td>-->
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
                                            echo $this->Html->link('<i class="icon-chevron-right"></i> Next', array('controller' => 'locationgroups', 'action' => 'index'), array('class' => 'btn btn-success btn-large','escape' => false));
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