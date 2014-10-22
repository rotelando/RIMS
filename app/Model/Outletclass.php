<?php

class Outletclass extends AppModel {
    
    var $name = 'Outletclass';
    var $displayField = 'outletclass';
    
    var $hasMany = array(
      'Outlet' => array(
          'className' => 'Outlet',
          'foreignKey' => 'outletclass_id'
      )  
    );
}