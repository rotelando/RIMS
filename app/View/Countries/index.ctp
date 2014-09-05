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
                
                <h3 class="header smaller lighter green">Locations - Countries</h3>
                
                <!--Location setup wizard-->
                <div id="fuelux-wizard" class="row-fluid hide" data-target="#step-container" style="display: block;">
                    <ul class="wizard-steps">
                        <li data-target="#step1" class="active" style="min-width: 20%; max-width: 20%;">
                            <span class="step">1</span>
                            <span class="title">Country</span>
                        </li>

                        <li data-target="#step2" style="min-width: 20%; max-width: 20%;">
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
                    echo $this->Html->link('<i class="icon-chevron-right"></i> Next', array('controller' => 'states', 'action' => 'index'), array('class' => 'btn btn-success btn-large','escape' => false));
                    ?>
                </p>
                
                <!--End Main Tab-->
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->