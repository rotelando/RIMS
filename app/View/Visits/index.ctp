<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        
        <?php if(count($visits) == 0): ?>
            
        <div class="page-header position-relative">
                <h1>
                    Visits Management
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Creations & Views
                    </small>
                </h1>
            </div><!--/.page-header-->
            <div class="row">
                <h3 class="text-center text-warning">No visit record available</h3>
            </div>
            
        <?php else: ?>
            
        <div class="page-header position-relative">

            <h1>
                Visits Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    Creations & Views
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

        <?php echo $this->element('visit-page-tab'); ?>
        <!--======================= Visit Accuracy =======================-->
        <div class="row-fluid">
            <!--<h3 class="span12 header smaller lighter green"></h3>-->


            <h3 class="span12 header smaller lighter green" style="margin-bottom: 25px;">Visit Accuracy</h3>
            <div class="span3">
                <div class="visit-accuracy">
                    <div class="border">
                        <a href="visits/all">
                            <span class="visit-value"><?php echo $vaccuracy['actual'] ?></span>
                            <span class="visit-name">Actual Visits</span>
<!--                            <span class="visit-value">24</span>
                            <span class="visit-name">Actual Visits</span>-->
                        </a>
                    </div>
                    <div class="border">
                        <a href="visits/planned">
                            <span class="visit-value"><?php echo $vaccuracy['planned'] ?></span>
                            <span class="visit-name">Planned Visits</span>
<!--                            <span class="visit-value">13</span>
                            <span class="visit-name">Planned Visits</span>-->
                        </a>
                    </div>
                    <div class="border">
                        <span class="visit-value"><?php echo $vaccuracy['target'] ?></span>
                        <span class="visit-name">Target Visits</span>
<!--                        <span class="visit-value">1400</span>
                        <span class="visit-name">Target Visits</span>-->
                    </div>
                </div>
            </div>

            <div class="span8">

                <div class="grid3 center">

                    <div class="actual-plan-chart" data-size="200" data-percent="<?php echo $vaccuracy['actual_vs_planned']; ?>" >
                        <span class="percent"><?php echo $vaccuracy['actual_vs_planned'] . '%'; ?></span>
                    </div>
<!--                    <div class="actual-plan-chart" data-size="200" data-percent="88" >
                        <span class="percent">88%</span>
                    </div>-->

                    <div class="space-2"></div>
                    <span class="visit-label">Actual vs. Plan Visit</span>
                </div>

                <div class="grid3 center">

                    <div class="actual-target-chart" data-size="200" data-percent="<?php echo $vaccuracy['actual_vs_target']; ?>">
                        <span class="percent"><?php echo $vaccuracy['actual_vs_target'] . '%'; ?></span>
                    </div>
<!--                    <div class="actual-target-chart" data-size="200" data-percent="81">
                        <span class="percent">81%</span>
                    </div>-->

                    <div class="space-2"></div>
                    <span class="visit-label">Actual vs. Target Visit</span>

                    <div class="span3 infobox-container" style="margin-top: 30px;">
                        <div class="infobox infobox-green  ">
                            <div class="infobox-icon">
                                <i class="icon-signal"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number"><?php echo $avgTimeSpent; ?></span>
                                <div class="infobox-content">Average Time Spent</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid3 center">
                    <div class="plan-target-chart" data-size="200" data-percent="<?php echo $vaccuracy['planned_vs_target']; ?>">
                        <span class="percent"><?php echo $vaccuracy['planned_vs_target'] . '%'; ?></span>
                    </div>
<!--                    <div class="plan-target-chart" data-size="200" data-percent="90">
                        <span class="percent">90%</span>
                    </div>-->

                    <div class="space-2">Plan vs. Target Visit</div>
                    <span class="visit-label">Plan vs. Target Visit</span>
                </div>

                <div class="space10"></div>



                <div class="hr hr-16"></div>
            </div>
        </div>
        <!--======================= End Visit Accuracy =======================-->

        <!--======================= Visit performance chart =======================-->
        <div class="row-fluid">
            <div class="span12">
                <!--                <h3 class="span12 header smaller lighter green">Visit Performance Chart</h3>
                                <div id="visit_performance_chart" style="min-width: 200px; height: 400px; margin: 0 auto"></div>-->
                <h3 class="span12 header smaller lighter green">Visit Performance Chart</h3>
                <div id="visit_performance_chart_2" style="min-width: 200px; height: 400px; margin: 0 auto"></div>
            </div>
        </div><!--/.row-fluid-->
        <!--======================= End Visit performance chart =======================-->

        <div class="space-20"></div>
        <div class="space-20"></div>
        <div class="space-20"></div>

        <hr />

        <div class="row-fluid">
            <h3 class="span12 header smaller lighter green">Completed Visit <span class="label label-important"> with exception </span>
                <?php
                echo $this->Html->link('<i class="icon-list"></i> View all', array('controller' => 'visits', 'action' => 'all'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                ?>
            </h3>
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="3%"> S/N </th>
                        <th> Outlet Visited</th>
                        <th width="10%"> Location </th>
                        <th width="15%"> Start Time </th>
                        <th width="15%"> Stop Time </th>
                        <th width="5%"> Duration (mins)</th>
                        <th width="5%"> Distance From Outlet (m)</th>                                
                        <th width="10%" style="text-align: center"> Actions </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($visits as $visit):
                        ?>
                        <tr>
                            <td width="5%"> <?php echo ++$i ?> </td>
                            <td><?php
                                $exc_class = '';

                                if (intval($visit['Visit']['distancefromoutlet']) > intval($setting['Setting']['VisitException'])):
                                    $exc_class = '<span class="badge badge-important"><i class="icon-exclamation red-color"></i></span>';
                                endif;
                                ?>

                                <?php
                                echo $this->Html->link($visit['Outlet']['outletname'], array(
                                    'controller' => 'outlets', 'action' => 'view', $visit['Outlet']['id']
                                ));
                                ?> 
                                <?php echo '&nbsp;&nbsp;' . $exc_class; ?>
                            </td>
                            <td> <?php echo $visit['Location']['locationname']; ?>  </td>
                            <td> <?php echo date('Y-m-d H:i:s', $visit['Visit']['starttimestamp']); ?>  </td>
                            <td> <?php echo date('Y-m-d H:i:s', $visit['Visit']['stoptimestamp']); ?> </td>
                            <td> <?php echo intval($visit['Visit']['duration'] / 60); ?> </td>
                            <td>     
                                <?php echo $visit['Visit']['distancefromoutlet']; ?>
                            </td>

                            <td style="text-align: center"> 
                                <?php
                                echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i>', array('controller' => 'visits', 'action' => 'view', $visit['Visit']['id']), array('class' => 'blue', 'escape' => false));
                                ?>

                                <?php
                                echo ' | ' . $this->Html->link(
                                        '<i class="icon-pencil bigger-130"></i>', array('controller' => 'visits', 'action' => 'edit', $visit['Visit']['id']), array('class' => 'green', 'escape' => false));
                                ?> 

                                <?php
                                if (isset($setting['Setting']['DeleteVisit']) && $setting['Setting']['DeleteVisit'] == 'on') {
                                    echo ' | ' . $this->Html->link(
                                            '<i class="icon-trash bigger-130"></i>', array('controller' => 'visits', 'action' => 'delete', $visit['Visit']['id']), array('class' => 'red', 'escape' => false), true);
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php unset($visits); ?>
                </tbody>
            </table>
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

                    for ($i = 0; $i < count($images); $i++) {
                        
                        if($i == 0): 
                    ?>
                    
                            <ul class="thumbnails image-list jscroll" id="grouped-image-list">
                        
                <?php    elseif(($i % 6) == 0): ?>
                            
                            </ul>
                            <ul class="thumbnails image-list jscroll" id="grouped-image-list">
                        
                <?php    endif; ?>
                
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
                                            echo '<strong>Outet Name:</strong> ' .$images[$i]['Outlet']['outletname'].'<br />'; 
                                            echo '<strong>Location:</strong> ' .$images[$i]['Location']['locationname'].'<br />'; 
                                            echo '<strong>Staff:</strong> ' .ucfirst($images[$i][0]['fullname']).'<br />'; 
                                            echo '<strong>Date:</strong> ' .$images[$i]['Image']['createdat'].'<br />'; 
                                        ?>"
                                >
                                    
                                    <a href="<?php echo $this->MyLink->getImageUrlPath($images[$i]['Image']['filename']); ?>" 
                                       title="<?php echo $images[$i]['Outlet']['outletname'] . ' at ' . $images[$i]['Location']['locationname'] . " on " . $images[$i]['Image']['createdat'] ?>" 
                                       class="thumbnail">
                                    <!--<a href="<?php // echo $this->base . '/images/index/' . $images[$i]['Image']['id']; ?>" class="thumbnail">-->
                                        <!--<img src="http://placehold.it/300x300" alt="">-->
                                        <?php // echo $this->Html->image($images[$i]['Image']['filename'], array('width' => '600', 'height' => '450')); ?>
                                        <img src="<?php echo $this->MyLink->getImageUrlPath($images[$i]['Image']['filename']); ?>" alt="">
                                    </a>
                                </li>
                
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row-fluid">

            <div class="span12">
                <div class="row-fluid" style="height: auto">
                    <h3 class="span12 header smaller lighter green">Map - Visits and Unvisited Outlet Distribution
                        <?php
                        echo $this->Html->link('<i class="icon-list"></i> Full View', array('controller' => 'maps', 'action' => 'index'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                        ?>
                    </h3>
                    <div id="visit-map-canvas"  style="height:450px; margin-left: 0px" class="span12"></div>
                    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
                    However, it seems JavaScript is either disabled or not supported by your browser. 
                    To view Google Maps, enable JavaScript by changing your browser options, and then 
                    try again.
                    </noscript>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div><!--/.page-content-->
</div><!--/.main-content-->