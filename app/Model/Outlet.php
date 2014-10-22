<?php

class Outlet extends AppModel {
    
    var $name = 'Outlet';
    var $displayField = 'outletname';
    
    var $belongsTo = array(
        'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'location_id',
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        ),
        'Outletclass' => array(
            'className' => 'Outletclass',
            'foreignKey' => 'outletclass_id',
        ),
        'Outletchannel' => array(
            'className' => 'Outletchannel',
        ),
        'Retailtype' => array(
            'className' => 'Retailtype',
            'foreignKey' => 'retailtype_id',
        )
    );
    
    public $hasMany = array(
        'Outletmerchandize' => array(
            'className' => 'Outletmerchandize',
            'foreignKey' => 'outlet_id',
            'dependent' => true
        ),
        'Productsource' => array(
            'className' => 'Productsource',
            'foreignKey' => 'outlet_id',
            'dependent' => true
        ),
        'Outletproduct' => array(
            'className' => 'Outletproduct',
            'foreignKey' => 'outlet_id',
            'dependent' => true
        ),
        'Outletimage' => array(
            'className' => 'Outletimage',
            'foreignKey' => 'outlet_id',
            'dependent' => true
        )
    );
}