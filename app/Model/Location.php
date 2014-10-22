<?php

class Location extends AppModel {
    
    var $name = 'Location';
    var $displayField = 'locationname';
    
     var $belongsTo = array(
        'Lga' => array(
            'className' => 'Lga',
            'foreignKey' => 'lag_id'
        )
    );

    public $hasMany = array(
        'Outlet' => array(
            'className' => 'Outlet',
            'foreignKey' => 'location_id',
            'dependent' => true
        ),
    );
     
}