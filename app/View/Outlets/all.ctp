<div class="main-content">


    <?php echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <?php //if(count($outlets) == 0): ?>
            
        <!-- <div class="page-header position-relative">
                <h1>
                    Outlets Management
                    <small>
                        <i class="icon-double-angle-right"></i>
                        analysis, creation and views
                    </small>
                </h1>
            </div>            
            <div class="row">
                <h3 class="text-center text-warning">No outlet record available</h3>
            </div> -->
            

        <?php //else: ?>
        
        <div class="page-header position-relative">

            <h1>
                Outlets Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    analysis, creation and views
                     <?php 
                            if(isset($filtertext) && $filtertext != '') {
                                echo " [Filter: {$filtertext}]";
                            }
                        ?>
                </small>
                <div class="pull-right">
                    <form class="form-inline">
                        <label>Filter </label>            
                        <label>
                            <input id="toggleFilter" name="toggleFilter" 
                                   <?php 
                                if(isset($filtertext) && $filtertext != '') {
                                    echo 'data-open="on"'; 
                                } else {
                                    echo 'data-open="off"'; 
                                }    ?> 
                                   class="ace ace-switch ace-switch-4" type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </form>
                </div>
            </h1>

        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <?php //echo $this->element('filter_bar'); ?>

<!-- Beginning of filter bar -->

        <?php echo $this->Form->create(null, 
                array('method' => 'POST', 
        //              'controller'=>$this->params['controller'], 
        //              'action'=>$this->params['action'], 
                      'class' => 'form-inline', 
                      'name' => 'filterform')); ?>    

        <div class="filter-bar" id="filter-bar">
            <h4 class="header smaller lighter green">Filter</h4>

            <div class="span3" id="locationcontainer">
                <label>Location</label>
                <?php echo $this->Form->select('locFilter', $locations, 
                        array('id' => 'filter-all-location')); ?>
                <!--<input type="hidden" name="floc" id="floc" value="">-->
                      </div>

            <div class="span3" id="usercontainer">
                <label>Users</label>
                <?php echo $this->Form->select('userFilter', $fieldreplist, array('id' => 'filter-all-user')); ?>
                <!--<input type="hidden" name="fusr" id="fusr" value="">-->
            </div>

            <div class="span3" id="datecontainer">
                <label>Date</label>
                <?php echo $this->Form->select('dateFilter', $datelist, array('id' => 'filter-all-date')); ?>

                <div id="dateoption">
                    <div class="input-append filter-date-picker">
                        <?php echo $this->Form->input('sdate', array('placeholder' => 'Start date', 
                            'class' => 'datepicker input-small input-mask-date',
                            'id' => 'sdate',
                            'label' => false,
                            'type'=>'text', 
                            'readonly')); 
                        ?>
                        
                        <!--<input name="sdate" placeholder="Start date" class="datepicker input-small input-mask-date" id="sdate" type="text" readonly>-->
                        <span class="btn btn-small">
                            <i class="icon-calendar bigger-110"></i>
                        </span>
                    </div>
                    <div class="input-append filter-date-picker">
                        <?php echo $this->Form->input('edate', array('placeholder' => 'End date', 
                            'class' => 'datepicker input-small input-mask-date',
                            'id' => 'edate',
                            'label' => false,
                            'type'=>'text', 
                            'readonly')); ?>
                        <!--<input name="data[edate]" placeholder="End date" class="datepicker datepicker input-small input-mask-date" id="edate" type="text" readonly>-->
                        <span class="btn btn-small">
                            <i class="icon-calendar bigger-110"></i>
                        </span>
                    </div>
                </div>

                <?php // echo $this->Form->input('sdate', array('placeholder' => 'Start date', 'class' => 'datepicker', 'id' => 'sdate')); ?>

                <?php // echo $this->Form->input('edate', array('placeholder' => 'End date', 'class' => 'datepicker', 'id' => 'edate')); ?>
            </div>

            <div class="span2" style="margin-top: 20px;">
                <!-- <input type="submit" class="btn btn-small btn-success btnfilter" id="btnallfilter" value="Go" onclick="return false;" /> -->
                <!--<button href="<?php echo $this->here; ?>" class="btn btn-small btn-success btnfilter" id="btnfilter">-->
                    <!--<i class="icon-search bigger-160"></i>-->
                    <!--Go</a>-->
                <a id="btnallreset" class="btn btn-small btn-inverse btnfilter">Reset</a>
        <!--            <i class="icon-undo bigger-160"></i>
                    Reset
                </a>-->
            </div>
            <br /><br />
            <br /><br />
            <br /><br />
            <br /><br />
            <div class="span1"></div>
        </div>

        <?php echo $this->Form->end(); ?>

        <!-- End of filter bar -->

        <div class="row-fluid">

            <div class="span12">
                <div class="row-fluid">
                    <h3 class="span12 header smaller lighter green">All Outlets</h3>

                    <!-- <div style="text-align: center;">

                        <h4 class="text-info">Showing page <?php 
                        //echo $this->Paginator->counter(); ?></h4>

                        <div class="pagination">
                            <ul>
                                <?php
                                // echo $this->Paginator->numbers(array(
                                //     'first' => '<<',
                                //     'separator' => '',
                                //     'currentClass' => 'active',
                                //     'tag' => 'li',
                                //     'last' => '>>'
                                //));
                                ?>
                            </ul>
                        </div>
                    </div> -->

                    <table id="outlet_all_table" class="table table-striped table-bordered table-hover display">
                        
                        <thead>
                            <tr>
                                <!-- <th width="10px"> S/N </th> -->
                                <th> Name</th>
                                <th width="10%"> Added by</th>
                                <th width="10%"> Location </th>
                                <th width="10%"> Phone Number </th>
                                <th width="10%"> Type </th>
                                <th width="17%"> Channel </th>                         
                                <th width="13%"> Date Added </th>
                                <th width="10%" style="text-align: center"> Actions </th>
                            </tr>
                        </thead>
                        
                    </table>
                    
                    <!-- <div style="text-align: center;">

                        <h4 class="text-info">Showing page <?php 
                        //echo $this->Paginator->counter(); ?> Outlets</h4>

                        <div class="pagination">
                            <ul>
                                <?php
                                // echo $this->Paginator->numbers(array(
                                //     'first' => '<<',
                                //     'separator' => '',
                                //     'currentClass' => 'active',
                                //     'tag' => 'li',
                                //     'last' => '>>'
                                //));
                                ?>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>
        </div><!--/.row-fluid-->
        <?php //endif; ?>
        
        
    </div><!--/.page-content-->
</div><!--/.main-content-->