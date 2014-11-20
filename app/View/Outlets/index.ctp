<div class="main-content">

    <?php /*echo $this->element('breadcrumb'); */?>


    <div class="page-content">

        <!--.page-header-->
        
        <?php if(count($outlets) == 0): ?>
            
        <div class="page-header position-relative">
                <h1>
                    Outlets Management
                    <small>
                        <i class="icon-double-angle-right"></i>
                        analysis, creation and views
                        <?php 
                            if(isset($filtertext) && isset($filtertext) && $filtertext != '') {
                                echo " [Filter: {$filtertext}]";
                            }
                        ?>
                    </small>
                </h1>
            </div><!--/.page-header-->
            <div class="row">
                <h3 class="text-center text-warning">No outlet record available</h3>
            </div>
            
        <?php else: ?>
        
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

        <?php echo $this->element('filter_bar_outlet'); ?>

            <div class="row-fluid">
                <div class="span3" style="margin: 0px">
                    <div class="visit-accuracy">
                        <a href="outlets/all">
                            <div class="border">
                                <span class="visit-value"><?php echo $outlet_count; ?></span>
                                <span class="visit-name">Total Outlets</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="span3">
                    <div class="statitem distribution border">
                        <div class="stattitle title-d">Retail Classification</div>
                        <?php
                        $i = 0;
                        foreach ($distributions as $distribution): ?>
                            <div class="statvalue distrib"><?php echo $distribution[0]['count'] ?></div>
                            <?php echo $this->Html->link($distribution['Retailtype']['retailtypename'],
                                array('action' => 'all', '?' => array('otype' => $distribution['Retailtype']['id']))) ?>
                            <?php if($i == count($distribution)): ?>
                                <div class="clr"></div>
                            <?php else: ?>
                                <div class="clr border-d"></div>
                            <?php endif;
                            $i++
                            ?>
                        <?php endforeach; ?>

                    </div>
                </div>

                <div class="span3">
                    <div id="statcontainer">
                        <div class="statitem high">
                            <div class="stattitle title-h">Most crowded Territories</div>
                            <?php if (isset($most_location[0])): ?>
                                <div class="statvalue"><?php echo $most_location[0][0]['count']; ?></div> Outlets in
                                <span class="statloc"><?php echo $most_location[0]['Territory']['territoryname']; ?></span>
                                <div class="clr border-h"></div>
                            <?php endif; ?>
                            <?php if (isset($most_location[1])): ?>
                                <div class="statvalue"><?php echo $most_location[1][0]['count']; ?></div> Outlets in
                                <span class="statloc"><?php echo $most_location[1]['Territory']['territoryname']; ?></span>
                                <div class="clr border-h"></div>
                            <?php endif; ?>
                            <?php if (isset($most_location[2])): ?>
                                <div class="statvalue"><?php echo $most_location[2][0]['count']; ?></div> Outlets in
                                <span class="statloc"><?php echo $most_location[2]['Territory']['territoryname']; ?></span>
                                <div class="clr"></div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <div class="span3">
                    <div id="statcontainer">
                        <div class="statitem low">
                            <div class="stattitle title-l">Least crowded Territories</div>
                            <?php if (isset($least_location[0])): ?>
                                <div class="statvalue"><?php echo $least_location[0][0]['count']; ?></div> Outlets in
                                <span class="statloc"><?php echo $least_location[0]['Territory']['territoryname']; ?></span>
                                <div class="clr border-l"></div>
                            <?php endif; ?>
                            <?php if (isset($least_location[1])): ?>
                                <div class="statvalue"><?php echo $least_location[1][0]['count']; ?></div> Outlets in
                                <span class="statloc"><?php echo $least_location[1]['Territory']['territoryname']; ?></span>
                                <div class="clr border-l"></div>
                            <?php endif; ?>
                            <?php if (isset($least_location[2])): ?>
                                <div class="statvalue"><?php echo $least_location[2][0]['count']; ?></div> Outlets in
                                <span class="statloc"><?php echo $least_location[2]['Territory']['territoryname']; ?></span>
                                <div class="clr"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <!--Customer Distribution-->
                <h3 class="header smaller lighter green">Outlet Distribution</h3>
                <div class="span6" style="margin-left: 0px;">
                    <div id="advocacy_class" style="min-width: 250px; height: 350px; margin: 0 auto;"></div>
                </div>
                <!--<div class="span4" style="margin-left: 0px;">
                    <div id="outlet_channels" style="min-width: 250px; height: 350px; margin: 0 auto;"></div>
                </div>-->
                <div class="span6" style="margin-left: 0px;">
                    <div id="outlet_retail" style="min-width: 250px; height: 350px; margin: 0 auto;"></div>
                </div>
            </div>        
        


        <div class="row-fluid">
            <div class="row-fluid">
                <div class="span12" style="height: auto">
                    <h3 class="span12 header smaller lighter green">Outlet Growth</h3>
                    <div id="outlet_perfomance" style="min-width: 310px; min-height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
        <!--/.row-fluid-->

        <div class="row-fluid">
            <!--Last 10 Outlet added-->
            <div class="span12">
                <div class="row-fluid">
                    <h3 class="span12 header smaller lighter green">Recently added Outlets
                        <?php
                        echo $this->Html->link('<i class="icon-list"></i> View all', array('controller' => 'outlets', 'action' => 'all'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                        ?>
                    </h3>
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th> S/N </th>
                                <th> Name</th>
                                <th> Contact First Name</th>
                                <th> Contact Phone Number</th>
                                <th> Retailtype </th>
                                <th> Location </th>
                                <th> Added By </th>
                                <th width="10%" style="text-align: center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($outlets as $outlet):
                                ?>
                                <tr>
                                    <td width="5%"> <?php echo++$i ?> </td>
                                    <td> <?php echo $outlet['Outlet']['outletname']; ?>  </td>
                                    <td> <?php echo $outlet['Outlet']['contactfirstname']; ?>  </td>
                                    <td> <?php echo $outlet['Outlet']['contactphonenumber']; ?>  </td>
                                    <td> <?php echo $outlet['Retailtype']['retailtypename']; ?>  </td>
                                    <td> <?php echo $outlet['Location']['locationname']; ?> </td>
                                    <td> <?php echo $outlet['0']['fullname']; ?> </td>

                                    <td style="text-align: center"> 
                                        <div class="hidden-phone visible-desktop action-buttons">
                                            <?php
                                            echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i>', 
                                                    array('controller' => 'outlets', 'action' => 'view', $outlet['Outlet']['id']), 
                                                    array('class' => 'blue', 'escape' => false,
                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'View'));
                                            ?> |
                                            <?php
                                            echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', 
                                                    array('controller' => 'outlets', 'action' => 'edit', $outlet['Outlet']['id']), 
                                                    array('class' => 'green', 'escape' => false,
                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Edit'));
                                            ?> | 
                                            <?php
                                            echo $this->Html->link(
                                                    '<i class="icon-trash bigger-130"></i>', 
                                                    array('controller' => 'outlets', 'action' => 'delete', $outlet['Outlet']['id']), 
                                                    array('class' => 'red', 'escape' => false,
                                                    "data-rel" => "tooltip", "data-placement" => "top", "data-original-title" => 'Delete'), true);
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php unset($outlets); ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div><!--/.row-fluid-->

        <div class="row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <h3 class="span12 header smaller lighter green">Map - Distribution of Outlet
                        <?php
                        echo $this->Html->link('<i class="icon-list"></i> Maps View', array('controller' => 'maps', 'action' => 'index'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                        ?>
                    </h3>
                    <h5 class="text-warning"><strong> Map Legend </strong></h5><br />
                    <?php foreach ($markerIndex as $key => $value) { ?> 
                        <div class="span2">
                        <img src="<?php echo 'assets/js/custommarkers/'. $markers[$value]; ?>" />    
                         <!--<br />-->
                        <?php
                             echo $retailtypes[$key];
                        ?> 
                        </div>
                    <?php } ?>
                    
                    <div class="clearfix"></div>
                    <br />
                    
                    <div id="outlet-map-canvas"  style="height:600px; margin-left: 0px" class="span12"></div>
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


