<?php

class Outlettype extends AppModel {
    
    var $name = 'Outlettype';
    var $displayField = 'outlettypename';
    
    var $hasMany = array(
      'Outlet' => array(
          'className' => 'Outlet',
          'foreignKey' => 'outlettypeid'
      )  
    );
}