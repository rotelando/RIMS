<?php

class Schedule extends AppModel {
    
    var $name = 'Schedule';
    public $recursive = 1;
    
    var $belongsTo = array(
        'Outlet' => array(
            'className' => 'Outlet',
            'foreignKey' => 'outletid',
        )
    );
}
