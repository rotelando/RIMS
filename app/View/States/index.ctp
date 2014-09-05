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
                <h3 class="header smaller lighter green">Locations - States</h3>
                
                <!--Location setup wizard-->
                <div id="fuelux-wizard" class="row-fluid hide" data-target="#step-container" style="display: block;">
                    <ul class="wizard-steps">
                        <li data-target="#step1" class="complete" style="min-width: 20%; max-width: 20%;">
                            <span class="step">1</span>
                            <span class="title">Country</span>
                        </li>

                        <li data-target="#step2" class="active" style="min-width: 20%; max-width: 20%;">
                            <span class="step">2</span>
                            <span class="title">State</span>
                        </li>

                        <li data-target="#step3" style="min-width: 20%; max-width: 20%;">
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
                    
                    <div class="span6 offset1">
                        <div id="statesMapContainer"  style="margin-left: 0px"></div>
                        <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
                        However, it seems JavaScript is either disabled or not supported by your browser. 
                        To view Google Maps, enable JavaScript by changing your browser options, and then 
                        try again.
                        </noscript>
                    </div>
                    <div class="span4">
                        <!--PAGE CONTENT BEGINS-->
                        <div class="row-fluid">
                            <h3 class="span12 header smaller lighter green">List of States</h3>
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
                                    <th> State Name</th>
                                    <th> Short Name</th>
                                    <th style="text-align: center"> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($states as $state):
                                    ?>
                                    <tr>
                                        <td width="5%"> <?php echo++$i ?> </td>
                                        <td> <?php echo $state['State']['statename']; ?>  </td>
                                        <td> <?php echo $state['State']['shortname']; ?>  </td>
                                        <td style="text-align: center"> 
                                                <?php
                                                    echo $this->Html->link('<i class="icon-trash bigger-130"></i>', 
                                                            array('controller' => 'states', 'action' => 'delete', $state['State']['id']), 
                                                            array('class' => 'red deletestate', 'escape' => false, 'onclick' => '{ return false; }',
                                                            "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'));
                                                ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php unset($states); ?>
                            </tbody>
                        </table>
                        
                        <div class="row-fluid">
                            <br />
                            <br />
                            <p class="pull-right">
                                <?php
                                echo $this->Html->link('<i class="icon-chevron-right"></i> Next', array('controller' => 'regions', 'action' => 'index'), array('class' => 'btn btn-success btn-large','escape' => false));
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

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->