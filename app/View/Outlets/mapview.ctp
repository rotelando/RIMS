<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">

            <h1>
                Outlet Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    Map view
                </small>
                <div class="pull-right">
                    <form class="form-inline">
                        <label>Filter </label>            
                        <label>
                            <input id="toggleFilter" name="toggleFilter" class="ace ace-switch ace-switch-4" type="checkbox">
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
            <h3 class="span12 header smaller lighter green">Full Map View - Outlet Distribution</h3> 

            <div id="outlet-map-canvas"  style="height:600px; margin-left: 0px" class="span12"></div>
            <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
            However, it seems JavaScript is either disabled or not supported by your browser. 
            To view Google Maps, enable JavaScript by changing your browser options, and then 
            try again.
            </noscript>
        </div>
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
</div><!--/.main-content-->


