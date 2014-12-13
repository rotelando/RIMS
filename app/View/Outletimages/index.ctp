<div class="main-content">


    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">
        <!--.page-header-->

        <?php if(count($images) == 0): ?>

            <div class="page-header position-relative">
                <h1>
                    Outlet Images
                    <?php if(!empty($last_image_taken)) {

                        echo "<small>
                            <i class='icon-double-angle-right'></i>
                            Last image taken at outlet <strong>{$last_image_taken['Outlet']['outletname']}</strong> on <strong>{$last_image_taken['Outletimage']['created_at']}</strong>
                            by <strong>{$last_image_taken[0]['fullname']}</strong>.
                            </small>";
                    } ?>
                        <small>
                            <i class="icon-double-angle-right"></i>
                            Last image taken at outlet <strong><?php echo isset($last_image_taken) ? $last_image_taken : 'N/A'; ?></strong>
                        </small>
                </h1>
            </div><!--/.page-header-->
            <div class="row">
                <h3 class="text-center text-warning">No images record available</h3>
            </div>

        <?php else: ?>

            <div class="page-header position-relative">

                <h1>
                    Recent Images
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

            <div class="row-fluid">
                <!--<h3 class="span12 header smaller lighter green">Recent Images-->
                <?php
                //                echo $this->Html->link('<i class="icon-list"></i> More', array('controller' => 'visibilityevaluations', 'action' => 'shares'), array('class' => 'btn btn-mini btn-success pull-right', 'escape' => false));
                ?>
                <!--</h3>-->

                <div class="row-fluid">

                    <div style="text-align: center;">

                        <h4 class="text-info">Showing page <?php echo $this->Paginator->counter(); ?></h4>

                        <div class="pagination">
                            <ul>
                                <?php
                                echo $this->Paginator->numbers(array(
                                    'first' => '<<',
                                    'separator' => '',
                                    'currentClass' => 'active',
                                    'tag' => 'li',
                                    'last' => '>>'
                                ));
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="span12" id="ul-loadmore" style="margin-left: 0px;">


                        <?php $lastdateline = $images[0][0]['dateline']; ?>

                        <h3 class="span12 header smaller text-info">
                            <?php echo $lastdateline; ?>
                        </h3>
                        <?php


                        for ($i = 0; $i < count($images); $i++) {

                            if($i == 0) {

                                $cssstyle = 'style="margin-left: 0px;"'; ?>

                                <ul class="thumbnails image-list jscroll" id="grouped-image-list">

                            <?php } elseif($lastdateline != $images[$i][0]['dateline']) {

                                $cssstyle = 'style="margin-left: 0px;"';
                                $lastdateline = $images[$i][0]['dateline'];
                            ?>
                                </ul>
                                <div class="clearfix"></div>
                                <h3 class="span12 header smaller text-info" style="margin-left: 0px;">

                            <?php echo $lastdateline; ?>

                                </h3>
                                <ul class="thumbnails image-list jscroll" id="grouped-image-list">

                            <?php } elseif(($i % 6) == 0) { $cssstyle = '' ?>

                                    </ul>
                                    <ul class="thumbnails image-list jscroll" id="grouped-image-list">

                            <?php  } else { $cssstyle = ''; } ?>


                                <li
                                    <?php echo $cssstyle; ?>
                                    class="span2"
                                    data-animation="true"
                                    data-rel="popover"
                                    data-html="true"
                                    data-trigger="hover"
                                    data-placement="top"
                                    data-original-title="Image details"
                                    data-content="
                                        <?php
                                    echo '<strong>Outet Name:</strong> ' . ucwords($images[$i]['Outlet']['outletname']) .'<br />';
                                    echo '<strong>Location:</strong> ' .$images[$i]['Location']['locationname'].'<br />';
                                    echo '<strong>Staff:</strong> ' .ucfirst($images[$i][0]['fullname']).'<br />';
                                    echo '<strong>Date:</strong> ' .$images[$i]['Outletimage']['created_at'].'<br />';
                                    ?>"
                                    >

                                    <a href="<?php echo $this->MyLink->getImageUrlPath($images[$i]['Outletimage']['url']); ?>"
                                       title="<?php echo $images[$i]['Outlet']['outletname'] . ' at ' . $images[$i]['Location']['locationname'] . " on " . $images[$i]['Outletimage']['created_at'] ?>"
                                       class="thumbnail">

                                        <img src="<?php echo $this->MyLink->getImageUrlPath($images[$i]['Outletimage']['url']); ?>" alt="">
                                    </a>
                                </li>

                                <?php } ?>
                            </ul>
                            <!--<a id="loadmore" class="loadmore btn btn-success btn-block" href="#" data-id="2">Load more images...</a>-->
                            <!--<img src="<?php // echo $this->base; ?>/assets/images/ajax-loader.gif" id="ajax-loader" />-->
                    </div>

                    <div style="text-align: center;">

                        <h4 class="text-info">Showing page <?php echo $this->Paginator->counter(); ?></h4>

                        <div class="pagination">
                            <ul>
                                <?php
                                echo $this->Paginator->numbers(array(
                                    'first' => '<<',
                                    'separator' => '',
                                    'currentClass' => 'active',
                                    'tag' => 'li',
                                    'last' => '>>'
                                ));
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!--/.row-fluid-->
        <?php endif; ?>
    </div><!--/.page-content-->
</div><!--/.main-content-->


