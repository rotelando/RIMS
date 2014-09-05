<div class="main-content">

    <?php // echo $this->element('breadcrumb'); ?>


    <div class="page-content">

        <!--.page-header-->
        <div class="page-header position-relative">
            <h1>
                Users
                <small>
                    <i class="icon-double-angle-right"></i>
                    Management &amp; views
                </small>
            </h1>
        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <div class="row-fluid">
            <div class="span12">
                <h3 class="header smaller blue">Compare Field Staff</h3>
                <!--PAGE CONTENT BEGINS-->
                <div class="row-fluid">
                    <div class="span2">
                        <?php echo $this->Form->select('fieldrepid-1', $fieldreplist, array()); ?>
                    </div>
                    <div class="span2">
                        <?php echo $this->Form->select('fieldrepid-2', $fieldreplist, array()); ?>
                    </div>
                    <div class="span2">
                        <?php echo $this->Form->select('fieldrepid-3', $fieldreplist, array()); ?>
                    </div>
                    <div class="span2">
                        <?php echo $this->Form->select('fieldrepid-4', $fieldreplist, array('class' => 'span3')); ?>
                    </div>
                    <div class="span2">
                        <?php echo $this->Form->select('fieldrepid-5', $fieldreplist, array('class' => 'span3')); ?>
                    </div>
                    <div class="span2">
                        <p style="text-align: center;">
                            <?php
                            echo $this->Html->link('Compare Staffs', array('controller' => 'fieldstaffs', 'action' => 'compare'), array('id'=>'btnstaffcompare', 'class' => 'btn btn-primary', 'escape' => false));
                            ?>
                        </p>
                    </div>
                </div>
                <hr />
                
                <div class="space-20"></div>
                .


                <div class="row-fluid">
                    <div>
                        <div class="span3 pricing-span-header">
                            <div class="widget-box transparent">
                                <div class="widget-header">
                                    <h5 class="bigger lighter">Staff Name</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <ul class="unstyled list-striped pricing-table-header">
                                            <li>Total Outlets </li>
                                            <li>Total Planned Visits </li>
                                            <li>Total Actual Visits </li>
                                            <li>Percentage Visits </li>
                                            <li>Total Order </li>
                                            <li>Total Order Value</li>
                                            <li>Total Exception </li>
                                            <li>Location</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php 
                            $color = [ 
                                array('header'=>'header-color-red3','footer'=>'btn-danger'), 
                                array('header'=>'header-color-orange','footer'=>'btn-warning'), 
                                array('header'=>'header-color-blue','footer'=>'btn-primary'), 
                                array('header'=>'header-color-green','footer'=>'btn-success'), 
                                array('header'=>'header-color-purple','footer'=>'btn-purple')
                                ];
                            $i = 0;
                        ?>
                        
                        <?php foreach ($fieldstaffcompare as $fieldstaff): ?>
                        
                        <div class="span2 pricing-span">
                            <div class="widget-box pricing-box-small">
                                <div class="widget-header <?php echo $color[$i]['header']; ?>">
                                    <h5 class="bigger lighter"><?php echo ucwords($fieldstaff['staffname']['User']['firstname'].' '.$fieldstaff['staffname']['User']['lastname']); ?></h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <ul class="unstyled list-striped pricing-table">
                                            <li> <?php echo $fieldstaff['outletcount']; ?> </li>
                                            <li> <?php echo $fieldstaff['plannedvisitcount']; ?> </li>
                                            <li> <?php echo $fieldstaff['actualvisitcount']; ?> </li>
                                            <li> <?php echo rand(6, 15); ?> </li>
                                            <li> <?php echo $fieldstaff['ordercount']; ?> </li>
                                            <li> <?php echo $fieldstaff['ordervalue']; ?> </li>
                                            <li> <?php echo $fieldstaff['totalexception']; ?> </li>

                                            <li>
                                                <!--<i class="icon-remove red"></i>-->
                                                <?php 
                                                    if(isset($fieldstaff['location']['Location']['locationname'])) {
                                                        echo ucwords($fieldstaff['location']['Location']['locationname']);
                                                    } else {
                                                        echo '-';
                                                    }
                                                ?>
                                            </li>
                                        </ul>

                                        <div class="price">
                                            <span class="label label-large label-inverse arrowed-in arrowed-in-right">
                                                <?php echo $fieldstaff['visitperday']; ?> visits
                                                <small> / day</small>
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="<?php echo $this->base . '/users/view/' . $fieldstaff['staffid']; ?>" class="btn btn-block btn-small <?php echo $color[$i++]['footer']; ?>">
                                            <span>More</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php endforeach; ?>
                        
<!--                        <div class="span2 pricing-span">
                            <div class="widget-box pricing-box-small">
                                <div class="widget-header header-color-orange">
                                    <h5 class="bigger lighter">Tosin Adeyemi</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <ul class="unstyled list-striped pricing-table">
                                            <li> 135 </li>
                                            <li> 300 </li>
                                            <li> 250 </li>
                                            <li> 15 </li>
                                            <li> 8 </li>

                                            <li>
                                                Ikeja
                                            </li>
                                        </ul>

                                        <div class="price">
                                            <span class="label label-large label-inverse arrowed-in arrowed-in-right">
                                                10 visits
                                                <small>/ day</small>
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="#" class="btn btn-block btn-small btn-warning">
                                            <span>More</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="span2 pricing-span">
                            <div class="widget-box pricing-box-small">
                                <div class="widget-header header-color-blue">
                                    <h5 class="bigger lighter">Dare Oliwaya</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <ul class="unstyled list-striped pricing-table">
                                            <li> 100 </li>
                                            <li> 200 </li>
                                            <li> 193 </li>
                                            <li> 3 </li>
                                            <li> 2 </li>

                                            <li>
                                                Surulere
                                            </li>
                                        </ul>

                                        <div class="price">
                                            <span class="label label-large label-inverse arrowed-in arrowed-in-right">
                                                5 visits
                                                <small> / day</small>
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="#" class="btn btn-block btn-small btn-primary">
                                            <span>More</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="span2 pricing-span">
                            <div class="widget-box pricing-box-small">
                                <div class="widget-header header-color-green">
                                    <h5 class="bigger lighter">Yomi Adedeji</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <ul class="unstyled list-striped pricing-table">
                                            <li> 160 </li>
                                            <li> 355 </li>
                                            <li> 324 </li>
                                            <li> 19 </li>
                                            <li> 12 </li>

                                            <li>
                                                Magodo
                                            </li>
                                        </ul>

                                        <div class="price">
                                            <span class="label label-large label-inverse arrowed-in arrowed-in-right">
                                                25 visits
                                                <small> / day</small>
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="#" class="btn btn-block btn-small btn-success">
                                            <span>More</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="span2 pricing-span">
                            <div class="widget-box pricing-box-small">
                                <div class="widget-header header-color-purple">
                                    <h5 class="bigger lighter">Taofeek Shile</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <ul class="unstyled list-striped pricing-table">
                                            <li> 150 </li>
                                            <li> 324 </li>
                                            <li> 300 </li>
                                            <li> 15 </li>
                                            <li> 12 </li>

                                            <li>
                                                Ebute Metta
                                            </li>
                                        </ul>

                                        <div class="price">
                                            <span class="label label-large label-inverse arrowed-in arrowed-in-right">
                                                21 visits
                                                <small> / day</small>
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="#" class="btn btn-block btn-small btn-purple">
                                            <span>More</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->