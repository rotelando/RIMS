<?php


class DATABASE_CONFIG {

    public $default = [];


    function __construct() {

        /*$enviroment = get_cfg_var('APPLICATION_ENV');
        debug($enviroment);*/

        $rims_host = get_cfg_var('rims_host');
        $rims_db = get_cfg_var('rims_db');
        $rims_username = get_cfg_var('rims_username');
        $rims_password = get_cfg_var('rims_password');

        $this->default = array(
            'datasource' => 'Database/Mysql',
            'persistent' => false,
            'host' => $rims_host,
            'login' => $rims_username,
            'password' => $rims_password,
            'database' => $rims_db,
            'encoding' => 'utf8'
        );
    }



	// public $default = array(
	// 	'datasource' => 'Database/Mysql',
	// 	'persistent' => false,
	// 	'host' => 'localhost',
	// 	'login' => 'root',
	// 	'password' => '',
	// 	'database' => 'fieldmax_reports',
	// 	'encoding' => 'utf8'
	// );
}
