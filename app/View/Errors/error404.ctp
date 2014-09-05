<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<!--<div class="container error-page-container">

    <div class="span2">
        <?php // echo $this->Html->image('page-not-found2.png', array('height'=>'300px', "width"=>'300px')); ?>
    </div>
       Main component for a primary marketing message or call to action 
      <div class="span8">
        <h1>Sorry, Page Not Found!</h1>
        <p>We are sorry this page url(<?php // echo "<strong>'{$url}'</strong>" ?>) you requested to view is not available!
        <p>You can easily try other pages or go back to the dashboard by clicking on the button below.
        <p> 
          <a class="btn btn-lg btn-danger" href="<?php // echo $this->base; ?>" role="button">Back to Dashboard</a>
        </p>
      </div>

</div>  /container -->
    
<h2><?php echo $name; ?></h2>
<p class="error">
	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php 
    printf(
		__d('cake', 'The requested address %s was not found on this server.'),
		"<strong>'{$url}'</strong>"
	); 
    ?>
</p>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
