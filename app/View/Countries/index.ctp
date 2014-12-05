<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>
    <div class="page-content">
        <div class="page-header position-relative">
            <h1>
                Setup
                <small>
                    <i class="icon-double-angle-right"></i>
                    Brands, Products, Locations, Outlets, Orders, Merchandize & Targets
                </small>
            </h1>
        </div>

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>


        <?php echo $this->element('page_tabs'); ?>

        <div class="row-fluid">
            
            <div class="span12">
                
                <h3 class="header smaller lighter green">Location Setup Summary</h3>
                
                <!--Location setup wizard-->
                <?php /*echo $this->element('_location_setup_progress', array('active' => 'country')); */?>
                <!--End of Location setup wizard-->

                <div class="row-fluid">
                    <div class="span2">
                        <div class="visit-accuracy">
                            <a href="/setup/locations/regions">
                                <div class="border">
                                    <span class="visit-value"><?php echo $regionCount; ?></span>
                                    <span class="visit-name">Regions</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="visit-accuracy">
                            <a href="/setup/locations/subregions">
                                <div class="border">
                                    <span class="visit-value"><?php echo $subregionCount; ?></span>
                                    <span class="visit-name">Subregions</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="visit-accuracy">
                            <a href="/setup/locations/states">
                                <div class="border">
                                    <span class="visit-value"><?php echo $stateCount; ?></span>
                                    <span class="visit-name">States</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="visit-accuracy">
                            <a href="/setup/locations/territories">
                                <div class="border">
                                    <span class="visit-value"><?php echo $territoryCount; ?></span>
                                    <span class="visit-name">Territories</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="visit-accuracy">
                            <a href="/setup/locations/lgas">
                                <div class="border">
                                    <span class="visit-value"><?php echo $lgaCount; ?></span>
                                    <span class="visit-name">LGAs</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="visit-accuracy">
                            <a href="/setup/locations/pop">
                                <div class="border">
                                    <span class="visit-value"><?php echo $popCount; ?></span>
                                    <span class="visit-name">Retail Blocks</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!--Start Main Tab-->
                <div class="span12" style="margin-left: 0px;">
                    <br />
                   
                    <div class="span3 offset4">
                        
                            <?php echo $this->Form->create('Country', array('method' => 'POST', 'controller' => 'countries', 'action' => 'add'));
                            ?>
                            <br />

                            <?php
                            echo $this->Form->input('id', array('type' => 'hidden'));
                            ?>

                            <label> Select Your Country</label>
                            <br/>
                            <?php 
                                echo $this->Form->select('countryname', $countrylist, array('label' => 'My Country', 'required' => true, 'placeholder' => 'Enter State', 'class' => 'span10 left-stripe', 'type' => 'text'));
                            ?>
                            
                            <?php echo $this->Form->end() ?>
                    </div>
                    
                </div>
                <div class="clearfix"></div>
                <p class="pull-right" style="padding-right: 50px;">
                    <?php
                    echo $this->Html->link('<i class="icon-cloud-upload"></i> Bulk Upload', array('controller' => 'countries', 'action' => 'bulkupload'), array('class' => 'btn btn-warning btn-large','escape' => false));
                    ?>
                    <?php
                    echo $this->Html->link('<i class="icon-chevron-right"></i> Goto Region', array('controller' => 'regions', 'action' => 'index'), array('class' => 'btn btn-success btn-large','escape' => false));
                    ?>
                </p>
                
                <!--End Main Tab-->
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->