<div class="menu-sidebar" id="menu-sidebar">
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>

    <ul class="nav nav-list">
        
        
        <!-- ================== End the separation of view for the setup ================== -->
        <?php if($current_user['userroleid'] == 1): ?>
        <li <?php if(isset($active_item) && $active_item == 'setup') echo 'class="active"'; ?> >
            <?php echo $this->Html->link('<i class="icon-th-large"></i>
                <span class="menu-text"> Setup </span><b class="arrow icon-angle-down"></b>',
                    array('controller'=>'brands'),
                        array('escape'=>false, 'class'=>'dropdown-toggle')); ?>
            
            <ul class="submenu">
                <li <?php if(isset($active_sub_item) && $active_sub_item == 'brands') echo 'class="active"'; ?> >
                    <?php echo $this->Html->link('<i class="icon-tag"></i> Brands',
                            array('controller'=>'brands'),
                                array('escape'=>false)); ?>
                </li>

                <li <?php if(isset($active_sub_item) && $active_sub_item == 'products') echo 'class="active"'; ?> >
                    <?php echo $this->Html->link('<i class="icon-suitcase"></i> Products',
                            array('controller'=>'products'),
                                array('escape'=>false)); ?>
                </li>
                <li <?php if(isset($active_sub_item) && $active_sub_item == 'locations') echo 'class="active"'; ?> >
                    <?php echo $this->Html->link('<i class="icon-location-arrow"></i> Locations <b class="arrow icon-angle-down"></b>',
                            array('controller'=>'locations', 'action' => ''),
                                array('escape'=>false, 'class'=>'dropdown-toggle')); ?>
                    
                    <ul class="submenu" style="display: block;">
                                    <li>
                                        <?php echo $this->Html->link('<i class="icon-globe"></i> Country ',
                                            array('controller'=>'countries'),
                                                array('escape'=>false)); ?>
									</li>
                                    <li>
                                        <?php echo $this->Html->link('<i class="icon-globe"></i> Regions ',
                                            array('controller'=>'regions'),
                                            array('escape'=>false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('<i class="icon-globe"></i> Sub-Regions ',
                                            array('controller'=>'subregions'),
                                            array('escape'=>false)); ?>
                                    </li>
                                    <li>
                                        <?php echo $this->Html->link('<i class="icon-globe"></i> States',
                                            array('controller'=>'states'),
                                                array('escape'=>false)); ?>
									</li>
									<li>
                                        <?php echo $this->Html->link('<i class="icon-globe"></i> Territories ',
                                            array('controller'=>'territories', 'action' => 'index'),
                                                array('escape'=>false)); ?>
									</li>
									<li>
                                        <?php echo $this->Html->link('<i class="icon-globe"></i> LGAs ',
                                            array('controller'=>'lgas', 'action' => 'index'),
                                                array('escape'=>false)); ?>
									</li>
                                    <li>
                                        <?php echo $this->Html->link('<i class="icon-globe"></i> Retail Blocks ',
                                            array('controller'=>'locations', 'action' => 'index'),
                                            array('escape'=>false)); ?>
                                    </li>
								</ul>
                </li>

                <!--Outlet module settings-->
                <li <?php if(isset($active_sub_item) && $active_sub_item == 'types') echo 'class="active"'; ?> >
                    <?php echo $this->Html->link('<i class="icon-building"></i> Outlets',
                            array('controller'=>'outlettypes'),
                                array('escape'=>false)); ?>
                </li>

                <!--Merchandize Module setup and settings-->
                <li <?php if(isset($active_sub_item) && $active_sub_item == 'merchandize') echo 'class="active"'; ?> >
                    <?php echo $this->Html->link('<i class="icon-tags"></i> Merchandize',
                            array('controller'=>'Merchandize'),
                                array('escape'=>false)); ?>
                </li>

                <!--Target setup and settings-->
                <li <?php if(isset($active_sub_item) && $active_sub_item == 'targets') echo 'class="active"'; ?> >
                    <?php echo $this->Html->link('<i class="icon-tags"></i> Targets',
                        array('controller'=>'targets'),
                        array('escape'=>false)); ?>
                </li>
            </ul>
        </li>
        <!-- ================== End the separation of view for the setup ================== -->
        
        <!-- ================== Start the separation of view for the Users ================== -->
        
        <?php // if($current_user['userroleid'] == 1 || $current_user['userroleid'] == 2 || $current_user['userroleid'] == 4): ?>
        <li <?php if(isset($active_item) && $active_item == 'users') echo 'class="active"'; ?> >
            <?php echo $this->Html->link('<i class="icon-group"></i>
                <span class="menu-text"> Users <span class="badge badge-primary">'. ($user_count != 0 ? $user_count : '').'</span></span><b class="arrow icon-angle-down"></b>',
                    array('controller'=>'users','action'=>'index'),
                        array('escape'=>false, 'class'=>'dropdown-toggle')); ?>
            
            <ul class="submenu">
                <li>
                    <?php echo $this->Html->link('<i class="icon-user"></i> User Lists',
                            array('controller'=>'users','action'=>'index'),
                                array('escape'=>false)); ?>
                </li>
                <li>
                    <?php echo $this->Html->link('<i class="icon-briefcase"></i> Role Management',
                            array('controller'=>'rolemodules','action'=>'index'),
                                array('escape'=>false)); ?>
                </li>
                <!--<li>
                    <?php /*echo $this->Html->link('<i class="icon-credit-card"></i> License',
                            array('controller'=>'licenses','action'=>'index'),
                                array('escape'=>false)); */?>
                </li>-->
             </ul>   
        </li>

        <!-- ================== End the separation of view for the Users ================== -->
        <?php endif; ?>
        
        <li <?php if(isset($active_item) && $active_item == 'dashboard') echo 'class="active"'; ?> >
            <?php echo $this->Html->link('<i class="icon-dashboard"></i>
                <span class="menu-text"> Dashboard </span>',
                    array('controller'=>'dashboard','action'=>'index'),
                        array('escape'=>false)); ?>
        </li>
        
        <li <?php if(isset($active_item) && $active_item == 'outlets') echo 'class="active"'; ?>>
            <?php echo $this->Html->link('<i class="icon-building"></i>
                <span class="menu-text"> Outlets <span class="badge badge-primary">'. ($outlet_count != 0 ? $outlet_count : '').'</span></span>',
                    array('controller'=>'outlets','action'=>'index'),
                        array('escape'=>false)); ?>
        </li>

        <li <?php if(isset($active_item) && $active_item == 'products') echo 'class="active"'; ?>>
            <?php echo $this->Html->link('<i class="icon-briefcase"></i>
                <span class="menu-text"> Products </span>',
                array('#'=>'#'),
                        array('escape'=>false)); ?>
        </li>

        <li <?php if(isset($active_item) && $active_item == 'outletmerchandize') echo 'class="active"'; ?>>
            <?php echo $this->Html->link('<i class="icon-bookmark"></i>
                <span class="menu-text"> Merchandizing </span>',
                array('controller'=>'outletmerchandize', 'action' => 'index'),
                        array('escape'=>false)); ?>
        </li>

        <li <?php if(isset($active_item) && $active_item == 'phonebook') echo 'class="active"'; ?>>
            <?php echo $this->Html->link('<i class="icon-mobile-phone"></i>
                <span class="menu-text"> Phone Book </span>',
                array('controller'=>'phonebook', 'action' => 'index'),
                array('escape'=>false)); ?>
        </li>

        <li <?php if(isset($active_item) && $active_item == 'images') echo 'class="active"'; ?>>
            <?php echo $this->Html->link('<i class="icon-picture"></i>
                <span class="menu-text"> Images </span>',
                    array('controller'=>'outletimages'),
                        array('escape'=>false)); ?>
        </li>

        <!--

        <li <?php /*if(isset($active_item) && $active_item == 'products') echo 'class="active"'; */?>>
            <?php /*echo $this->Html->link('<i class="icon-briefcase"></i>
                <span class="menu-text"> Products <span class="badge badge-primary">'. '0' .'</span></span>',
                    array('controller'=>'products','action'=>'index'),
                        array('escape'=>false)); */?>
        </li>

        <li <?php /*if(isset($active_item) && $active_item == 'visibilities') echo 'class="active"'; */?>>
            <?php /*echo $this->Html->link('<i class="icon-bookmark"></i>
                <span class="menu-text"> Merchandizing </span>',
                    array('controller'=>'visibilityevaluations','action'=>'index'),
                        array('escape'=>false)); */?>
        </li>

        <li <?php /*if(isset($active_item) && $active_item == 'phonebook') echo 'class="active"'; */?>>
            <?php /*echo $this->Html->link('<i class="icon-mobile-phone"></i>
                <span class="menu-text"> Phone Book </span>',
                array('controller'=>'phonebook','action'=>'index'),
                array('escape'=>false)); */?>
        </li>

        <li <?php /*if(isset($active_item) && $active_item == 'images') echo 'class="active"'; */?>>
            <?php /*echo $this->Html->link('<i class="icon-picture"></i>
                <span class="menu-text"> Images </span>',
                    array('controller'=>'images','action'=>'index'),
                        array('escape'=>false)); */?>
        </li>-->

        <li <?php if(isset($active_item) && $active_item == 'maps') echo 'class="active"'; ?>>
            <?php echo $this->Html->link('<i class="icon-globe"></i>
                <span class="menu-text"> Maps </span>',
                    array('controller'=>'maps','action'=>'index'),
                        array('escape'=>false)); ?>
        </li>
    </ul><!--/.nav-list-->

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>

    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>