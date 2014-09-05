<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->
        
        <?php if(count($orders) == 0): ?>
            
            <div class="page-header position-relative">
                <h1>
                    Sales Management
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Sales, Orders and requests
                    </small>
                </h1>
            </div><!--/.page-header-->
            <div class="row">
                <h3 class="text-center text-warning">No sales record available</h3>
            </div>
            
        <?php else: ?>
            
        <div class="page-header position-relative">

            <h1>
                Sales Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    Sales, Orders and requests
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

        <div class="row-fluid">

            <div class="span12">
                <div class="row-fluid">
                    <h3 class="span12 header smaller lighter green">All Sales</h3>

                    <?php if(isset($orders) && count($orders) > 0): ?>
                        
                        <table id="order_all_table" class="table table-striped table-bordered table-hover display">
                            <thead>
                                <tr>
                                    <!-- <th width="3%"> S/N </th> -->
                                    <th> Outlet Name </th>
                                    <th width="20%"> Product </th>
                                    <th width="5%"> Quantity </th>
                                    <th width="5%"> Discount </th>
                                    <th width="15%"> Status </th>
                                    <th width="10%" style="text-align: center"> Actions </th>
                                </tr>
                            </thead>
                        </table>

                        <?php 
                            else:
                                echo 'No Sales recorded yet';
                            endif;
                         ?>
                </div>
            </div>
        </div><!--/.row-fluid-->
        <?php endif; ?>
    </div><!--/.page-content-->
</div><!--/.main-content-->


