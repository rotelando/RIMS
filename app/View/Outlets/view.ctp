<div class="main-content">

    <?php echo $this->element('breadcrumb'); ?>
    
    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">

            <h1>
                <?php echo $outlet['Outlet']['outletname']; ?>
                <small>
                    <i class="icon-double-angle-right"></i>
                    <?php echo $outlet['Outlettype']['outlettypename']; ?>
                </small>
            </h1>

        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <?php // echo $this->element('filter_bar'); ?>

        <div class="row-fluid">

            <!--<div class="span12">-->


            <!--PAGE CONTENT BEGINS-->
            <!-- Start Form -->


            <div class="span12">

                <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#details">
                                <i class="green icon-home bigger-110"></i>
                                Details
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#images">
                                <i class="green icon-picture bigger-110"></i>
                                Images
                                <span class="badge badge-important"><?php //echo count($images); ?>1</span>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#prodsourcedistrib">
                                <i class="green icon-share bigger-110"></i>
                                Product Sourcing & Distribution
                                <span class="badge badge-important">7</span>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#visibility">
                                <i class="green icon-bookmark bigger-110"></i>
                                Merchandising
                                <span class="badge badge-important"><?php echo count($merchandising); ?></span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="details" class="tab-pane active">

                            <!--Content of #Details tab-->
                            <div class="span7">

                                <div class="profile-user-info">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Address </div>

                                        <div class="profile-info-value">
                                            <span>
                                                <?php if (isset($outlet['Outlet']['streetnumber'])) echo $outlet['Outlet']['streetnumber'] . ', '; ?> 
                                                <?php if (isset($outlet['Outlet']['streetname'])) echo $outlet['Outlet']['streetname']; ?> 
                                                &nbsp;&nbsp;
                                            </span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Town </div>

                                        <div class="profile-info-value">
                                            <i class="icon-home light-orange bigger-110"></i>
                                            <span><?php echo $outlet['Outlet']['town']; ?>&nbsp;&nbsp; </span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Phone Number </div>

                                        <div class="profile-info-value">
                                            <i class="icon-phone light-orange bigger-110"></i>
                                            <span><?php echo $outlet['Outlet']['phonenumber']; ?>&nbsp;&nbsp; </span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Contact Name </div>

                                        <div class="profile-info-value">
                                            <span><?php echo $outlet['Outlet']['contactfirstname']; ?>
                                                &nbsp;&nbsp;
                                                <!--&nbsp;&nbsp;-->
                                                <?php // echo $this->Html->link('<i class="icon-user"></i>Image', array(),array('escape'=>false,'class'=>'btn btn-inverse btn-minier')); ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Contact Phone Number </div>

                                        <div class="profile-info-value">
                                            <span><?php echo $outlet['Outlet']['contactphonenumber']; ?>&nbsp;&nbsp;<br /><br /></span>
                                        </div>
                                    </div>
                                    
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Advocacy Class </div>

                                        <div class="profile-info-value">
                                            <span><?php 
                                            $channel = array('Communication', 'Visibility', 'Availability');
                                            echo $channel[rand(0,2)];
                                            ?>&nbsp;&nbsp;</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Channel </div>

                                        <div class="profile-info-value">
                                            <span><?php 
                                            $channel = array('Trade Partner', 'Sub-trade Partner', 'Pay & Go (Retailer)', 'Shop and Browse (Retailer)', 'Entertainment (Retailer)');
                                            echo $channel[rand(0,4)];
                                            ?>&nbsp;&nbsp;</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Outlet added by</div>

                                        <div class="profile-info-value">
                                            <i class="icon-user light-orange bigger-110"></i>
                                            <span>
                                                <?php echo $outlet['User']['firstname'] . ' ' . $outlet['User']['lastname']; 
                                                ?>&nbsp;&nbsp;
                                            </span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Date Created </div>

                                        <div class="profile-info-value">
                                            <span> <?php
                                                if (isset($outlet['Outlet']['createdat']))
                                                    echo $outlet['Outlet']['createdat'];
                                                else
                                                    echo "NA";
                                                ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-8 dotted"></div>
                            </div>
                            <div class="span4">

                                <!--<h3 class="span11 header smaller lighter green">Map Location</h3>-->


                                <?php
                                $arr_geo = $this->TextFormater->latLongFormatter($outlet['Outlet']['geolocation']);
                                $lat = $arr_geo[0];
                                $lon = $arr_geo[1];
                                ?>

                                <img src="http://maps.googleapis.com/maps/api/staticmap?center=
                                     <?php echo $lon; ?>,<?php echo $lat; ?>&zoom=14&size=350x350                        
                                     &markers=color:red%7Clabel:O%7C<?php echo $lon; ?>,<?php echo $lat; ?>
                                     &sensor=false" />
                            </div><!--/.span-->
                            <!--<a data-toggle="modal" href="#signin">Sign In</a>-->

                        </div>
                        <!--End the content of #Details tab-->

                        <!--The content of #Images tab-->
                        <div id="images" class="tab-pane">

                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="span12">

                                        <div class="span3">
                                            <img src="/assets/images/outlet_3.jpg" />
                                        </div>
                                        <!-- <h3 class="span12 header smaller lighter green">Images</h3> -->
                                        
                                        <?php //if (count($images) != 0): ?>
                                        <?php

                                                // for ($i = 0; $i < count($images); $i++) {

                                                //     if($i == 0): 
                                                ?>

                                                        <!-- <ul class="thumbnails image-list jscroll" id="grouped-image-list"> -->

                                            <?php //elseif(($i % 6) == 0): ?>

                                                        <!-- </ul>
                                                        <ul class="thumbnails image-list jscroll" id="grouped-image-list"> -->

                                            <?php //endif; ?>

                                                            <!-- <li 
                                                                class="span2"
                                                                data-animation="true" 
                                                                data-rel="popover"
                                                                data-html="true"
                                                                data-trigger="hover" 
                                                                data-placement="top"  
                                                                data-original-title="Image details"
                                                                data-content="
                                                                    <?php 
                                                                        // echo '<strong>Outet Name:</strong> ' .$images[$i]['Outlet']['outletname'].'<br />'; 
                                                                        // echo '<strong>Location:</strong> ' .$images[$i]['Location']['locationname'].'<br />'; 
                                                                        // echo '<strong>Staff:</strong> ' .ucfirst($images[$i][0]['fullname']).'<br />'; 
                                                                        // echo '<strong>Date:</strong> ' .$images[$i]['Image']['createdat'].'<br />'; 
                                                                    ?>"
                                                            > -->
<!-- 
                                                                <a href="<?php //echo $this->MyLink->getImageUrlPath($images[$i]['Image']['filename']); ?>" 
                                                                    title="<?php //echo $images[$i]['Outlet']['outletname'] . ' at ' . $images[$i]['Location']['locationname'] . " on " . $images[$i]['Image']['createdat'] ?>" 
                                                                    class="thumbnail">
                                                                    <img src="<?php //echo $this->MyLink->getImageUrlPath($images[$i]['Image']['filename']); ?>" width="600" height="450" alt="">
                                                                </a>
                                                            </li> -->

                                                <?php //} ?>
                                                <!-- </ul> -->
                                                <?php //else: ?>
                                                    <!-- <p>No images taken for this outlet.</p> -->
                                                <?php //endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End the content of #Imagess tab-->

                        <!--End the content of #Product Sourcing tab-->
                        <div id="prodsourcedistrib" class="tab-pane">
                            <div class="span4">
                            <h3 class="span12 header smaller lighter green"> Product Sourcing</h3>
                            
                            
                                <table id="tbl-merch" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="10%"> S/N </th>
                                            <th> Source </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th> 1 </th>
                                            <th> Benson Ventures </th>
                                        </tr>
                                        <tr>
                                            <th> 2 </th>
                                            <th> Toyosi Business Center </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="span4 offset1">
                            <h3 class="span12 header smaller lighter green"> Product Distribution</h3>
                                <table id="tbl-merch" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="10%"> S/N </th>
                                            <th> Distributions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th> 1 </th>
                                            <th> Chuks Communication Limited </th>
                                        </tr>
                                        <tr>
                                            <th> 2 </th>
                                            <th> Damilare Communications </th>
                                        </tr>
                                        <tr>
                                            <th> 3 </th>
                                            <th> Mba Recharge Center </th>
                                        </tr>
                                        <tr>
                                            <th> 4 </th>
                                            <th> God's Favour Ventures </th>
                                        </tr>
                                        <tr>
                                            <th> 5 </th>
                                            <th> Best Brains Cyber Cafe </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <?php //if (isset($prodsources) && count($prodsources) != 0): ?>
                                <!-- <table id="sample-table-1" class="table table-striped table-bordered table-hover" style="margin-left: 0px;">
                                </table> -->
                            <?php ///else: ?>
                                <!-- <p>No Product Sourcing and Distribution details available for this outlet.</p> -->
                            <?php //endif; ?>
                            
                        </div>
                        <!--End the content of #Product Sourcing tab-->

                        <!--End the content of #Visibility tab-->
                        <div id="visibility" class="tab-pane">
                            <div class="span12">

                            <h3 class="span12 header smaller lighter green"> Merchandise Elements Counts 
                            <a href="#mer-dialog" class="btn btn-mini btn-primary pull-right" id="add-merch" data-toggle="modal" class="green addBtn">Add</a>
                            </h3>
                            <div class="clearfix"></div>

                            <?php if (isset($merchandising) && count($merchandising) != 0): ?>
                            <div id="merch-not">
                            </div>

                            
                                <table id="tbl-merch" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="3%"> S/N </th>
                                            <th width="20%"> Brand </th>
                                            <th> Merchandise Element </th>
                                            <th width="20%"> Element Count </th>                                
                                            <th width="20%" style="text-align: center"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($merchandising as $visibilityevaluation):
                                            ?>
                                            <tr data-id="<?php echo $visibilityevaluation['Visibilityevaluation']['id']; ?>">
                                                <td width="5%"> <?php echo ++$i ?> </td>
                                                <td> <?php echo $visibilityevaluation['Brand']['brandname']; ?> </td>
                                                <td> <?php echo $visibilityevaluation['Brandelement']['brandelementname']; ?> </td>
                                                <td> <?php echo $visibilityevaluation['Visibilityevaluation']['elementcount']; ?> </td>
                                                <td style="text-align: center">
                                                    <div class="hidden-phone visible-desktop action-buttons">
                                                        <?php
                                                            echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i>', array('controller' => 'visits', 'action' => 'view', $visibilityevaluation['Visibilityevaluation']['visitid']), array('class' => 'blue', 'escape' => false, "data-rel" => "tooltip",  "data-placement" => "top", "data-original-title" => "Visit Details"));
                                                        ?> | 
                                                        <a href="#mer-dialog" data-id="<?php echo $visibilityevaluation['Visibilityevaluation']['id']; ?>" data-toggle="modal" class="green edit-merch"><i class="icon-pencil bigger-130"></i></a> | 
                                                        <a href="#mer-dialog-del" data-id="<?php echo $visibilityevaluation['Visibilityevaluation']['id']; ?>" data-toggle="modal" class="red mer-delete" data-rel="tooltip" data-placement="top" data-original-title="Delete"><i class="icon-trash bigger-130"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            <?php else: ?>
                                <!-- No table-bordered. It will be added using js -->
                                <div id="merch-not">
                                    <p>No Merchandise counts taken for this outlet.</p>
                                </div>
                                
                                <table id="tbl-merch" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="3%"> S/N </th>
                                            <th width="20%"> Brand </th>
                                            <th> Visibility Element </th>
                                            <th width="20%"> Element Count </th>                                
                                            <th width="20%" style="text-align: center"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                
                            <?php endif; ?>
                            </div>
                        </div>
                        <!--End the content of #Visibility tab-->

                    </div>
                </div>
                <!--PAGE CONTENT ENDS-->
            </div>

            <!--</div>-->
            <!--PAGE CONTENT BEGINS-->

        </div>
        <!--PAGE CONTENT ENDS-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
</div><!--/.main-content-->


<div id="mer-dialog-del" class="modal hide fade" style="width: 400px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"> Delete</h3>
    </div>
    <!-- Start Modal Body -->
    <div class="modal-body">
        <input type="hidden" name="del-id" id="del-id" />
        <p>
            Are you sure you want to delete?
        </p>
    </div>

    <div class="modal-footer">
        <a href="#" class="btn btn-success" id="delBtn"> Delete </a>
        <a href="#" data-dismiss="modal" class="btn btn-danger pull-left cancelBtn"> Cancel </a>
    </div>
</div>

<div id="mer-dialog" class="modal hide fade" style="width: 400px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"> Edit Visibility Evaluation Details </h3>
    </div>
    <!-- Start Modal Body -->
    <div class="modal-body">
        <input type="hidden" name="id" id="id" />

        <label>Visit</label>
        <input name="visitid" require="1" placeholder="Visit Id" class="span4" type="text" id="visitid"
        value="<?php if(isset($merchandising[0]['Visibilityevaluation']['visitid'])) echo $merchandising[0]['Visibilityevaluation']['visitid']; ?>"
        >

        <br />
        <label>Brand</label>
        <select name="brandid" id="brands" class="span4">
            <option value="">MTN</option>
        </select>

        <br />
        <label>Visibility Element</label>
        <select name="brandelementid" id="brandelements" class="span4">
            <option value="">Umbrella</option>
        </select>

        <br />
        <label>Element Count</label>
        <input name="element_count" require="1" placeholder="Element Count" class="span4" type="text" id="element_count">
    </div>  
    <!-- End Modal Body -->

    <div class="modal-footer">
        <a href="#" class="btn btn-success saveBtn"> Save </a>
        <a href="#" data-dismiss="modal" class="btn btn-danger pull-left cancelBtn"> Cancel </a>
    </div>
</div>

<!-- Start Product availability dialog box -->
<div id="pa-dialog" class="modal hide fade" style="width: 400px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Edit Product Availability</h3>
    </div>
    <!-- Start Modal Body -->
    <div class="modal-body">
        <input type="hidden" name="pa-id" id="pa-id" />

        <label>Visit ID</label>
        <input name="pa-visitid" require="1" placeholder="Visit" class="span4" type="text" id="pa-visits"
        value="<?php if(isset($prodavail[0]['Productavailability']['visitid'])) echo $prodavail[0]['Productavailability']['visitid']; ?>"
        >

        <br />
        <label>Brand</label>
        <select name="pa-brands" id="pa-brands" class="span4">            
        </select>

        <br />
        <label>Product</label>
        <select name="pa-product" id="pa-product" class="span4">
        </select>

        <br />
        <label>Quantity</label>
        <input name="pa-quantity" require="1" placeholder="Quantity" class="span4" type="text" id="pa-quantity">

        <br />
        <label>Unit Price</label>
        <input name="pa-unitprice" require="1" placeholder="Unit Price" class="span4" type="text" id="pa-unitprice">

        <br />
        <label>Purchase Point</label>
        <input name="pa-purchase-point" require="1" placeholder="Purchase Point" class="span4" type="text" id="pa-purchase-point">
    </div>  

    <div class="modal-footer">
        <a href="#" class="btn btn-success pa-saveBtn"> Save </a>
        <a href="#" data-dismiss="modal" class="btn btn-danger pull-left pa-cancelBtn"> Cancel </a>
    </div>
    <!-- End Modal Body -->
</div>

<?php echo $this->Html->script('/assets/bootstrap/bootstrap-modal'); ?>