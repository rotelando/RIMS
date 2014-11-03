<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>
    <div class="page-content">
        <div class="page-header position-relative">
            <h1>
                Setup
                <small>
                    <i class="icon-double-angle-right"></i>
                    Brands, Visibility Elements, Products & Locations
                </small>
            </h1>
        </div>

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>


        <?php echo $this->element('page_tabs'); ?>

        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->
                <div style="height: 10px;"></div>
                <div class="tabbable tabs-top">
                        <ul class="nav nav-tabs" id="myTab3">
                            <li>
                                <a data-toggle="tab" href="#class">
                                    <i class="grey icon-building bigger-110"></i>
                                    Advocacy Class
                                </a>
                            </li>

                            <li class="active">
                                <a data-toggle="tab" href="#channels">
                                    <i class="grey icon-building bigger-110"></i>
                                    Channels
                                </a>
                            </li>

                            <li>
                                <a data-toggle="tab" href="#retail">
                                    <i class="grey icon-building bigger-110"></i>
                                    Retailtypes
                                </a>
                            </li>
                        </ul>
                    
                    <div class="tab-content">

                        <!--============Outlet Types==============-->
                        <div id="class" class="tab-pane">

                            <?php echo $this->element('_outletclass') ?>

                        </div>
                        <!--============End Outlet Types==============-->

                        <!--============Outlet Channel==============-->
                        <div id="channels" class="tab-pane in active">

                            <?php echo $this->element('_outletchannel') ?>
                        </div>
                        <!--============Outlet Channels==============-->

                        <!--============Retail Type==============-->
                        <div id="retail" class="tab-pane">

                            <?php echo $this->element('_retailtype') ?>
                        </div>
                        <!--============Outlet Channels==============-->

                    </div>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->
</div><!--/.main-content-->

