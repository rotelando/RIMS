<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        
         <?php if($prodavailcount == 0): ?>
            
            <div class="page-header position-relative">
                <h1>
                    Product Availabilities
                    <small>
                        <i class="icon-double-angle-right"></i>
                        views and comparison
                        <?php 
                            if(isset($filtertext) && $filtertext != '') {
                                echo " [Filter: {$filtertext}]";
                            }
                        ?>
                    </small>
                </h1>
            </div><!--/.page-header-->
            <div class="row">
                <h3 class="text-center text-warning">No record for product availabilities</h3>
            </div>
            
        <?php else: ?>
            
        <div class="page-header position-relative">

            <h1>
                Product Availabilities
                <small>
                    <i class="icon-double-angle-right"></i>
                    views and comparison
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
                <h3 class="span12 header smaller lighter green">Product Availability Share by Brands</h3>
                <div id="availability_dist" min-width="350px" height="450px"></div>
            </div>
            <div class="span6">
                <h3 class="span12 header smaller lighter green">Product Availability Share by Brand Products</h3>
                <div id="availability_dist_by_product" min-width="350px" height="450px"></div>
            </div>
        </div>
        
        <div class="row-fluid">
            <h3 class="span12 header smaller lighter green">Product Availability Comparison Chart</h3>
            <div id="prod_availability_comp" min-width="350px" height="450px"></div>
        </div>
        
        
        <div class="row-fluid">
            <?php 
                $col = count($availabilities[0]);
                $row = count($availabilities);
//                echo "Column = {$col}, Row = {$row}";
            ?>
            <h3 class="span12 header smaller lighter green">Product Availability Comparison Table</h3>
<!--            <h3 class="text-info" style="text-align: center">Brands</h3>-->

            
            <div class="prod_avail span12" style="margin-left: 0px;">
                
                <div style="height: 20px;"></div>
                
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="15%" class="brandproduct"> <?php echo $availabilities[0][0]; $i = 0; ?> </th>
                            <?php foreach ($availabilities[0] as $brand): 
                                if(++$i == 1) { continue; }
                                ?>
                                <th> <?php echo $brand['Brand']['brandname']; ?> </th>
                            <?php endforeach; ?>    
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $first = true;
                        foreach ($availabilities as $availabiliy):
                            if($first) {
                                $first = false;
                                continue;
                            }
                            $j = 0
                            ?>

                            <tr>
                                <?php foreach ($availabiliy as $prodcomp):
                                    if($j == 0):
                                    ?>
                                
                                    <td style="vertical-align: middle;" width="20%" class="brandproduct">
                                        <?php echo $prodcomp['Product']['productname']; ?>
                                    </td>
                                <?php else: 
                                    if(isset($prodcomp[0]['totalquantity']) && !is_null($prodcomp[0]['totalquantity'])):
                                    ?>
                                
                                <td class="compared cell-item center popover-notitle" 
                                                data-animation="true" 
                                                data-rel="popover"
                                                data-html="true"
                                                data-trigger="hover" 
                                                data-placement="bottom"  
                                                data-original-title="<?php echo $prodcomp['Product']['comparename'] . " Vs " . $prodcomp['Product']['productname']; ?>"
                                                data-content="<?php
                            echo '<strong>' . $prodcomp['Product']['comparename'] . '</strong>: ' . $prodcomp['Product']['comparequantity'] . '<br />';
                            echo '<strong>' . $prodcomp['Product']['productname'] . '</strong>: ' . $prodcomp[0]['totalquantity'];
                                            ?>"
                                                style="vertical-align: middle;" width="20%">
                                                    <?php echo $prodcomp[1]['percentage'] .'%  <span class="text-warning">( '. $prodcomp[0]['totalquantity'] .' )</span>'; ?>
                                            </td>
                                    <?php else: ?>
                                            <td class="not-compared cell-item" style="vertical-align: middle; text-align: center;">
                                            Not Available
                                        </td>
                                    <?php endif; ?> 
                                <?php endif; 
                                
                                        $j++;
                                    endforeach;

                                endforeach;
                                ?>

                            </tr>

                    </tbody>
                </table>
                
            </div>
        </div>
        
        <div class="row-fluid">
            <h3 class="span12 header smaller lighter green">Performance Monitor</h3>
            <div id="performance" height="400px" min-width="350px"></div>
        </div>
        
        <div class="row-fluid">
            <h3 class="span12 header smaller lighter green">Product Availability Share Map</h3>
            <div class="span7">
                <div style="text-align: center" id="availability-map"></div>
            </div>
            
            <div class="span4" style="margin-bottom: 50px;">
                <h3 id="pavstatename" class="text-info"></h3>
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> Brands</th>
                            <th> Products </th>
                            <th> Value (N) </th>
                        </tr>
                    </thead>
                    <tbody id="mapcontent">
                            
                    </tbody>
                </table>
            </div>
        </div><!--/.row-fluid-->
        <?php endif; ?>
    </div><!--/.page-content-->
</div><!--/.main-content-->