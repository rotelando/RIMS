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
                        <div class="stattitle title-d">Retailers per Products</div>
                        <?php
                            $i = 0;
                            foreach ($distributions as $distribution): ?>
                                <div class="statvalue distrib"><?php echo $distribution[0]['count'] ?></div> 
                                    <?php echo $this->Html->link($distribution['Outlettype']['outlettypename'], 
                                            array('action' => 'all', '?' => array('otype' => $distribution['Outlettype']['id']))) ?> 
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
                            <span class="statloc"><?php echo $most_location[0]['Location']['locationname']; ?></span>
                            <div class="clr border-h"></div>
                        <?php endif; ?>
                        <?php if (isset($most_location[1])): ?>
                            <div class="statvalue"><?php echo $most_location[1][0]['count']; ?></div> Outlets in 
                            <span class="statloc"><?php echo $most_location[1]['Location']['locationname']; ?></span>
                            <div class="clr border-h"></div>
                        <?php endif; ?>
                        <?php if (isset($most_location[2])): ?>
                            <div class="statvalue"><?php echo $most_location[2][0]['count']; ?></div> Outlets in 
                            <span class="statloc"><?php echo $most_location[2]['Location']['locationname']; ?></span>
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
                        <span class="statloc"><?php echo $least_location[0]['Location']['locationname']; ?></span>
                        <div class="clr border-l"></div>
                        <?php endif; ?>
                        <?php if (isset($least_location[1])): ?>
                        <div class="statvalue"><?php echo $least_location[1][0]['count']; ?></div> Outlets in 
                        <span class="statloc"><?php echo $least_location[1]['Location']['locationname']; ?></span>
                        <div class="clr border-l"></div>
                        <?php endif; ?>
                        <?php if (isset($least_location[2])): ?>
                        <div class="statvalue"><?php echo $least_location[2][0]['count']; ?></div> Outlets in 
                        <span class="statloc"><?php echo $least_location[2]['Location']['locationname']; ?></span>
                        <div class="clr"></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="row-fluid">
            <h3 class="span12 header smaller lighter green">Outlet Distribution Chart</h3>
            <div id="performance" height="400px" min-width="350px"></div>
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
                                    <td><strong>Outlet Count</strong></td>
                                    <td id="outletcount"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Advocacy Classification</strong></td>
                                </tr>
                                <tr>
                                    <td>Communications</td>
                                    <td id="planned">34,000</td>
                                </tr>
                                <tr>
                                    <td>Visibility</td>
                                    <td id="actual">78,059</td>
                                </tr>
                                <tr>
                                    <td>Availability</td>
                                    <td id="target">46,543</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Channel Classification</strong></td>
                                </tr>
                                <tr>
                                    <td>Trade Partners</td>
                                    <td id="visitperday">546</td>
                                </tr>
                                <tr>
                                    <td>Sub-Trade Partners</td>
                                    <td id="visitperday">123</td>
                                </tr>
                                <tr>
                                    <td>Retailers</td>
                                    <td id="visitperday">98,664</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Retail Classification</strong></td>
                                </tr>
                                <tr>
                                    <td>Pay & Go</td>
                                    <td id="visitperday">33,434</td>
                                </tr>
                                <tr>
                                    <td>Shop and Browse</td>
                                    <td id="visitperday">10,534</td>
                                </tr>
                                <tr>
                                    <td>Entertainment</td>
                                    <td id="visitperday">19,445</td>
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