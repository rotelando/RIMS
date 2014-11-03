<?php

class Outletclass extends AppModel {

    public $name = 'Outletclass';
    public $useTable = 'outletclasses';
    public $displayField = 'outletclass';
    
    var $hasMany = array(
      'Outlet' => array(
          'className' => 'Outlet',
          'foreignKey' => 'outletclass_id'
      )
    );
}