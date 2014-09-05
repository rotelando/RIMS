
<!DOCTYPE html>
<!--
Template Name: Admin Lab Dashboard build with Bootstrap v2.3.1
Template Version: 1.2
Author: Mosaddek Hossain
Website: http://thevectorlab.net/
-->

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Login page</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <?php echo $this->Html->css('/assets/bootstrap/css/bootstrap.min'); ?>
        <?php echo $this->Html->css('font-awesome/css/font-awesome'); ?>
        <?php echo $this->Html->css('style'); ?>
        <?php echo $this->Html->css('style_responsive'); ?>
        <?php echo $this->Html->css('style_default'); ?>

        <!--  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
          <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
          <link href="css/style.css" rel="stylesheet" />
          <link href="css/style_responsive.css" rel="stylesheet" />
          <link href="css/style_default.css" rel="stylesheet" id="style_color" />-->

    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body id="login-body">
<!--        <div class="login-header">
             BEGIN LOGO 
            <div id="logo" class="center">
               <?php 
//                  echo $this->Html->image('logo_fileldmaxpro.png', array('alt' => 'logo', 'class' => 'center', 'height' => '150px', 'width' => '350px'));
                ?>
                FieldMax Pro
                <img src="img/logo.png" alt="logo" class="center" />
            </div>
             END LOGO 
        </div>-->
        <div id="login_title_head">
             <?php 
                  echo $this->Html->image('logo_fileldmaxpro.png', array('alt' => 'logo', 'class' => 'center', 'height' => '80px'));
                ?>
        </div>
            
        
        
        <!-- BEGIN LOGIN -->
        <div id="login">
 
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->Session->flash('auth'); ?>

            <?php echo $this->fetch('content'); ?>


            <!-- BEGIN FORGOT PASSWORD FORM -->
            <!--            <form id="forgotform" class="form-vertical no-padding no-margin hide" action="index.html">
                            <p class="center">Enter your e-mail address below to reset your password.</p>
                            <div class="control-group">
                                <div class="controls">
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="icon-envelope"></i></span><input id="input-email" type="text" placeholder="Email"  />
                                    </div>
                                </div>
                                <div class="space20"></div>
                            </div>
                            <input type="button" id="forget-btn" class="btn btn-block login-btn" value="Submit" />
                        </form>-->
            <!-- END FORGOT PASSWORD FORM -->
        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
        <div id="login-copyright">
            2013 &copy; Retail Information Management System (RIMS).
        </div>
        <!-- END COPYRIGHT -->
        <!-- BEGIN JAVASCRIPTS -->

        <?php echo $this->Html->script('jquery-2.0.3.min'); ?>
        <?php echo $this->Html->script('/assets/bootstrap/js/bootstrap.min'); ?>
        <?php echo $this->Html->script('jquery.blockui'); ?>
        <?php // echo $this->Html->script('scripts'); ?>

<!--  <script src="js/jquery-1.8.3.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="js/jquery.blockui.js"></script>
<script src="js/scripts.js"></script>-->

        <script>
           $(document).ready(function() {     

               var msg = $('#authMessage').html();
               var htmlContent = '<div class="alert alert-block alert-inverse" style="text-align: center">';
                htmlContent += '<button type="button" class="close" data-dismiss="alert">';
                htmlContent += '<i class="icon-remove"></i>';
                htmlContent += '</button>';
                htmlContent += msg + '</div>';
                $('#authMessage').html(htmlContent);
               console.log(msg);

           });
            
        </script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>