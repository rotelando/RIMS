<div class="main-content">


    <?php //echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        
        <div class="page-header position-relative">

            <h1>
                Outlets Management
                <small>
                    <i class="icon-double-angle-right"></i>
                    analysis, creation and views
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
                            <input id="toggleFilter" name="toggleFilter" 
                                   <?php 
                                if(isset($filtertext) && $filtertext != '') {
                                    echo 'data-open="on"'; 
                                } else {
                                    echo 'data-open="off"'; 
                                }    ?> 
                                   class="ace ace-switch ace-switch-4" type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </form>
                </div>
            </h1>

        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <?php echo $this->element('filter_bar_phonebook'); ?>

        <div class="row-fluid">
            <!--Customer Distribution-->
            <h3 class="header smaller lighter green">Distribution</h3>
            <div class="span6" style="margin-left: 0px;">
                <div id="vtu_share" style="min-width: 250px; height: 350px; margin: 0 auto;"></div>
            </div>

            <div class="span6" style="margin-left: 0px;">
                <div id="productsource_share" style="min-width: 250px; height: 350px; margin: 0 auto;"></div>
            </div>
        </div>

        <div class="row-fluid">

            <div class="span12" id="top_page">
                <div class="row-fluid">
                    <h3 class="span12 header smaller lighter green">Phone Book List</h3>

                    <div>
                        <label class="pull-left" style="margin-top: 4px; margin-right: 10px;">Page size</label>
                        <select id="pgSize" class="pull-left span1">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                        </select>

                        <div class="push-left" id="ajax-loader" style="display:inline; margin-left: 50px;"><img src="/assets/images/ajax-loader.gif" /></div>


                        <a href='#' class='export pull-right' id="export"></a>
                        <input type="text" name="q" id="q" placeholder="Search by Outletname" class="pull-right" />
                        <label class="pull-right" style="margin-top: 4px; margin-right: 10px;">Search</label>

                    </div>

                    <table id="all_outlet_table" class="table table-striped table-bordered table-hover display">

                    </table>
                </div>
            </div>

            <div style="text-align: center;">

                <h4 class="text-info"></h4>

                <div class="pagination">
                    <ul>
                        <!--<li><a href="/images/index/page:0" rel="first">&laquo;</a></li>
                        <li><a href="/images/index/page:81" rel="previous">&lsaquo;</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="/images/index/page:2">2</a></li>
                        <li><a href="/images/index/page:3">3</a></li>
                        <li><a href="/images/index/page:4">4</a></li>
                        <li><a href="/images/index/page:5">5</a></li>
                        <li><a href="/images/index/page:6">6</a></li>
                        <li><a href="/images/index/page:7">7</a></li>
                        <li><a href="/images/index/page:8">8</a></li>
                        <li><a href="/images/index/page:9">9</a></li>
                        <li><a href="/images/index/page:81" rel="next">&rsaquo;</a></li>
                        <li><a href="/images/index/page:81" rel="last">&raquo;</a></li>-->
                    </ul>
                </div>
            </div>
        </div><!--/.row-fluid-->

        <?php //endif; ?>
        
        
    </div><!--/.page-content-->
</div><!--/.main-content-->