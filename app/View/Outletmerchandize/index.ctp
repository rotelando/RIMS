<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <?php if($visibilitycount == 0): ?>
            
        <div class="page-header position-relative">
                <h1>
                    Merchandising
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Visibility evaluations, merchandising counter, etc.
                    </small>
                </h1>
            </div><!--/.page-header-->
            <div class="row">
                <h3 class="text-center text-warning">No merchandising record available</h3>
            </div>
            
        <?php else: ?>
            
        <div class="page-header position-relative">

            <h1>
                Merchandising
                <small>
                    <i class="icon-double-angle-right"></i>
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
            <!--Visibility Evaluations-->
            <div class="span7">
                <h3 class="span12 header smaller lighter green">Visibility Shares
                    <?php
                    echo $this->Html->link('<i class="icon-list"></i> More',
                        array('controller'=>'outletmerchandize','action'=>'shares'),
                        array('class'=>'btn btn-mini btn-success pull-right', 'escape'=>false));
                    ?>
                </h3>
                <div class="span4">
                    <div class="visit-accuracy" style="width: 100%;">
                        <a href="outletmerchandize/all">
                        <div class="border">
                            <span class="visit-value"><?php echo $visibilitycount; ?></span>
                            <span class="visit-name">Visibility Counts</span>
                        </div>
                        </a>
                    </div>
                    <div class="visit-accuracy">
                        <a href="outletmerchandize/all">
                        <div class="border">
                            <span class="visit-value"><?php echo $merchandizecount; ?></span>
                            <span class="visit-name">Merchandize Count</span>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="span7">
                    <div id="visibility_share_brands" style="min-width: 250px; height: 400px"></div>
                </div>
            </div>

            <div class="span5">
                <h3 class="span12 header smaller lighter green">Top 10 outlet Merchandize</h3>

                    <table id="toptenmerchandize" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th> S/N </th>
                            <th> Brands</th>
                            <th> Merchandize </th>
                            <th> Count </th>
                            <th> Weight </th>
                            <th> Weighted Value </th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if(isset($toptenmerchandize)) {
                                foreach ($toptenmerchandize as $topten) {
                            ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                    <td><?php echo $topten['Brand']['brandname']; ?></td>
                                    <td><?php echo $topten['Merchandize']['name']; ?></td>
                                    <td><?php echo $topten['0']['elementcount']; ?></td>
                                    <td><?php echo $topten['Merchandize']['weight']; ?></td>
                                    <td><?php echo $topten['0']['weightedvalue']; ?></td>
                                </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>

            </div>
        </div><!--/.row-fluid-->

        <div class="row-fluid">
            <div class="span12" style="height: auto">
                <h3 class="span12 header smaller lighter green">Merchandising Count</h3>
                <div id="element_perfomance" style="min-width: 310px; min-height: 400px; margin: 0 auto"></div>
            </div>
        </div><!--/.row-fluid-->

        <!--Visibility evaluation table-->
        <div class="row-fluid">
            <?php 
                $col = count($brands);
                $row = count($merchandize);
//                echo "Column = {$col}, Row = {$row}";
            ?>
            <h3 class="span12 header smaller lighter green">Visibility Count Summary</h3>
<!--            <h3 class="text-info" style="text-align: center">Brands</h3>-->

            
            <div class="prod_avail span12" style="margin-left: 0px;">
                
                <div style="height: 20px;"></div>
                
                <table class="table table-striped table-bordered table-hover">
                    
                    <thead>
                        <tr>
                            <th class="brandproduct"> <?php echo 'Visibilitity Elements'; $i = 0; ?> </th>
                            <?php foreach ($brands as $brand): ?>
                                <th> <?php echo $brand['Brand']['brandname']; ?> </th>
                            <?php endforeach; ?>
                            <th> Total </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $j = 0;
                            for($j = 0; $j < count($visibilitytable); $j++) {
                        ?>
                            <tr>
                                <td style="vertical-align: middle; text-align: left; padding-left: 10px;" width="15%" class="brandproduct">
                                        <?php 
                                            echo $merchandize[$j]['Merchandize']['name'];
                                        ?>
                                </td>
                                <?php 
                                        for($k = 0; $k < count($visibilitytable[$j]); $k++) {
                                ?>
                                
                                <?php if($k == $col){ ?>
                                        
                                        <td class="" width="15%" style="vertical-align: middle;">
                                                <?php echo $visibilitytable[$j][$k]['sumtotal']; ?>
                                        </td>
                                        
                                <?php   } else {
                                        if(isset($visibilitytable[$j][$k][0]['totalquantity']) && !is_null($visibilitytable[$j][$k][0]['totalquantity'])):
                                    ?>
                                            <td class="" width="15%" style="vertical-align: middle;">
                                                <?php echo $visibilitytable[$j][$k][0]['totalquantity']; ?>
                                            </td>
                                    <?php else: ?>
                                            <td class="" width="15%" style="vertical-align: middle; text-align: center;">
                                            0
                                        </td>
                                <?php
                                        endif;
                                        }
                                      }
                                    }
                                ?>

                            </tr>

                    </tbody>
                </table>
                
            </div>
        </div>
        
        <div class="row-fluid">
            <h3 class="span12 header smaller lighter green">Outlet Merchandize Share Map</h3>
            <div class="span7">
                <div style="text-align: center" id="visibility-map"></div>
            </div>
            
            <div class="span4" style="margin-bottom: 50px;">
                <h3 id="vstatename" class="text-info"></h3>
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> Brands</th>
                            <th> Visibility Element </th>
                            <th> Count </th>
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


