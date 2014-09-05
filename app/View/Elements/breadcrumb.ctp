<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>
    <ul class="breadcrumb">
        
        <?php 
            $count = count($breadcrumb);
//            debug($breadcrumb);
            if($breadcrumb && $count == 1) {
                echo '<li class="active">' . $breadcrumb[0] .
                '</li>';
            } else if($breadcrumb && $count > 1) {
                for($i = 0; $i < $count; $i++) {
                    if($i == $count - 1) {
                        echo '<li class="active">' . $breadcrumb[$i] . '</li>';
                    } else {
                        echo '<li>
                            <i class="icon-home home-icon"></i>
                            <a href="#">' . $breadcrumb[$i] . '</a>
                            <span class="divider">
                                <i class="icon-angle-right arrow-icon"></i>
                            </span>
                        </li>';
                    }
                }
            } else {
                echo '<li class="active"> Home </li>';
            }
        ?>
<!--        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">Home</a>
            <span class="divider">
                <i class="icon-angle-right arrow-icon"></i>
            </span>
        </li>
        <li class="active">Dashboard</li>-->
        
    </ul><!--.breadcrumb-->
    <div class="nav-search" id="nav-search">
        <form class="form-search" action="<?php echo $this->here; ?>" method="get">
            <span class="input-icon">
                <input name="query" type="text" placeholder="Search for Outlets..." class="input-small nav-search-input" id="nav-search-input" autocomplete="off" />
                <i class="icon-search nav-search-icon"></i>
            </span>
        </form>
    </div>
    
    <!--#nav-search-->
</div>