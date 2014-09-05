<?php

class Visit extends AppModel {
    
    var $name = 'Visit';
    public $recursive = 1;
    
    var $hasMany = array(
      'Visibilityevaluation' => array(
          'className' => 'Visibilityevaluation',
          'foreignKey' => 'visitid'
      ),
      'Order' => array(
          'className' => 'Order',
          'foreignKey' => 'visitid'
      )
    );
    
    var $belongsTo = array(
        'Outlet' => array(
            'className' => 'Outlet',
            'foreignKey' => 'outletid',
        )
    );
}
