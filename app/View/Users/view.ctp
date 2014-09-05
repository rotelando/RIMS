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
        <div class="page-header position-relative"><!--.page-header-->
            <h1>
                <?php echo ucfirst($user['User']['firstname']) . ' ' . ucfirst($user['User']['lastname']); ?>
            </h1>
        </div><!--/.page-header-->

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>

        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->

                <div class="clearfix">
                </div>

                <div style="display: block;">
                    <div id="user-profile-1" class="user-profile row-fluid">
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
                                        <span class="bigger-175 blue"><?php echo $plannedVisitCount; ?></span>

                                        <br>
                                        Planned Visits
                                    </div>

                                    <div class="grid2">
                                        <span class="bigger-175 blue"><?php echo $actualVisitCount; ?></span>

                                        <br>
                                        Actual Visits
                                    </div>
                                </div>
                                
                                <div class="hr hr12 dotted"></div>

                                <div class="clearfix">
                                    <div class="grid2">
                                        <span class="bigger-175 blue"><?php echo $outletCount; ?></span>

                                        <br>
                                        Total Outlets
                                    </div>

                                    <div class="grid2">
                                        <span class="bigger-175 blue"><?php echo $salesCount; ?></span>

                                        <br>
                                        Total Sales
                                    </div>
                                </div>
                                <div class="hr hr16 dotted"></div>
                             <?php endif; ?>
                                </div>
                        </div>


                        <!-- The Buttons at the top  -->
                        <div class="span8">
                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-small">
                                    <h4 class="blue smaller">
                                        <i class="icon-rss orange"></i>
                                        Recent Activities
                                    </h4>

                                    <div class="widget-toolbar action-buttons">
                                        <a href="#" data-action="reload">
                                            <i class="icon-refresh blue"></i>
                                        </a>

                                        &nbsp;
                                        <a href="#" class="pink">
                                            <i class="icon-trash"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="widget-body activity-container">
                                    <div class="widget-main padding-8">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 400px;">
                                            <div id="profile-feed-1" class="profile-feed" style="overflow: hidden; width: auto; height: 400px;">
                                                <div class="profile-activity clearfix">
                                                    <div>
                                                        <i class="pull-left thumbicon icon-download-alt btn-success no-hover"></i>
                                                        <a class="user" href="#"><?php echo ucfirst($user['User']['firstname']) . ' ' . ucfirst($user['User']['lastname']); ?></a>
                                                        downloaded a
                                                        <a href="#">brief</a>
                                                        <div class="time">
                                                            <i class="icon-time bigger-110"></i>
                                                            14-12-2013 10:45 AM
                                                        </div>
                                                    </div>

                                                    <div class="tools action-buttons">
<!--                                                        <a href="#" class="blue">
                                                            <i class="icon-pencil bigger-125"></i>
                                                        </a>-->

                                                        <a href="#" class="red">
                                                            <i class="icon-remove bigger-125"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="profile-activity clearfix">
                                                    <div>
                                                        <i class="pull-left thumbicon icon-picture btn-info no-hover"></i>
                                                        <a class="user" href="#"> <?php echo ucfirst($user['User']['firstname']) . ' ' . ucfirst($user['User']['lastname']); ?> </a>
                                                        uploaded a new 
                                                        <a href="#">photo</a>.

                                                        <div class="time">
                                                            <i class="icon-time bigger-110"></i>
                                                            12-12-2013 12:30 PM
                                                        </div>
                                                    </div>

                                                    <div class="tools action-buttons">
                                                        <a href="#" class="red">
                                                            <i class="icon-remove bigger-125"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="profile-activity clearfix">
                                                    <div>
                                                        <i class="pull-left thumbicon icon-user btn-info no-hover"></i>
                                                        <a class="user" href="#"> <?php echo ucfirst($user['User']['firstname']) . ' ' . ucfirst($user['User']['lastname']); ?> </a>

                                                        created a new user.
                                                        <div class="time">
                                                            <i class="icon-time bigger-110"></i>
                                                            11-12-2013 2:00 PM
                                                        </div>
                                                    </div>

                                                    <div class="tools action-buttons">
                                                        <a href="#" class="red">
                                                            <i class="icon-remove bigger-125"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="profile-activity clearfix">
                                                    <div>
                                                        <i class="pull-left thumbicon icon-key btn-info no-hover"></i>
                                                        <a class="user" href="#"> <?php echo ucfirst($user['User']['firstname']) . ' ' . ucfirst($user['User']['lastname']); ?> </a>

                                                        logged in.
                                                        <div class="time">
                                                            <i class="icon-time bigger-110"></i>
                                                            11-12-2013 2:30 PM
                                                        </div>
                                                    </div>

                                                    <div class="tools action-buttons">
                                                        <a href="#" class="red">
                                                            <i class="icon-remove bigger-125"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="profile-activity clearfix">
                                                    <div>
                                                        <i class="pull-left thumbicon icon-off btn-inverse no-hover"></i>
                                                        <a class="user" href="#"> <?php echo ucfirst($user['User']['firstname']) . ' ' . ucfirst($user['User']['lastname']); ?> </a>

                                                        logged out.
                                                        <div class="time">
                                                            <i class="icon-time bigger-110"></i>
                                                            10-12-2013 3:00 PM
                                                        </div>
                                                    </div>

                                                    <div class="tools action-buttons">
                                                        <a href="#" class="red">
                                                            <i class="icon-remove bigger-125"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                
                                                <div class="profile-activity clearfix">
                                                    <div>
                                                        <i class="pull-left thumbicon icon-picture btn-info no-hover"></i>
                                                        <a class="user" href="#"> <?php echo ucfirst($user['User']['firstname']) . ' ' . ucfirst($user['User']['lastname']); ?> </a>
                                                        uploaded a new 
                                                        <a href="#">photo</a>.

                                                        <div class="time">
                                                            <i class="icon-time bigger-110"></i>
                                                            12-12-2013 12:30 PM
                                                        </div>
                                                    </div>

                                                    <div class="tools action-buttons">
                                                        <a href="#" class="red">
                                                            <i class="icon-remove bigger-125"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="profile-activity clearfix">
                                                    <div>
                                                        <i class="pull-left thumbicon icon-user btn-info no-hover"></i>
                                                        <a class="user" href="#"> <?php echo ucfirst($user['User']['firstname']) . ' ' . ucfirst($user['User']['lastname']); ?> </a>

                                                        created a new user.
                                                        <div class="time">
                                                            <i class="icon-time bigger-110"></i>
                                                            11-12-2013 2:00 PM
                                                        </div>
                                                    </div>

                                                    <div class="tools action-buttons">
                                                        <a href="#" class="red">
                                                            <i class="icon-remove bigger-125"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="profile-activity clearfix">
                                                    <div>
                                                        <i class="pull-left thumbicon icon-key btn-info no-hover"></i>
                                                        <a class="user" href="#"> <?php echo ucfirst($user['User']['firstname']) . ' ' . ucfirst($user['User']['lastname']); ?> </a>

                                                        logged in.
                                                        <div class="time">
                                                            <i class="icon-time bigger-110"></i>
                                                            11-12-2013 2:30 PM
                                                        </div>
                                                    </div>

                                                    <div class="tools action-buttons">
                                                        <a href="#" class="red">
                                                            <i class="icon-remove bigger-125"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="profile-activity clearfix">
                                                    <div>
                                                        <i class="pull-left thumbicon icon-off btn-inverse no-hover"></i>
                                                        <a class="user" href="#"> <?php echo ucfirst($user['User']['firstname']) . ' ' . ucfirst($user['User']['lastname']); ?> </a>

                                                        logged out.
                                                        <div class="time">
                                                            <i class="icon-time bigger-110"></i>
                                                            10-12-2013 3:00 PM
                                                        </div>
                                                    </div>

                                                    <div class="tools action-buttons">
                                                        <a href="#" class="red">
                                                            <i class="icon-remove bigger-125"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="hr hr2 hr-double"></div>

                            <div class="space-6"></div>

                            <div class="center">
                                <a href="<?php echo $this->base.'/auditlogs/index/' . $user['User']['id']; ?>" class="btn btn-small btn-primary">
                                    <i class="icon-rss bigger-150 middle"></i>

                                    View more activities
                                    <i class="icon-on-right icon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row fluid -->
    </div><!--/.page-content-->

    <?php // echo $this->element('settings'); ?>

</div><!--/.main-content-->

<?php echo $this->element('edit-profile-dialog'); ?>