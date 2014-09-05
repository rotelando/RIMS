<div class="main-content">
    
<?php echo $this->element('breadcrumb'); ?>

    <?php
    if ($user['User']['active'] == 1):
        $status_color = 'green';
        $status_class_label = 'label-success';
        $status_label = 'Activated';
        $activate_text = 'Deactivate';
    else:
        $status_color = 'red';
        $status_class_label = 'label-danger';
        $status_label = 'Deactivated';
        $activate_text = 'Activate';
    endif;
    ?>


    <div class="page-content">
        <!--.page-header-->
        <div class="page-header position-relative">
            <h1>
                Activity Timeline
                <small>
                    <i class="icon-double-angle-right"></i>
                    Field Staff and Managers
                </small>
            </h1>
            
        </div><!--/.page-header-->

        <div class="row-fluid">
            <div class="span4">
   
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Username </div>

                                    <div class="profile-info-value">
                                        <span style="display: inline;">
                                            <?php echo $user['User']['username']; ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Firstname </div>

                                    <div class="profile-info-value">
                                        <span style="display: inline;"><?php echo $user['User']['firstname']; ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Lastname </div>

                                    <div class="profile-info-value">
                                        <span style="display: inline;"><?php echo $user['User']['lastname']; ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Email </div>

                                    <div class="profile-info-value">
                                        <span style="display: inline;"><?php echo $user['User']['emailaddress']; ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Role </div>

                                    <div class="profile-info-value">
                                        <span style="display: inline;"><?php echo $user['Userrole']['userrolename']; ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Status </div>

                                    <div class="profile-info-value">
                                        <span style="display: inline;"><span class="label <?php echo $status_class_label; ?>  arrowed"><?php echo $status_label; ?></span></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Last Activity </div>

                                    <div class="profile-info-value">
                                        <span><?php echo $user['User']['createdat']; ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Date Created </div>

                                    <div class="profile-info-value">
                                        <span style="display: inline;"><?php echo $user['User']['createdat']; ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-12"></div>
                            <div class="center">
                            <?php if($user['Userrole']['id'] == 3): ?>
                                <div class="hr hr12 dotted"></div>

                                <div class="clearfix">
                                    <div class="grid2">
                                        <span class="bigger-175 blue">0</span>

                                        <br>
                                        Planned Visits
                                    </div>

                                    <div class="grid2">
                                        <span class="bigger-175 blue">0</span>

                                        <br>
                                        Total Visits
                                    </div>
                                </div>
                                
                                <div class="hr hr12 dotted"></div>

                                <div class="clearfix">
                                    <div class="grid2">
                                        <span class="bigger-175 blue">0</span>

                                        <br>
                                        Total Outlets
                                    </div>

                                    <div class="grid2">
                                        <span class="bigger-175 blue">0</span>

                                        <br>
                                        Total Sales
                                    </div>
                                </div>
                                <div class="hr hr16 dotted"></div>
                             <?php endif; ?>
                                </div>
                        </div>
            
            <div class="span8">
                <!--PAGE CONTENT BEGINS-->
                <div class="btn-group pull-right">
                            <button data-toggle="dropdown" class="btn btn-info btn-small dropdown-toggle">
                                Filter By
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu dropdown-info pull-right">
                                <li>
                                    <?php
                                    echo $this->Html->link('Outlets', array('controller' => 'auditlogs', 'action' => 'outlets', $user['User']['id']));
                                    ?>
                                </li>

                                <li>
                                    <?php
                                    echo $this->Html->link('Planned Visit', array('controller' => 'auditlogs', 'action' => 'schedules', $user['User']['id']));
                                    ?>
                                </li>

                                <li>
                                    <?php
                                    echo $this->Html->link('Visit', array('controller' => 'auditlogs', 'action' => 'visits', $user['User']['id']));
                                    ?>
                                </li>
                                
                                <li>
                                    <?php
                                    echo $this->Html->link('Orders', array('controller' => 'auditlogs', 'action' => 'orders', $user['User']['id']));
                                    ?>
                                </li>

                                <!--<li class="divider"></li>-->
                            </ul>
                        </div>
                
                <div id="timeline-1" style="display: block;">
                    <div class="row-fluid">
                        
                        <div class="offset1 span10">
                            <div class="timeline-container">
                                <div class="timeline-label">
                                    <span class="label label-primary arrowed-in-right label-large">
                                        <b>6th December, 2013.</b>
                                    </span>
                                </div>

                                <div class="timeline-items">
                                    <div class="timeline-item clearfix">
                                        <div class="timeline-info">
                                            <i class="timeline-indicator icon-download-alt btn btn-success no-hover"></i>
                                        </div>

                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-small">
                                                <h5 class="smaller">
                                                    <a href="#" class="blue">Brief Download</a>
                                                    <span class="grey"></span>
                                                </h5>

                                                <span class="widget-toolbar no-border">
                                                    <i class="icon-time bigger-110"></i>
                                                    16:22
                                                </span>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    Akintewe Oluwarotimi download a <span class="red">brief</span>
                                                    
                                                    <div class="space-6"></div>

                                                    <div class="widget-toolbox clearfix">
                                                        <div class="pull-left">
                                                            <i class="icon-hand-right grey bigger-125"></i>
                                                            <a href="#" class="bigger-110">Click to download...</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-item clearfix">
                                        <div class="timeline-info">
                                            <i class="timeline-indicator icon-lock btn btn-success no-hover"></i>
                                        </div>

                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-small hidden"></div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <a href="#" class="blue">Ezra Olubi</a> logged out
                                                    <div class="pull-right">
                                                        <i class="icon-time bigger-110"></i>
                                                        12:30
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline-item clearfix">
                                        <div class="timeline-info">
                                            <i class="timeline-indicator icon-key btn btn-success no-hover"></i>
                                        </div>

                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-small hidden"></div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <a href="#" class="blue">Ezra Olubi</a> logged in
                                                    <div class="pull-right">
                                                        <i class="icon-time bigger-110"></i>
                                                        11:23
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-item clearfix">
                                        <div class="timeline-info">
                                            <i class="timeline-indicator icon-user btn btn-pink no-hover green"></i>
                                        </div>

                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-small">
                                                <h5 class="smaller">User Creation</h5>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <a href="#" class="blue">Akintewe Oluwarotimi</a> created a new user [Field staff]
                                                    <span class="green bolder">[Field staff]</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="timeline-item clearfix">
                                        <div class="timeline-info">
                                            <i class="timeline-indicator icon-picture btn btn-inverse no-hover"></i>
                                        </div>

                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-small">
                                                <h5 class="smaller">Image Upload</h5>

                                                <span class="widget-toolbar no-border">
                                                    <i class="icon-time bigger-110"></i>
                                                    10:22
                                                </span>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <div class="clearfix">
                                                        <div class="pull-left">
                                                            Damilare uploaded some images of his visit to Amazing Grace Business Center
                                                        </div>

                                                        <div class="pull-right">
                                                            <i class="icon-chevron-left blue bigger-110"></i>

                                                            &nbsp;
                                                            <img alt="Image 4" width="36" src="assets/images/outlet_01.jpg">
                                                            <img alt="Image 3" width="36" src="assets/images/outlet_02.jpg">
                                                            &nbsp;
                                                            <i class="icon-chevron-right blue bigger-110"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="timeline-item clearfix">
                                        <div class="timeline-info">
                                            <i class="timeline-indicator icon-building btn btn-warning no-hover green"></i>
                                        </div>

                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-small">
                                                <h5 class="smaller">Outlet Management</h5>

                                                <span class="widget-toolbar no-border">
                                                    <i class="icon-time bigger-110"></i>
                                                    8:15
                                                </span>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    Akintewe Oluwarotimi deleted an outlet
                                                    <div class="space-6"></div>

                                                    <div class="widget-toolbox clearfix">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--/.timeline-items-->
                            </div><!--/.timeline-container-->
                        </div>
                    </div>
                </div>

                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->
</div><!--/.main-content-->