<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        <?php if(!isset($visibilitycount) || $visibilitycount == 0): ?>
            
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

        <div class="row-fluid" id="chartCanvas">
            <h3 class="span12 header smaller lighter green">Visibility Shares per item</h3> 
            <!--Visibility Evaluations-->
            <!-- <div class="row-fluid" id="chartCanvas"></div> -->
        
        <?php endif; ?>
    </div><!--/.page-content-->
</div><!--/.main-content-->


