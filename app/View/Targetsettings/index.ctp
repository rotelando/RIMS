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

        
        <?php // echo $this->Form->create('Target', array('controller' => 'targets', 'action' => 'save', 'class' => 'form-horizontal')) ?>
        <div class="row-fluid">
            <div class="span12">
                
                <!--PAGE CONTENT BEGINS-->
                <h3 class="header smaller lighter purple">Manage Visits and Sales Targets</h3>
                
                <div class="span12" style="margin-left: 0px;">
                    <?php echo $this->Form->create('Targetsetting', array('controller' => 'targets', 'action' => 'save', 'class' => 'form-horizontal')) ?>
                    <div class="tabbable tabs-left">
                        <ul class="nav nav-tabs" id="myTab3">
                            <li class="active">
                                <a data-toggle="tab" href="#countries">
                                    <i class="purple icon-globe bigger-110"></i>
                                    Countries
                                </a>
                            </li>

                            <li>
                                <a data-toggle="tab" href="#regions">
                                    <i class="purple icon-globe bigger-110"></i>
                                    Regions
                                </a>
                            </li>

                            <li>
                                <a data-toggle="tab" href="#states">
                                    <i class="purple icon-globe bigger-110"></i>
                                    States
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#towngroups">
                                    <i class="purple icon-globe bigger-110"></i>
                                    Town Groups
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#towns">
                                    <i class="purple icon-globe bigger-110"></i>
                                    Towns
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="countries" class="tab-pane in active">
                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th> Country </th>
                                            <th> Short Name </th>
                                            <th width="10%"> Visit Target </th>
                                            <th colspan="2" width="20%"> 
                                    <p class="center">Sales Target</p>
                                    <div class="clearfix"></div>
                                    <p class="pull-left">Count</p><p class="pull-right">Value</p>
                                    </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(isset($countries)) {
                                                for($i = 0; $i < count($countries); $i++) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $countries[$i]['Country']['countryname']; ?></td>
                                                    <td><?php echo $countries[$i]['Country']['countrycode']; ?></td>
                                                    <td width="10%"><input type="text" class="span12" name="c_<?php echo $countries[$i]['Country']['id']; ?>_targetvisit" /></td>
                                                    <td width="10%"><input type="text" class="span12" name="c_<?php echo $countries[$i]['Country']['id']; ?>_targetorder" /></td>
                                                    <td width="10%"><input type="text" class="span12" name="c_<?php echo $countries[$i]['Country']['id']; ?>_targetvalue" /></td>
                                                </tr>
                                        <?php 
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div id="regions" class="tab-pane">
                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th> Country </th>
                                            <th> Region </th>
                                            <th> States </th>
                                            <th width="10%"> Visit Target </th>
                                            <th colspan="2" width="20%"> 
                                    <p class="center">Sales Target</p>
                                    <div class="clearfix"></div>
                                    <p class="pull-left">Count</p><p class="pull-right">Value</p>
                                    </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(isset($regions)) {
                                                    for($i = 0; $i < count($regions); $i++) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $regions[$i]['Country']['countryname']; ?></td>
                                                    <td><?php echo $regions[$i]['Region']['regionname']; ?></td>
                                                    <td><?php echo $regions[$i]['Region']['states']; ?></td>
                                                    <td width="10%"><input type="text" class="span12" name="r_<?php echo $regions[$i]['Region']['id']; ?>_targetvisit" /></td>
                                                    <td width="10%"><input type="text" class="span12" name="r_<?php echo $regions[$i]['Region']['id']; ?>_targetorder" /></td>
                                                    <td width="10%"><input type="text" class="span12" name="r_<?php echo $regions[$i]['Region']['id']; ?>_targetvalue" /></td>
                                                </tr>
                                        <?php 
                                                }
                                            }
                                        ?>
<!--                                        <tr>
                                            <td>Nigeria</td>
                                            <td>SouthWest</td>
                                            <td>Lagos, Ondo, Ogun</td>
                                            <td width="10%"><input type="text" class="span12" name="targetvisit" /></td>
                                            <td width="10%"><input type="text" class="span12" name="targetorder" /></td>
                                            <td width="10%"><input type="text" class="span12" name="targetvalue" /></td>
                                        </tr>
                                        <tr>
                                            <td>Nigeria</td>
                                            <td>Northern</td>
                                            <td>Taraba, Kaduna, Yobe, Katsina</td>
                                            <td width="10%"><input type="text" class="span12" name="targetvisit" /></td>
                                            <td width="10%"><input type="text" class="span12" name="targetorder" /></td>
                                            <td width="10%"><input type="text" class="span12" name="targetvalue" /></td>
                                        </tr>-->
                                    </tbody>
                                </table>
                            </div>

                            <div id="states" class="tab-pane">
                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th> Country </th>
                                            <th> State </th>
                                            <th> Short name </th>
                                            <th width="10%"> Visit Target </th>
                                            <th colspan="2" width="20%"> 
                                    <p class="center">Sales Target</p>
                                    <div class="clearfix"></div>
                                    <p class="pull-left">Count</p><p class="pull-right">Value</p>
                                    </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(isset($states)) {
                                                    for($i = 0; $i < count($states); $i++) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $states[$i]['Country']['countryname']; ?></td>
                                                    <td><?php echo $states[$i]['State']['statename']; ?></td>
                                                    <td><?php echo $states[$i]['State']['internalid']; ?></td>
                                                    <td width="10%"><input type="text" class="span12" name="s_<?php echo $states[$i]['State']['id']; ?>_targetvisit" /></td>
                                                    <td width="10%"><input type="text" class="span12" name="s_<?php echo $states[$i]['State']['id']; ?>_targetorder" /></td>
                                                    <td width="10%"><input type="text" class="span12" name="s_<?php echo $states[$i]['State']['id']; ?>_targetvalue" /></td>
                                                </tr>
                                        <?php 
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div id="towngroups" class="tab-pane">
                                <?php 
                                    if(isset($locationgroups) && count($locationgroups) != 0) {
                                ?>
                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th> State </th>
                                            <th> Town Groups </th>
                                            <th> Towns </th>
                                            <th width="10%"> Visit Target </th>
                                            <th colspan="2" width="20%"> 
                                    <p class="center">Sales Target</p>
                                    <div class="clearfix"></div>
                                    <p class="pull-left">Count</p><p class="pull-right">Value</p>
                                    </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            for($i = 0; $i < count($locationgroups); $i++) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $locationgroups[$i]['State']['statename']; ?></td>
                                                    <td><?php echo $locationgroups[$i]['Locationgroup']['locationgroupname']; ?></td>
                                                    <td><?php echo $locationgroups[$i]['Locationgroup']['locations']; ?></td>
                                                    <td width="10%"><input type="text" class="span12" name="lg_<?php echo $locationgroups[$i]['Locationgroup']['id']; ?>_targetvisit" /></td>
                                                    <td width="10%"><input type="text" class="span12" name="lg_<?php echo $locationgroups[$i]['Locationgroup']['id']; ?>_targetorder" /></td>
                                                    <td width="10%"><input type="text" class="span12" name="lg_<?php echo $locationgroups[$i]['Locationgroup']['id']; ?>_targetvalue" /></td>
                                                </tr>
                                        <?php 
                                            } 
                                        ?>
                                    </tbody>
                                </table>
                                <?php 
                                    } else {
                                ?>
                                    <p>No Town Groups set up. <?php echo $this->Html->link('Setup town groups',
                                            array('controller'=>'locationgroups', 'action' => 'index')); ?></p>
                                <?php 
                                    } 
                                ?>
                            </div>
                            
                            <div id="towns" class="tab-pane">
                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th> State </th>
                                            <th> Town </th>
                                            <th width="10%"> Visit Target </th>
                                            <th colspan="2" width="20%"> 
                                    <p class="center">Sales Target</p>
                                    <div class="clearfix"></div>
                                    <p class="pull-left">Count</p><p class="pull-right">Value</p>
                                    </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(isset($locations)) {
                                                    for($i = 0; $i < count($locations); $i++) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $locations[$i]['State']['statename']; ?></td>
                                                    <td><?php echo $locations[$i]['Location']['locationname']; ?></td>
                                                    <td width="10%"><input type="text" class="span12" name="l_<?php echo $locations[$i]['Location']['id']; ?>_targetvisit" /></td>
                                                    <td width="10%"><input type="text" class="span12" name="l_<?php echo $locations[$i]['Location']['id']; ?>_targetorder" /></td>
                                                    <td width="10%"><input type="text" class="span12" name="l_<?php echo $locations[$i]['Location']['id']; ?>_targetvalue" /></td>
                                                </tr>
                                        <?php 
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                </div>
                
                <div class="row-fluid">
                    <div class="form-actions">
                        <div class="offset4">
                            <button class="btn btn-info" type="submit">
                                <i class="icon-ok bigger-110"></i>
                                Save Changes
                            </button>
        <!--
                            &nbsp; &nbsp; &nbsp;
                            <button class="btn" type="reset">
                                <i class="icon-undo bigger-110"></i>
                                Cancel
                            </button>-->
                        </div>
                    </div>
                </div>
                
                <?php echo $this->Form->end(); ?>
                </div>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->