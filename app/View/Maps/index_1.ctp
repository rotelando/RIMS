<div class="main-content">


    <?php echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <?php if($outlet_count == 0): ?>
            
        <div class="page-header position-relative">
                <h1>
                    Maps View
                    <small>
                        <i class="icon-double-angle-right"></i>
                        visits, outlets, sales etc.
                    </small>
                </h1>
            </div><!--/.page-header-->
            <div class="row">
                <h3 class="text-center text-warning">No map data available</h3>
            </div>
            
        <?php else: ?>
            
        <div class="page-header position-relative">

            <h1>
                Maps View
                <small>
                    <i class="icon-double-angle-right"></i>
                    visits, outlets, sales etc.
                </small>
                <div class="pull-right">
                    <form class="form-inline">
                        <label>Filter </label>            
                        <label>
                            <input id="toggleFilter" name="toggleFilter" class="ace ace-switch ace-switch-4" type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </form>
                </div>
            </h1>
        </div><!--/.page-header-->



        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <?php // echo $this->element('filter_bar'); ?>



        <div class="span11" style="margin: 0px;">
            <?php echo $this->Form->create(null, array('method' => 'POST', 'controller' => 'orders', 'action' => 'index', 'class' => 'form-inline', 'name' => 'filterform')); ?>    
            <div class="filter-bar" id="filter-bar">
                <h4 class="header smaller lighter green">Filter</h4>

                <div class="span3" style="margin: 0px;">
                    <label>Location</label>
                    <?php echo $this->Form->select('locFilter', $locations, array('id' => 'filter-location')); ?>
                </div>

                <div class="span3">
                    <label>Users</label>
                    <?php echo $this->Form->select('userFilter', $fieldreplist, array('id' => 'filter-user')); ?>
                </div>

                <div class="span3">
                    <label>Date</label>
                    <?php echo $this->Form->select('dateFilter', $datelist, array('id' => 'filter-date')); ?>

                    <div id="dateoption">
                        <div class="input-append filter-date-picker">
                            <input name="data[sdate]" placeholder="Start date" class="datepicker input-small input-mask-date" id="sdate" type="text" readonly>
                            <span class="btn btn-small">
                                <i class="icon-calendar bigger-110"></i>
                            </span>
                        </div>
                        <div class="input-append filter-date-picker">
                            <input name="data[edate]" placeholder="End date" class="datepicker datepicker input-small input-mask-date" id="edate" type="text" readonly>
                            <span class="btn btn-small">
                                <i class="icon-calendar bigger-110"></i>
                            </span>
                        </div>
                    </div>

                    <?php // echo $this->Form->input('sdate', array('placeholder' => 'Start date', 'class' => 'datepicker', 'id' => 'sdate')); ?>

                    <?php // echo $this->Form->input('edate', array('placeholder' => 'End date', 'class' => 'datepicker', 'id' => 'edate')); ?>
                </div>

                <div class="span2">
                    <!--<input type="submit" class="btn btn-app btn-success btn-mini" value="Go" />-->
                    <a href="<?php echo $this->here; ?>" class="btn btn-small btn-success btnfilter" id="btnfilter">
                        <i class="icon-search bigger-160"></i>
                        Go</a>
                    <a type="reset" id="btnreset" class="btn btn-small btn-inverse btnfilter" id="btnfilter">
                        <i class="icon-undo bigger-160"></i>
                        Reset
                    </a>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>

        </div>


        <div class="span6" style="margin-bottom: 10px; margin-left: 0px;">
            <div data-toggle="buttons-radio" class="btn-group" style="margin-bottom: 10px;">
                <label>Select Module</label>
                <button class="btn btn-primary btn-small active" type="button" id="btnoutlet">
                    <i class="icon-building"></i> Outlets
                </button>

                <button class="btn btn-primary btn-small" type="button" id="btnvisit">
                    <i class="icon-pushpin"></i> Visits
                </button>

<!--                <button class="btn btn-primary btn-small" type="button" id="btnmerchandising">
                    <i class="icon-bookmark"></i> Merchandising
                </button>

                <button class="btn btn-primary btn-small" type="button" id="btnprodavail">
                    <i class="icon-shopping-cart"></i> Product Availability
                </button>

                <button class="btn btn-primary btn-small" type="button" id="btnfieldstaff">
                    <i class="icon-user"></i> Field Staff
                </button>-->
            </div>
        </div>
        <div class="span5" style="margin-bottom: 10px; margin-left: 0px">
            <div class="pull-left" style="margin-top: 20px; margin-left: 0px">
                <input id="search-input" class="input-xlarge search-query" type="text" placeholder="Search Box">
                <button id="btnsearch" class="btn btn-purple btn-small">
                    Search
                    <i class="icon-search icon-on-right bigger-110"></i>
                </button>
            </div>
        </div>

        <div class="span6" style="margin-left: 0px; margin-top: 15px;">
            <h6 class="pull-left" style="margin: 7px 10px; font-weight: bold;"> - Options - </h6>
            <div class="btn-group pull-left" id="filteroutlettype">
                <button data-toggle="dropdown" class="btn btn-small btn-success dropdown-toggle" style="margin: 5px 5px 10px;">
                    Outlet Types
                    <i class="icon-angle-down icon-on-right"></i>
                </button>

                <ul class="dropdown-menu dropdown-success">
                    <li>
                        <a href="#" class="outlettype" data-id="0">All</a>
                    </li>
                    <li class="divider"></li>
                    <?php foreach ($outlettypes as $id => $typename): ?>
                        <li>
                            <a href="#" class="outlettype" data-id="<?php echo $id; ?>"><?php echo $typename; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="btn-group pull-left" id="filtervisitstatus">
                <button data-toggle="dropdown" class="btn btn-small btn-success dropdown-toggle" style="margin: 5px 10px 10px;">
                    Visit Status
                    <i class="icon-angle-down icon-on-right"></i>
                </button>

                <ul class="dropdown-menu dropdown-success">
                    <li>
                        <a href="#" data-id="2">All</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#" data-id="1">Visited</a>
                    </li>

                    <li>
                        <a href="#" data-id="0">Unvisited</a>
                    </li>
                </ul>
            </div>
            <div class="btn-group pull-left" id="filterbrands">
                <button data-toggle="dropdown" class="btn btn-small btn-success dropdown-toggle" style="margin: 5px 5px 10px;">
                    Brands
                    <i class="icon-angle-down icon-on-right"></i>
                </button>

                <ul class="dropdown-menu dropdown-success">
                    <li>
                        <a href="#">All</a>
                    </li>
                    <li class="divider"></li>
                    <?php foreach ($brands as $id => $brandname): ?>
                        <li>
                            <a href="#" class="outlettype" data-id="<?php echo $id; ?>"><?php echo $brandname; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        
        <!--<div class="pull-right" id="maploading"><?php // echo $this->Html->image('ajax-loader'); ?></div>-->

        <div class="row-fluid">
            <div id="map-canvas"  class="span12" style="min-height: 600px; width: 100%; margin: 0px; padding: 0px;">
            </div>
            <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
            However, it seems JavaScript is either disabled or not supported by your browser. 
            To view Google Maps, enable JavaScript by changing your browser options, and then 
            try again.
            </noscript>
        </div>
        <?php endif; ?>
    </div><!--/.page-content-->
</div><!--/.main-content-->