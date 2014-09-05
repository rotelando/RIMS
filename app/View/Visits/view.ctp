<div class="main-content">

    <?php // echo $this->element('breadcrumb'); ?>

    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">

            <h1>
                <?php
                    echo $this->Html->link($visit['Outlet']['outletname'], array('controller' => 'outlets', 'action' => 'view', $visit['Outlet']['id']));
                ?>
                <small>
                    <i class="icon-double-angle-right"></i>
                    Visit Start time [ <span style="color: black"><?php echo date('Y-m-d H:i:s', $visit['Visit']['starttimestamp']); ?></span> ]
                </small>
            </h1>

        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <?php // echo $this->element('filter_bar'); ?>



        <div class="row-fluid" style="height: auto;">
            <div class="span6">
                <h3 class="span12 header smaller lighter green" style="margin-left: 0px;"> Merchandising
                    <?php
                    echo $this->Html->link('<i class="icon-list"></i> View all', array('controller' => 'visibilityevaluations', 'action' => 'all'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                    ?>
                </h3>
                <?php if (count($visibilityevaluations) != 0): ?>
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="3%"> S/N </th>
                                <th> Brand Name </th>
                                <th width="13%"> Visibility Element </th>
                                <th width="13%"> Element Count </th>                                
                                <th width="20%" style="text-align: center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($visibilityevaluations as $visibilityevaluation):
                                ?>
                                <tr>
                                    <td width="5%"> <?php echo++$i ?> </td>
                                    <td> <?php
                        echo $this->Html->link($visibilityevaluation['Brand']['brandname'], array(
                            'controller' => 'brands', 'action' => 'index'
                        ));
                                ?>  </td>
                                    <td> <?php echo $visibilityevaluation['Brandelement']['brandelementname']; ?> </td>
                                    <td> <?php echo $visibilityevaluation['Visibilityevaluation']['elementcount']; ?> </td>
                                    <td style="text-align: center">
                                        <div class="hidden-phone visible-desktop action-buttons">
                                            <?php
//                                        echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> View', array('controller' => 'orders', 'action' => 'view', $order['Order']['id']), array('class' => 'blue', 'escape' => false));
                                            ?>

                                            <?php
//                                        echo ' | ' . $this->Html->link(
//                                                '<i class="icon-pencil bigger-130"></i> Edit', array('controller' => 'orders', 'action' => 'edit', $order['Order']['id']), array('class' => 'green', 'escape' => false));
                                            ?> 

                                            <?php
                                            if (isset($setting['Setting']['DeleteVisit']) && $setting['Setting']['DeleteVisit'] == 'on') {
                                                echo
//                                            ' | ' . 
                                                $this->Html->link(
                                                        '<i class="icon-trash bigger-130"></i> Delete', array('controller' => 'orders', 'action' => 'delete', $visibilityevaluation['Visibilityevaluation']['id']), array('class' => 'red', 'escape' => false), true);
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No Visibility Evaluation taken for this visit.</p>
                <?php endif; ?>
            </div>
            <div class="span6">
                <h3 class="span12 header smaller lighter green">Images
                    <?php
                    echo $this->Html->link('<i class="icon-list"></i> View all', array('controller' => 'images', 'action' => 'index'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                    ?>
                </h3>
                
                <?php

                if(count($images) != 0) {
                    for ($i = 0; $i < count($images); $i++) {
                        
                        if($i == 0): 
                    ?>
                    
                            <ul class="thumbnails image-list jscroll" id="grouped-image-list">
                        
                <?php    elseif(($i % 4) == 0): ?>
                            
                            </ul>
                            <ul class="thumbnails image-list jscroll" id="grouped-image-list">
                        
                <?php    endif; ?>
                
                                <li 
                                    class="span3"
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
                                        <img src="<?php echo $this->MyLink->getImageUrlPath($images[$i]['Image']['filename']); ?>" width="600" height="450" alt="">
                                    </a>
                                </li>
                
                    <?php
                        }
                    ?>
                    </ul>
                    <?php
                        } else {
                    ?>
                        No image taken during this visit.
                    <?php
                        }
                    ?>
            </div>
        </div>
        <div class="row-fluid">

        </div>
        <div class="row-fluid">
            <h3 class="span12 header smaller lighter green">Sales
                <?php
                echo $this->Html->link('<i class="icon-list"></i> View all', array('controller' => 'orders', 'action' => 'all'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                ?>
            </h3>
            <?php if (count($orders) != 0): ?>
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
                                <td width="5%"> <?php echo++$i ?> </td>
                                <td> <?php
                    echo $this->Html->link($order['Outlet']['outletname'], array(
                        'controller' => 'outlets', 'action' => 'view', $order['Outlet']['id']
                    ));
                            ?>  </td>
                                <td> <?php echo $order['Product']['productname']; ?> </td>
                                <td> <?php echo $order['Order']['quantity']; ?> </td>
                                <td> <?php echo $order['Order']['discount']; ?> </td>
                                <td> <?php echo $order['Orderstatus']['orderstatusname']; ?>
                                </td>
                                <td style="text-align: center">
                                    <div class="hidden-phone visible-desktop action-buttons">
                                        <?php
                                        echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> View', array('controller' => 'orders', 'action' => 'view', $order['Order']['id']), array('class' => 'blue', 'escape' => false));
                                        ?>

                                        <?php
                                        echo ' | ' . $this->Html->link(
                                                '<i class="icon-pencil bigger-130"></i> Edit', array('controller' => 'orders', 'action' => 'edit', $order['Order']['id']), array('class' => 'green', 'escape' => false));
                                        ?> 

                                        <?php
                                        if (isset($setting['Setting']['DeleteVisit']) && $setting['Setting']['DeleteVisit'] == 'on') {
                                            echo ' | ' . $this->Html->link(
                                                    '<i class="icon-trash bigger-130"></i> Delete', array('controller' => 'orders', 'action' => 'delete', $order['Order']['id']), array('class' => 'red', 'escape' => false), true);
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            <?php else: ?>
                <p>No Order taken for this visit.</p>
            <?php endif; ?>
        </div>
        <div class="row-fluid">
            <h3 class="span12 header smaller lighter green">Product Availability
                <?php
                echo $this->Html->link('<i class="icon-list"></i> View all', array('controller' => 'productavailabilities', 'action' => 'all'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                ?>
            </h3>
            <?php if (count($productavailabilities) != 0): ?>
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="3%"> S/N </th>
                            <th> Product Name </th>
                            <th width="13%"> Quantity Available </th>
                            <th width="13%"> Unit Price (N) </th>                                
                            <th width="13%"> Purchase Point </th>                                
                            <th width="10%" style="text-align: center"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($productavailabilities as $productavailability):
                            ?>
                            <tr>
                                <td width="5%"> <?php echo++$i ?> </td>
                                <td> <?php
                    echo $this->Html->link($productavailability['Product']['productname'], array(
                        'controller' => 'products', 'action' => 'index'
                    ));
                            ?>  </td>
                                <td> <?php echo $productavailability['Productavailability']['quantityavailable']; ?> </td>
                                <td> <?php echo $productavailability['Productavailability']['unitprice']; ?> </td>
                                <td> <?php echo $productavailability['Productavailability']['purchasepoint']; ?> </td>
                                <td style="text-align: center">
                                    <div class="hidden-phone visible-desktop action-buttons">
                                        <?php
//                                        echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i> View', array('controller' => 'orders', 'action' => 'view', $order['Order']['id']), array('class' => 'blue', 'escape' => false));
                                        ?>

                                        <?php
//                                        echo ' | ' . $this->Html->link(
//                                                '<i class="icon-pencil bigger-130"></i> Edit', array('controller' => 'orders', 'action' => 'edit', $order['Order']['id']), array('class' => 'green', 'escape' => false));
                                        ?> 

                                        <?php
                                        if (isset($setting['Setting']['DeleteVisit']) && $setting['Setting']['DeleteVisit'] == 'on') {
                                            echo
//                                            ' | ' . 
                                            $this->Html->link(
                                                    '<i class="icon-trash bigger-130"></i> Delete', array('controller' => 'orders', 'action' => 'delete', $productavailability['Productavailability']['id']), array('class' => 'red', 'escape' => false), true);
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            <?php else: ?>
                <p>No Product availability data taken for this visit.</p>
            <?php endif; ?>
        </div>
        <div class="row-fluid">
            <h3 class="span12 header smaller lighter green">Additional Information</h3>
            <div class="span6">
                <div class="widget-box transparent" id="recent-box">
                    <div class="widget-header">
                        <h4 class="lighter smaller">
                            <i class="icon-rss orange"></i>
                            Notes
                        </h4>
                    </div>



                    <div class="widget-body">
                        <div class="widget-main padding-4">
                            <div class="tab-content padding-8 overflow-visible">

                                <div id="comment-tab" class="tab-pane active">
                                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="comments" style="overflow: hidden; width: auto; height: 300px;">

                                            <?php if (count($notes) != 0): ?>
                                                <?php
                                                $i = 0;
                                                foreach ($notes as $note):
                                                    ?>
                                                    <div class="itemdiv commentdiv">
                                                        <i class="icon-book icon-4x green pull-left"></i>
                                                        <div class="body">
                                                            <div class="name">
                                                                <a href="#">Note <?php echo ++$i; ?></a>
                                                            </div>*

                                                            <div class="time">
                                                                <i class="icon-time"></i>
                                                                <span class="orange"><?php echo $note['Note']['createdat'] ?></span>
                                                            </div>

                                                            <div class="text">
                                                                <i class="icon-quote-left"></i>
                                                                <?php echo $note['Note']['note'] ?>
                                                            </div>
                                                        </div>

                                                        <div class="tools">
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-only icon-pencil"></i>', array('controller' => 'notes', 'action' => 'delete', $note['Note']['id']), array('class' => 'btn btn-minier btn-info', 'escape' => false), true);
                                                            ?>
                                                            <?php
                                                            echo $this->Html->link(
                                                                    '<i class="icon-only icon-trash"></i>', array('controller' => 'notes', 'action' => 'delete', $note['Note']['id']), array('class' => 'btn btn-minier btn-danger', 'escape' => false), true);
                                                            ?>
                                                        </div>
                                                    </div>

                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p>No Note was taken for this visit.</p>
                                            <?php endif; ?>
                                        </div><div class="slimScrollBar ui-draggable" style="background-color: rgb(0, 0, 0); width: 7px; position: absolute; top: 22px; opacity: 0.4; display: block; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; z-index: 99; right: 1px; height: 277.77777777777777px; background-position: initial initial; background-repeat: initial initial;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; background-color: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px; background-position: initial initial; background-repeat: initial initial;"></div></div>

                                    <div class="hr hr8"></div>

                                    <div class="center">
                                        <i class="icon-comments-alt icon-2x green"></i>

                                        &nbsp;
                                        <a href="#">
                                            See all notes &nbsp;
                                            <i class="icon-arrow-right"></i>
                                        </a>
                                    </div>

                                    <div class="hr hr-double hr8"></div>
                                </div>
                            </div>
                        </div><!--/widget-main-->
                    </div><!--/widget-body-->



                </div><!--/widget-box-->
            </div>
        </div>
        <!--PAGE CONTENT ENDS-->

    </div><!--/.page-content-->
</div><!--/.main-content-->
