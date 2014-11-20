<div class="main-content">

    <?php /*echo $this->element('breadcrumb'); */?>
    
    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">

            <h1>
                <?php echo $outlet['Outlet']['outletname']; ?>
                <small>
                    <i class="icon-double-angle-right"></i>
                    <?php echo $outlet['Retailtype']['retailtypename']; ?>
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
                            <a data-toggle="tab" href="#oimages">
                                <i class="green icon-picture bigger-110"></i>
                                Images
                                <span class="badge badge-important"><?php echo count($outletimages); ?></span>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#oproducts">
                                <i class="green icon-bookmark bigger-110"></i>
                                Products
                                <span class="badge badge-important"><?php echo count($outletproducts); ?></span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#omerchandize">
                                <i class="green icon-bookmark bigger-110"></i>
                                Merchandize
                                <span class="badge badge-important"><?php echo count($outletmerchandize); ?></span>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#oprodsourcedistrib">
                                <i class="green icon-share bigger-110"></i>
                                Product Sourcing
                                <span class="badge badge-important"><?php echo count($productsources); ?></span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="details" class="tab-pane active">

                            <h3 class="span12 header smaller lighter green"> Basic Information.
                                <a href="#outlet-dialog" class="btn btn-mini btn-primary pull-right" id="edit-outlet" data-toggle="modal" class="green addBtn">Edit</a>
                            </h3>

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
                                        <div class="profile-info-name"> Phone Number </div>

                                        <div class="profile-info-value">
                                            <i class="icon-phone light-orange bigger-110"></i>
                                            <span><?php echo $outlet['Outlet']['contactphonenumber']; ?>&nbsp;&nbsp;<br /><br /></span>
                                            <!--<span><?php /*echo $outlet['Outlet']['phonenumber']; */?>&nbsp;&nbsp; </span>-->
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name">Alternate Number </div>

                                        <div class="profile-info-value">
                                            <i class="icon-phone light-orange bigger-110"></i>
                                            <span><?php echo $outlet['Outlet']['contactalternatenumber']; ?>&nbsp;&nbsp;<br /><br /></span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <i class="icon-phone light-orange bigger-110"></i>
                                        <div class="profile-info-name"> VTU Number </div>

                                        <div class="profile-info-value">
                                            <span><?php echo $outlet['Outlet']['vtunumber']; ?>&nbsp;&nbsp;<br /><br /></span>
                                        </div>
                                    </div>
                                    
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Advocacy Class </div>

                                        <div class="profile-info-value">
                                            <span><?php echo $outlet['Outletclass']['outletclassname']; ?>&nbsp;&nbsp;</span>
                                        </div>
                                    </div>

                                    <!--<div class="profile-info-row">
                                        <div class="profile-info-name"> Channel </div>

                                        <div class="profile-info-value">
                                            <span><?php /*echo $outlet['Outletchannel']['outletchannelname']; */?>&nbsp;&nbsp;</span>
                                        </div>
                                    </div>-->

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Retailtype </div>

                                        <div class="profile-info-value">
                                            <span><?php echo $outlet['Retailtype']['retailtypename']; ?>&nbsp;&nbsp;</span>
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
                                                if (isset($outlet['Outlet']['created_at']))
                                                    echo $outlet['Outlet']['created_at'];
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
                                $lon = $arr_geo[0];
                                $lat = $arr_geo[1];
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
                        <div id="oimages" class="tab-pane">

                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="span12">

                                        <!--<div class="span3">
                                            <img src="/assets/images/outlet_3.jpg" />
                                        </div>-->
                                         <h3 class="span12 header smaller lighter green">Images</h3>
                                        
                                        <?php if (count($outletimages) != 0): ?>
                                        <?php

                                                 for ($i = 0; $i < count($outletimages); $i++) {

                                                     if($i == 0):
                                                ?>

                                                         <ul class="thumbnails image-list jscroll" id="grouped-image-list">

                                            <?php elseif(($i % 6) == 0): ?>

                                                         </ul>
                                                        <ul class="thumbnails image-list jscroll" id="grouped-image-list">

                                            <?php endif; ?>

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
                                                                         echo '<strong>Outet Name:</strong> ' .$outletimages[$i]['Outlet']['outletname'].'<br />';
                                                                         echo '<strong>Location:</strong> ' .$outletimages[$i]['Location']['locationname'].'<br />';
                                                                         echo '<strong>Staff:</strong> ' .ucfirst($outletimages[$i][0]['fullname']).'<br />';
                                                                         echo '<strong>Date:</strong> ' .$outletimages[$i]['Outletimage']['created_at'].'<br />';
                                                                    ?>"
                                                            >

                                                                <a href="<?php echo $this->MyLink->getImageUrlPath($outletimages[$i]['Outletimage']['url']); ?>"
                                                                    title="<?php echo $outletimages[$i]['Outlet']['outletname'] . ' at ' . $outletimages[$i]['Location']['locationname'] . " on " . $outletimages[$i]['Outletimage']['created_at'] ?>"
                                                                    class="thumbnail">
                                                                    <img src="<?php echo $this->MyLink->getImageUrlPath($outletimages[$i]['Outletimage']['url']); ?>" width="600" height="450" alt="">
                                                                </a>
                                                            </li>

                                                <?php } ?>
                                                 </ul>
                                                <?php else: ?>
                                                     <p>No images taken for this outlet.</p>
                                                <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End the content of #Imagess tab-->

                        <!--End the content of #Visibility tab-->
                        <div id="oproducts" class="tab-pane">
                            <div class="span12">

                            <h3 class="span12 header smaller lighter green"> Products
                            <a href="#prod-dialog" class="btn btn-mini btn-primary pull-right green addBtn" id="add-prod" data-toggle="modal">Add</a>
                            </h3>
                            <div class="clearfix"></div>

                            <?php if (isset($outletproducts) && count($outletproducts) != 0): ?>
                            <div id="merch-not">
                            </div>

                            
                                <table id="tbl-merch" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="3%"> S/N </th>
                                            <th width="20%"> Brand </th>
                                            <th> Product </th>
                                            <th width="20%"> Date Created </th>
                                            <th width="20%" style="text-align: center"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($outletproducts as $outletproduct):
                                            ?>
                                            <tr data-id="<?php echo $outletproduct['Outletproduct']['id']; ?>">
                                                <td width="5%"> <?php echo ++$i ?> </td>
                                                <td> <?php echo $outletproduct['Brand']['brandname']; ?> </td>
                                                <td> <?php echo $outletproduct['Product']['productname']; ?> </td>
                                                <td> <?php echo $outletproduct['Outletproduct']['created_at']; ?> </td>
                                                <td style="text-align: center">
                                                    <div class="hidden-phone visible-desktop action-buttons">
                                                        <?php
                                                            //echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i>', array('controller' => 'products', 'action' => 'view', $outletproduct['Product']['id']), array('class' => 'blue', 'escape' => false, "data-rel" => "tooltip",  "data-placement" => "top", "data-original-title" => "Visit Details"));
                                                        ?><!-- | -->
                                                        <a href="#mer-dialog" data-id="<?php echo $outletproduct['Outletproduct']['id']; ?>" data-toggle="modal" class="green edit-merch"><i class="icon-pencil bigger-130"></i></a> |
                                                        <a href="#mer-dialog-del" data-id="<?php echo $outletproduct['Outletproduct']['id']; ?>" data-toggle="modal" class="red mer-delete" data-rel="tooltip" data-placement="top" data-original-title="Delete"><i class="icon-trash bigger-130"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            <?php else: ?>
                                <!-- No table-bordered. It will be added using js -->
                                <div id="prod-not">
                                    <p>No product counts taken for this outlet.</p>
                                </div>
                                
                                <!--<table id="tbl-merch" class="table table-striped table-bordered table-hover">
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
                                </table>-->
                                
                            <?php endif; ?>
                            </div>
                        </div>
                        <!--End the content of #Visibility tab-->


                        <div id="omerchandize" class="tab-pane">
                            <div class="span12">

                            <h3 class="span12 header smaller lighter green"> Merchandise Elements Counts
                            <a href="#mer-dialog" class="btn btn-mini btn-primary pull-right green addBtn" id="add-merch" data-toggle="modal">Add</a>
                            </h3>
                            <div class="clearfix"></div>

                            <?php if (isset($outletmerchandize) && count($outletmerchandize) != 0): ?>
                            <div id="omerch-not"></div>


                                <table id="tbl-merch" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="3%"> S/N </th>
                                            <th width="20%"> Brand </th>
                                            <th> Merchandize Element </th>
                                            <th width="10%"> Element Count </th>
                                            <th width="10%"> Appropriately Deployed </th>
                                            <th width="20%" style="text-align: center"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($outletmerchandize as $merchandize):
                                            ?>
                                            <tr data-id="<?php echo $merchandize['Outletmerchandize']['id']; ?>">
                                                <td width="5%"> <?php echo ++$i ?> </td>
                                                <td> <?php echo $merchandize['Brand']['brandname']; ?> </td>
                                                <td> <?php echo $merchandize['Merchandize']['name']; ?> </td>
                                                <td> <?php echo $merchandize['Outletmerchandize']['elementcount']; ?> </td>
                                                <td> <?php echo $merchandize['Outletmerchandize']['appropriatelydeployed']; ?> </td>
                                                <td style="text-align: center">
                                                    <div class="hidden-phone visible-desktop action-buttons">
                                                        <?php
                                                            //echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i>', array('controller' => 'merchandize', 'action' => 'view', $merchandize['merchandize']['id']), array('class' => 'blue', 'escape' => false, "data-rel" => "tooltip",  "data-placement" => "top", "data-original-title" => "Visit Details"));
                                                        ?> <!--|-->
                                                        <a href="#mer-dialog" data-id="<?php echo $merchandize['Outletmerchandize']['id']; ?>" data-toggle="modal" class="green edit-merch"><i class="icon-pencil bigger-130"></i></a> |
                                                        <a href="#dialog-del" data-id="<?php echo $merchandize['Outletmerchandize']['id']; ?>" data-toggle="modal" class="red mer-delete" data-rel="tooltip" data-placement="top" data-original-title="Delete"><i class="icon-trash bigger-130"></i></a>
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

                                <!--<table id="tbl-merch" class="table table-striped table-bordered table-hover">
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
                                </table>-->

                            <?php endif; ?>
                            </div>
                        </div>
                        <!--End the content of #Visibility tab-->

                        <!--End the content of #Product Sourcing tab-->
                        <div id="oprodsourcedistrib" class="tab-pane">
                            <div class="span12">
                                <h3 class="span12 header smaller lighter green"> Product Sourcing</h3>

                            <?php if (isset($productsources) && count($productsources) != 0): ?>

                                <table id="tbl-merch" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th width="3%"> S/N </th>
                                        <th width="20%"> Source Name </th>
                                        <th> Phone Number  </th>
                                        <th width="10%"> Alternate Number  </th>
                                        <th width="20%" style="text-align: center"> Actions </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($productsources as $productsource):
                                        ?>
                                        <tr data-id="<?php echo $productsource['Productsource']['id']; ?>">
                                            <td width="5%"> <?php echo ++$i ?> </td>
                                            <td> <?php echo $productsource['Productsource']['productsourcename']; ?> </td>
                                            <td> <?php echo $productsource['Productsource']['phonenumber']; ?> </td>
                                            <td> <?php echo $productsource['Productsource']['alternatenumber']; ?> </td>
                                            <td style="text-align: center">
                                                <div class="hidden-phone visible-desktop action-buttons">
                                                    <?php
                                                    //echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i>', array('controller' => 'merchandize', 'action' => 'view', $merchandize['merchandize']['id']), array('class' => 'blue', 'escape' => false, "data-rel" => "tooltip",  "data-placement" => "top", "data-original-title" => "Visit Details"));
                                                    ?> <!--|-->
                                                    <a href="#mer-dialog" data-id="<?php echo $productsource['Productsource']['id']; ?>" data-toggle="modal" class="green edit-merch"><i class="icon-pencil bigger-130"></i></a> |
                                                    <a href="#mer-dialog-del" data-id="<?php echo $productsource['Productsource']['id']; ?>" data-toggle="modal" class="red mer-delete" data-rel="tooltip" data-placement="top" data-original-title="Delete"><i class="icon-trash bigger-130"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    </tbody>
                                </table>
                            <?php else: ?>
                                <!-- No table-bordered. It will be added using js -->
                                <div id="prods-not">
                                    <p>No Product Source not taken for this outlet.</p>
                                </div>

                            <?php endif; ?>

                        </div>
                        <!--End the content of #Product Sourcing tab-->

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


<div id="dialog-del" class="modal hide fade" style="width: 400px; margin-left: -125px;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<?php echo $this->element('_outlet_dialog', array('outlet' => $outlet)); ?>

<?php echo $this->element('_outletmerchandize_dialog', array('outletmerchandize' => $outletmerchandize)); ?>

<?php echo $this->element('_outletproduct_dialog', array('outletmerchandize' => $outletmerchandize)); ?>

<?php echo $this->element('_productsource_dialog', array('outletmerchandize' => $outletmerchandize)); ?>

<?php echo $this->Html->script('/assets/bootstrap/bootstrap-modal'); ?>