<div class="navbar" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-inner">
        <div class="container-fluid">
            <a href="#" class="brand">
                <small>
                    <?php 
                         echo $this->Html->image('logo_fileldmaxpro.png', array('alt' => 'logo', 'class' => 'center', 'height' => '25px', 'width' => '145px'));
                    ?>
                    <!--FieldMax Pro-->
                </small>
            </a><!--/.brand-->

            <ul class="nav ace-nav pull-right">
<!--                <li class="grey">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon-tasks"></i>
                        <span class="badge badge-grey">4</span>
                    </a>

                    <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer">
                        <li class="nav-header">
                            <i class="icon-ok"></i>
                            4 Tasks to complete
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Software Update</span>
                                    <span class="pull-right">65%</span>
                                </div>

                                <div class="progress progress-mini ">
                                    <div style="width:65%" class="bar"></div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Hardware Upgrade</span>
                                    <span class="pull-right">35%</span>
                                </div>

                                <div class="progress progress-mini progress-danger">
                                    <div style="width:35%" class="bar"></div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Unit Testing</span>
                                    <span class="pull-right">15%</span>
                                </div>

                                <div class="progress progress-mini progress-warning">
                                    <div style="width:15%" class="bar"></div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">Bug Fixes</span>
                                    <span class="pull-right">90%</span>
                                </div>

                                <div class="progress progress-mini progress-success progress-striped active">
                                    <div style="width:90%" class="bar"></div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                See tasks with details
                                <i class="icon-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>-->


                <!--This will be implmented for notifications-->
<!--                <li class="purple">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon-bell-alt icon-animated-bell"></i>
                        <span class="badge badge-important">8</span>
                    </a>

                    <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-closer">
                        <li class="nav-header">
                            <i class="icon-warning-sign"></i>
                            8 Notifications
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">
                                        <i class="btn btn-mini no-hover btn-pink icon-comment"></i>
                                        New Comments
                                    </span>
                                    <span class="pull-right badge badge-info">+12</span>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="btn btn-mini btn-primary icon-user"></i>
                                Bob just signed up as an editor ...
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">
                                        <i class="btn btn-mini no-hover btn-success icon-shopping-cart"></i>
                                        New Orders
                                    </span>
                                    <span class="pull-right badge badge-success">+8</span>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <div class="clearfix">
                                    <span class="pull-left">
                                        <i class="btn btn-mini no-hover btn-info icon-twitter"></i>
                                        Followers
                                    </span>
                                    <span class="pull-right badge badge-info">+11</span>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                See all notifications
                                <i class="icon-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>-->

                
                
<!--                <li class="green">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon-envelope icon-animated-vertical"></i>
                        <span class="badge badge-success">5</span>
                    </a>

                    <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer">
                        <li class="nav-header">
                            <i class="icon-envelope-alt"></i>
                            5 Messages
                        </li>

                        <li>
                            <a href="#">
                                <img src="assets/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar">
                                <span class="msg-body">
                                    <span class="msg-title">
                                        <span class="blue">Alex:</span>
                                        Ciao sociis natoque penatibus et auctor ...
                                    </span>

                                    <span class="msg-time">
                                        <i class="icon-time"></i>
                                        <span>a moment ago</span>
                                    </span>
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <img src="assets/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar">
                                <span class="msg-body">
                                    <span class="msg-title">
                                        <span class="blue">Susan:</span>
                                        Vestibulum id ligula porta felis euismod ...
                                    </span>

                                    <span class="msg-time">
                                        <i class="icon-time"></i>
                                        <span>20 minutes ago</span>
                                    </span>
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <img src="assets/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar">
                                <span class="msg-body">
                                    <span class="msg-title">
                                        <span class="blue">Bob:</span>
                                        Nullam quis risus eget urna mollis ornare ...
                                    </span>

                                    <span class="msg-time">
                                        <i class="icon-time"></i>
                                        <span>3:15 pm</span>
                                    </span>
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                See all messages
                                <i class="icon-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>-->

                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <?php // echo $this->Html->image('/assets/avatars/user.jpg', array('class' => 'nav-user-photo', 'alt' => "Jason's Photo")); ?>
                        <!--<img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo">-->
                        <span class="user-info">
                            <small>Welcome,</small>
                            <?php echo $current_user['firstname']; ?>
                        </span>

                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                        <li>
                                <?php
                                echo $this->Html->link('<i class="icon-key"></i> Change Password', array('controller' => 'settings', 'action' => 'changepassword'), array('escape' => false));
                                ?>
                        </li>

                        <li>
                                <?php
                                echo $this->Html->link('<i class="icon-user"></i> Profile', array('controller' => 'users', 'action' => 'view', $current_user['id']), array('escape' => false));
                                ?>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <?php
                            echo $this->Html->link('<i class="icon-off"></i> Logout', array('controller' => 'users', 'action' => 'logout'), array('escape' => false));
                            ?>
                        </li>
                    </ul>
                </li>
            </ul><!--/.ace-nav-->
        </div><!--/.container-fluid-->
    </div><!--/.navbar-inner-->
</div>