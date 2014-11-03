<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'dashboard', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	//authentication routing urls
	Router::connect('/login', 
		array('controller' => 'users', 'action' => 'login'));
	Router::connect('/logout', 
		array('controller' => 'users', 'action' => 'logout'));

	//setup routing urls

	Router::connect('/setup/brands', 
		array('controller' => 'brands', 'action' => 'index'));
	Router::connect('/setup/brands/:action', 
		array('controller' => 'brands'));

	Router::connect('/setup/merchandize', 
		array('controller' => 'merchandize', 'action' => 'index'));
	Router::connect('/setup/merchandize/:action',
		array('controller' => 'merchandize', 'action' => 'index'));

    Router::connect('/setup/targets',
		array('controller' => 'targets', 'action' => 'index'));
	Router::connect('/setup/targets/:action',
		array('controller' => 'targets', 'action' => 'index'));

	Router::connect('/setup/products', 
		array('controller' => 'products', 'action' => 'index'));
	Router::connect('/setup/products/:action',
		array('controller' => 'products'));

	Router::connect('/setup/productcategories',
		array('controller' => 'productcategories', 'action' => 'index'));
	Router::connect('/setup/productcategories/:action',
		array('controller' => 'productcategories'));

	Router::connect('/setup/outletclasses',
		array('controller' => 'outletclasses', 'action' => 'index'));
	Router::connect('/setup/outletclasses/:action',
		array('controller' => 'outletclasses'));

    Router::connect('/setup/outletchannels',
        array('controller' => 'outletchannels', 'action' => 'index'));
    Router::connect('/setup/outletchannels/:action',
        array('controller' => 'outletchannels'));

    Router::connect('/setup/retailtypes',
        array('controller' => 'retailtypes', 'action' => 'index'));
    Router::connect('/setup/retailtypes/:action',
        array('controller' => 'retailtypes'));

	Router::connect('/setup/locations/countries',
		array('controller' => 'countries', 'action' => 'index'));
	Router::connect('/setup/locations/countries/:action',
		array('controller' => 'countries'));

	Router::connect('/setup/locations/regions',
		array('controller' => 'regions', 'action' => 'index'));
	Router::connect('/setup/locations/regions/:action',
		array('controller' => 'regions'));

	Router::connect('/setup/locations/subregions', 
		array('controller' => 'subregions', 'action' => 'index'));
	Router::connect('/setup/locations/subregions/:action', 
		array('controller' => 'subregions'));

	Router::connect('/setup/locations/states',
		array('controller' => 'states', 'action' => 'index'));
	Router::connect('/setup/locations/states/:action', 
		array('controller' => 'states'));

	Router::connect('/setup/locations/territories', 
		array('controller' => 'territories', 'action' => 'index'));
	Router::connect('/setup/locations/territories/:action', 
		array('controller' => 'territories'));

    Router::connect('/setup/locations/lgas',
		array('controller' => 'lgas', 'action' => 'index'));
	Router::connect('/setup/locations/lgas/:action',
		array('controller' => 'lgas'));

    Router::connect('/setup/locations/pop',
        array('controller' => 'locations', 'action' => 'index'));
    Router::connect('/setup/locations/pop/:action',
        array('controller' => 'locations'));

    Router::connect('/setup/locations',
        array('controller' => 'countries', 'action' => 'bulkupload'));

    //End Setup routes

	Router::connect('/setup/users', 
		array('controller' => 'users', 'action' => 'index'));
	Router::connect('/setup/users/:action', 
		array('controller' => 'users'));

	Router::connect('/setup/users/userroles', 
		array('controller' => 'rolemodules', 'action' => 'index'));
	Router::connect('/setup/users/userroles/:action', 
		array('controller' => 'rolemodules'));

	Router::connect('/setup/users/licenses',
		array('controller' => 'licenses', 'action' => 'index'));
	Router::connect('/setup/users/licenses/:action', 
		array('controller' => 'licenses'));

    Router::connect('/sales', array('controller' => 'orders'));
    Router::connect('/sales/:action/*', array('controller' => 'orders'));
    
    Router::connect('/orders', array('controller' => 'sales', 'action' => 'index'));
    Router::connect('/orders/:action/*', array('controller' => 'sales'));
    
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';

    