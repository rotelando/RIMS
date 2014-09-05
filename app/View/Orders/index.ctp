<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        
        <?php if(count($sales) == 0): ?>
            
            <div class="page-header position-relative">
                <h1>
                    Sales Management
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Sales, Orders and requests
                    </small>
                </h1>
            </div><!--/.page-header-->
            <div class="row">
                <h3 class="text-center text-warning">No sales record available</h3>
            </div>
            
        <?php else: ?>
            
        <div class="page-header position-relative">

            <h1>
                Sales Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    Sales, Orders and requests
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
                            <input id="toggleFilter" 
                                    <?php 
                                if(isset($filtertext) && $filtertext != '') {
                                    echo 'data-open="on"'; 
                                } else {
                                    echo 'data-open="off"'; 
                                }    ?> 
                                   name="toggleFilter" class="ace ace-switch ace-switch-4" type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </form>
                </div>
            </h1>

        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <?php echo $this->element('filter_bar'); ?>

        <div class="row-fluid">

            <div class="span6">
                <h3 class="span12 header smaller lighter green">Sales distribution by Brand Products</h3>
                <div id="order_dist" min-width="350px" height="450px"></div>
            </div>

            <div class="span6">
                <h3 class="span12 header smaller lighter green">Sales Accuracy and Values</h3>

                <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#salesaccuracy">
                                <i class="green icon-shopping-cart bigger-110"></i>
                                Sales Accuracy
                                <!--<span class="badge badge-important">5</span>-->
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#salesvalue">
                                <i class="green icon-bookmark bigger-110"></i>
                                Sales Value
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <!--End the content of #Sales Accuracy tab-->
                        <div id="salesaccuracy" class="tab-pane active">

                            <div class="span3">
                                <div class="order-accuracy">
                                    <div class="border">
                                        <span class="order-value"><?php echo 'N' . $ordercount; ?></span>
                                        <br /><br />
                                        <span class="order-name">Actual Sales</span>
                                    </div>
                                    <div class="border">
                                        <span class="order-value"><?php echo 'N' . $setting['Setting']['TargetOrder']; ?></span>
                                        <br /><br />
                                        <span class="order-name">Target Sales</span>
                                    </div>
                                </div>
                            </div>
                            <div class="span8 offset1">
                                <div class="grid1 center">

                                    <div class="actual-target-chart" data-size="200" data-percent="<?php echo $actual_vs_target; ?>" >
                                        <span class="percent"><?php echo $actual_vs_target . '%'; ?></span>
                                    </div>

                                    <div class="space-2"></div>
                                    <span class="order-label offset1">Actual Vs. Target Sales</span>
                                </div>

                                <div class="clearfix"></div>
                                <div class="space10"></div>
                            </div>

                        </div>
                        <!--End the content of #Sales Accuracy tab-->

                        <!--The content of #Sales Value tab-->
                        <div id="salesvalue" class="tab-pane">

                            <table id="sample-table-1" class="table table-striped table-bordered table-hover" style="margin-left: 0px;">
                                <thead>
                                    <tr>
                                        <th width="10%"> S/N </th>
                                        <th width="30%"> Product </th>
                                        <th width="30%"> Quantity Sold</th>
                                        <th width="30%"> Value (N)</th>
                                        <!--<th width="15%" style="text-align: center"> Actions </th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($sales as $sale):
                                        ?>
                                        <tr>
                                            <td width="5%"> <?php echo ++$i ?> </td>
                                            <td width="10%"> <?php echo $sale['Product']['productname']; ?> </td>
                                            <td><?php echo $sale[0]['count']; ?></td>
                                            <td>
                                                <?php 
                                                    if (isset($sale[0]['totalordervalue'])) {
                                                        echo round($sale[0]['totalordervalue'], 2); 
                                                    } else {
                                                        echo 0.00; 
                                                    }
                                                ?>
                                            </td>
<!--                                            <td style="text-align: center"> 
                                                <?php
//                                                echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> View', array('controller' => 'orders', 'action' => 'view', $sale['Order']['id']), array('class' => 'blue', 'escape' => false));
                                                ?>
                                            </td>-->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!--End the content of #Sales Value tab-->

                        <!--End the content of #Sales tab-->
                        <!--                        <div id="orders" class="tab-pane">
                                                    <h3 class="span12 header smaller lighter green"> Sales</h3>
                        
                                                    <table id="sample-table-1" class="table table-striped table-bordered table-hover" style="margin-left: 0px;">
                                                    </table>
                                                </div>-->
                        <!--End the content of #Sales tab-->

                    </div>
                </div>

            </div>
        </div><!--/.row-fluid-->

        <div class="row-fluid">
            <div class="span12">
                <h3 class="span12 header smaller lighter green">Sales Growth</h3>
                <div id="sales_performance" style="min-width: 250px; height: auto; margin: 0 auto;"></div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="row-fluid">
                <div class="span12" style="height: auto">
                    <h3 class="span12 header smaller lighter green">Recent Sales
                        <?php
                        echo $this->Html->link('<i class="icon-list"></i> View all', array('controller' => 'orders', 'action' => 'all'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                        ?>
                    </h3>
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="3%"> S/N </th>
                                <th> Outlet Name</th>
                                <th width="13%"> Product </th>
                                <th width="13%"> Quantity </th>
                                <th> Discount </th>
                                <th width="5%"> Status </th>                                
                                <th width="20%" style="text-align: center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($orders as $order):
                                ?>
                                <tr>
                                    <td width="5%"> <?php echo ++$i ?> </td>
                                    <td> <?php
                                        echo $this->Html->link($order['Outlet']['outletname'], array(
                                            'controller' => 'outlets', 'action' => 'view', $order['Outlet']['id']
                                        ));
                                        ?>  </td>
                                    <td> <?php echo $order['Product']['productname']; ?> </td>
                                    <td> <?php echo $order['Order']['quantity']; ?> </td>
                                    <td> <?php echo $order['Order']['discount']; ?> </td>
                                    <td> <?php echo $order['Orderstatus']['orderstatusname']; ?> </td>
                                    <td style="text-align: center"> 

                                        <?php
                                        echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> Visit Details', array('controller' => 'visits', 'action' => 'view', $order['Order']['visitid']), array('class' => 'blue', 'escape' => false));
                                        ?>

                                        <?php
//                                        echo ' | ' . $this->Html->link(
//                                                '<i class="icon-pencil bigger-130"></i> Edit', array('controller' => 'orders', 'action' => 'edit', $order['Order']['id']), array('class' => 'green', 'escape' => false));
                                        ?> 

                                        <?php
                                        if (isset($setting['Setting']['DeleteVisit']) && $setting['Setting']['DeleteVisit'] == 'on') {
                                            echo ' | ' . $this->Html->link(
                                                    '<i class="icon-trash bigger-130"></i> Delete', array('controller' => 'orders', 'action' => 'delete', $order['Order']['id']), array('class' => 'red', 'escape' => false), true);
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--/.row-fluid-->

        <div class="row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <h3 class="span12 header smaller lighter green">Map - Sales Distribution by Products
                        <?php
                        echo $this->Html->link('<i class="icon-list"></i> More', array('controller' => 'maps', 'action' => 'index'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                        ?>
                    </h3>
                    <div class="pull-right span2">
                        <label>Select Product</label>
                        <div class="btn-group" id="filtervisitstatus">
                            <button data-toggle="dropdown" class="btn btn-block btn-primary dropdown-toggle" style="margin: 5px 0px 10px;">
                                Brand Products
                                <i class="icon-angle-down icon-on-right"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-primary">
                                <li>
                                    <a class="orderproducts" data-id="0">All</a>
                                </li>
                                <li class="divider"></li>
                                <?php foreach ($brandproductlist as $id => $productname): ?>
                                    <li>
                                        <a class="orderproducts" data-id="<?php echo $id; ?>"><?php echo $productname; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                    </div>
                    <div id="order-map-canvas"  style="height:600px; margin-left: 0px" class="span12"></div>
                    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
                    However, it seems JavaScript is either disabled or not supported by your browser. 
                    To view Google Maps, enable JavaScript by changing your browser options, and then 
                    try again.
                    </noscript>
                </div>

            </div>
        </div><!--/.row-fluid-->
        <?php endif; ?>
    </div><!--/.page-content-->
</div><!--/.main-content-->