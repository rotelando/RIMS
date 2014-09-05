
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

    <!--basic styles-->
    <?php echo $this->Html->css('bootstrap'); ?>
    <?php echo $this->Html->css('bootstrap-responsive.min'); ?>
    <?php echo $this->Html->css('font-awesome.min'); ?>
    <!--[if IE 7]>
      <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="assets/css/ace.min.css" />
    <link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
    <link rel="stylesheet" href="assets/css/ace-skins.min.css" />

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

    

<style type="text/css">

    html { height: 100% }

    body { 
        height: 100%; 
        margin: 0; 
        padding: 0; 
    }

    #container {
        min-height: 100%;
        position: relative;
    }
    
    #mapfooter {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 80px;
        z-index: 3;
        background: rgba(0, 0, 0, 0.3);
    }
    
    #mapfootercontent {
        opacity: 1.0;
        padding: 10px;
        margin-top: 5px;
    }
    
    #mapbg { 
        height: 100%; 
        position: fixed; 
        top: 0; 
        bottom: 0; 
        left: 0; 
        right: 0; 
        z-index: 0;
    }      

    #wrapper { 
        height:20%; 
        width: 960px;
        position: absolute; 
        left: 50%; 
        margin-left: -480px; 
        z-index:1;
        padding: 20px;
    }
    
    
    select {
        font-size: 1.0em;
        padding: 5px 5px;
        margin: 0px;
        cursor: pointer;
    }
    
    input {
        width: 73%;
        font-size: 1.0em;
        padding: 5px 5px;
    }
    
    label {
        display: block;
        color: white;
        font-size: 1.0em;
    }
</style>
</head>
<body>

    <div id="mapcontainer">
        <div id="mapfooter">
            <div id="mapfootercontent">
                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
    </div>
    
    <div id="wrapper"></div>

    <div id="mapbg"></div>


        <?php echo $this->Html->script('jquery.min'); ?>
        <?php echo $this->Html->script('bootstrap'); ?>
        <!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyD9mvSGpeyg1gQqLiNr0nTFOstlNhuPx8g&sensor=true"></script>-->
        
            <?php echo $this->Html->script('init'); ?>
            <?php echo $this->Html->script('maps'); ?>
        <script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

        <script src="assets/js/ace-extra.min.js"></script>
        

        
        <script type="text/javascript"></script>
</body>
</html>
