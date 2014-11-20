<?php

class Outletclass extends AppModel {

    public $name = 'Outletclass';
    public $useTable = 'outletclasses';
    public $displayField = 'outletclassname';
    
    var $hasMany = array(
      'Outlet' => array(
          'className' => 'Outlet',
          'foreignKey' => 'outletclass_id'
      )
    );

    public function getClassAsList() {

        $classes = $this->find('list');
        return $classes;
    }
}