<div class="main-content">

    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">

        <!--.page-header-->
        <?php if($outlet_count == 0): ?>
            
        <div class="page-header position-relative">
                <h1>
                    <i class="icon-dashboard"></i>
                    Dashboard
                <small>
                    <i class="icon-double-angle-right"></i>
                    overview &amp; stats
                    </small>
                </h1>
            </div><!--/.page-header-->
            <div class="row">
                <h3 class="text-center text-warning">No data records available.</h3>
            </div>
            
        <?php else: ?>
            
        <div class="page-header position-relative">
            <h1>
                <i class="icon-dashboard"></i>
                Dashboard
                <small>
                    <i class="icon-double-angle-right"></i>
                    overview &amp; stats
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

        <?php //echo $this->element('dashboard-page-tab'); ?>


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

            <!--Outlet Types-->
            <div class="span3">
                <div class="statitem distribution border">
                    <div class="stattitle title-d">Outlet Types</div>
                    <?php
                    $i = 0;
                    if(isset($outclass)) {
                        foreach ($outclass as $outletclass): ?>
                            <div class="statvalue distrib"><?php echo $outletclass[0]['count'] ?></div>
                            <?php echo $outletclass['Outletclass']['outletclassname']; ?>
                            <?php if($i == count($outclass)): ?>
                                <div class="clr"></div>
                            <?php else: ?>
                                <div class="clr border-d"></div>
                            <?php endif;
                            $i++
                            ?>
                    <?php
                        endforeach;
                    }
                    ?>

                </div>
            </div>

            <!--Most Crowded Territories-->
            <div class="span3">
                <div id="statcontainer">
                    <div class="statitem high">
                        <div class="stattitle title-h">Most covered</div>
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
        </div>

            <div class="row-fluid">
                <!--Total Merchandize-->
                <div class="span3" style="margin: 0px">
                    <div class="visit-accuracy">
                        <a href="#">
                            <div class="border">
                                <span class="visit-value"><?php echo $merchandize_count; ?></span>
                                <span class="visit-name">Total Merchandize</span>
                            </div>
                        </a>
                    </div>
                </div>
                <!--Least crowded Territories-->
                <div class="span3">
                    <div id="statcontainer">
                        <div class="statitem low">
                            <div class="stattitle title-l">Least covered</div>
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

                <!--Most Visibility Territories-->
                <div class="span3">
                    <div id="statcontainer">
                        <div class="statitem high">
                            <div class="stattitle title-h">Most Visibility</div>
                            <?php if (isset($most_visibility[0])): ?>
                                <div class="statvalue"><?php echo $most_visibility[0][0]['weightedcount']; ?></div> Merchandize in
                                <span class="statloc"><?php echo $most_visibility[0]['Territory']['territoryname']; ?></span>
                                <div class="clr border-h"></div>
                            <?php endif; ?>
                            <?php if (isset($most_visibility[1])): ?>
                                <div class="statvalue"><?php echo $most_visibility[1][0]['weightedcount']; ?></div> Merchandize in
                                <span class="statloc"><?php echo $most_visibility[1]['Territory']['territoryname']; ?></span>
                                <div class="clr border-h"></div>
                            <?php endif; ?>
                            <?php if (isset($most_visibility[2])): ?>
                                <div class="statvalue"><?php echo $most_visibility[2][0]['weightedcount']; ?></div> Merchandize in
                                <span class="statloc"><?php echo $most_visibility[2]['Territory']['territoryname']; ?></span>
                                <div class="clr"></div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <!--Least Visibility Territories-->
                <div class="span3">
                    <div id="statcontainer">
                        <div class="statitem low">
                            <div class="stattitle title-l">Least Visibility Territories</div>
                            <?php if (isset($least_visibility[0])): ?>
                                <div class="statvalue"><?php echo $least_visibility[0][0]['weightedcount']; ?></div> Merchandize in
                                <span class="statloc"><?php echo $least_visibility[0]['Territory']['territoryname']; ?></span>
                                <div class="clr border-h"></div>
                            <?php endif; ?>
                            <?php if (isset($least_visibility[1])): ?>
                                <div class="statvalue"><?php echo $least_visibility[1][0]['weightedcount']; ?></div> Merchandize in
                                <span class="statloc"><?php echo $least_visibility[1]['Territory']['territoryname']; ?></span>
                                <div class="clr border-h"></div>
                            <?php endif; ?>
                            <?php if (isset($least_visibility[2])): ?>
                                <div class="statvalue"><?php echo $least_visibility[2][0]['weightedcount']; ?></div> Merchandize in
                                <span class="statloc"><?php echo $least_visibility[2]['Territory']['territoryname']; ?></span>
                                <div class="clr"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>



        <div class="row-fluid">

            <div class="span6" style="margin-left: 0px;">
                <h3 class="header smaller lighter green">Product By Subregion</h3>
                <table id="toptenmerchandize" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> S/N </th>
                            <th> Subregions</th>
                            <th> Total Outlets </th>
                            <?php
                                foreach ($product_list as $product) {
                                    echo "<th> {$product} </th>";
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    /*$prodCount = count($product_list);
                    $subregionCount = count($subregion_list);*/

                    if(isset($product_sub_region) && !empty($product_sub_region)) {
                        foreach ($product_sub_region as $ps) {

                            if ($i == 0) {
                                $i++;
                                continue;
                            }

                            echo "<tr>";
                            foreach ($ps as $pmatrix) {
                                echo "<td>{$pmatrix}</td>";
                            }
                            echo "</tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div class="span6">
                <h3 class="header smaller lighter green">Retail Classification By Subregion</h3>
                <table id="toptenmerchandize" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> S/N </th>
                        <th> Subregions</th>
                        <th> Total Outlets </th>
                        <?php
                        foreach ($retailtype_list as $retailtype) {
                            echo "<th> {$retailtype} </th>";
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    /*$prodCount = count($product_list);
                    $subregionCount = count($subregion_list);*/

                    if(isset($retail_class_sub_region) && !empty($retail_class_sub_region)) {
                        foreach ($retail_class_sub_region as $rtsub) {

                            if ($i == 0) {
                                $i++;
                                continue;
                            }

                            echo "<tr>";
                            foreach ($rtsub as $rtmatrix) {
                                echo "<td>{$rtmatrix}</td>";
                            }
                            echo "</tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row-fluid">
            <!--Customer Distribution-->
            <h3 class="header smaller lighter green">Outlet Distribution</h3>
            <div class="span4" style="margin-left: 0px;">
                <div id="outlet_retail" style="min-width: 250px; height: 350px; margin: 0 auto;"></div>
            </div>
            <div class="span4" style="margin-left: 0px;">
                <div id="outlet_product" style="min-width: 250px; height: 350px; margin: 0 auto;"></div>
            </div>
            <div class="span4" style="margin-left: 0px;">
                <div id="outlet_merchandize" style="min-width: 250px; height: 350px; margin: 0 auto;"></div>
            </div>
        </div>

        <!--<div class="row-fluid">
            <h3 class="span12 header smaller lighter green">Outlet Distribution Chart</h3>
            <div id="performance" height="400px" min-width="350px"></div>
        </div>-->
        <div class="row-fluid">
            <div class="row-fluid">
                <div class="span12" style="height: auto">
                    <h3 class="span12 header smaller lighter green">Outlet Growth</h3>
                    <div id="outlet_perfomance" style="min-width: 310px; min-height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <div class="row-fluid" style="height: auto">
                    <h3 class="span12 header smaller lighter green">Recently Captured Images
                        <?php
                        echo $this->Html->link('<i class="icon-list"></i> More', array('controller' => 'images', 'action' => 'index'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                        ?>
                    </h3>
                    <?php

                    for ($i = 0; $i < count($oimages); $i++) {

                        if($i == 0) {
                            echo '<ul class="thumbnails image-list jscroll" id="grouped-image-list">';
                        } elseif(($i % 6) == 0) {
                            echo '</ul><ul class="thumbnails image-list jscroll" id="grouped-image-list">';
                        }

                        ?>

                        <li
                            class="span2"
                            data-animation="true"
                            data-rel="popover"
                            data-html="true"
                            data-trigger="hover"
                            data-placement="top"
                            data-original-title="Image details"
                            data-content="
                                    <?php
                            echo '<strong>Outet Name:</strong> ' .$oimages[$i]['Outlet']['outletname'].'<br />';
                            echo '<strong>Location:</strong> ' .$oimages[$i]['Location']['locationname'].'<br />';
                            echo '<strong>Staff:</strong> ' .ucfirst($oimages[$i][0]['fullname']).'<br />';
                            echo '<strong>Date:</strong> ' .$oimages[$i]['Outletimage']['created_at'].'<br />';
                            ?>"
                            >

                            <a href="<?php echo $this->MyLink->getImageUrlPath($oimages[$i]['Outletimage']['url']); ?>"
                               title="<?php echo $oimages[$i]['Outlet']['outletname'] . ' at ' . $oimages[$i]['Location']['locationname'] . " on " . $oimages[$i]['Outletimage']['created_at'] ?>"
                               class="thumbnail">
                                <!--<a href="<?php // echo $this->base . '/images/index/' . $images[$i]['Image']['id']; ?>" class="thumbnail">-->
                                <!--<img src="http://placehold.it/300x300" alt="">-->
                                <?php // echo $this->Html->image($images[$i]['Image']['filename'], array('width' => '600', 'height' => '450')); ?>
                                <img src="<?php echo $this->MyLink->getImageUrlPath($oimages[$i]['Outletimage']['url']); ?>" alt="">
                            </a>
                        </li>

                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="row-fluid">
                <h3 class="span12 header smaller lighter green">
                    <i class="icon-globe"></i>
                    Maps
                    <?php
                    echo $this->Html->link('<i class="icon-list"></i> More', array('controller' => 'maps', 'action' => 'index'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                    ?>
                </h3>
            </div>
            <div class="row-fluid">
                <div id="gmap">
                    <div id="googleMapContainer"  style="margin-left: 0px"></div>
                </div>
            </div>
            <div class="row-fluid">
                <div id="gmap">
                    <div class="span9" style="margin-left: 0px">
                        <div id="fusionMapContainer"  style="margin-left: 0px"></div>
                        <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
                        However, it seems JavaScript is either disabled or not supported by your browser. 
                        To view Google Maps, enable JavaScript by changing your browser options, and then 
                        try again.
                        </noscript>
                    </div>
                    <div class="span3">

                        <h3 id="statename" class="text-align-center text-success"></h3>

                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <th>Statisitics</th>
                            <th>Values</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong style="font-weight: bolder;">Outlet Count</strong></td>
                                    <td id="outletcount"><?php echo $outlet_count; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-weight: bolder;"><strong>Retail Classification</strong></td>
                                </tr>
                                <?php foreach ($distributions as $distribution) {

                                    echo '<tr>';
                                    echo "<td>{$distribution['Retailtype']['retailtypename']}</td>";
                                    echo "<td>{$distribution[0]['count']}</td>";
                                    echo '</tr>';
                                }
                                ?>
                                <!--<tr>
                                    <td colspan="2" style="font-weight: bolder;"><strong>Element Summary</strong></td>
                                </tr>
                                <tr>
                                    <td>Total Outlet Merchandize</td>
                                    <td id="total_outlet_products">33,434</td>
                                </tr>
                                <tr>
                                    <td>Total Outlet Products</td>
                                    <td id="total_outlet_merchandize">10,534</td>-->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!--/.row-fluid-->
        
        <?php endif; ?>
    </div><!--/.page-content-->

    <?php // echo $this->element('settings');  ?>

</div><!--/.main-content-->