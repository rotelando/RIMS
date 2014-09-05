<?php

class Outlet extends AppModel {
    
    var $name = 'Outlet';
    var $displayField = 'outletname';
    
    var $belongsTo = array(
        'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'locationid',
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'userid',
        ),
        'Outlettype' => array(
            'className' => 'Outlettype',
            'foreignKey' => 'outlettypeid',
        ),
        'Outletchannel' => array(
            'className' => 'Outletchannel',
            'foreignKey' => 'outletchannelid',
        )
    );
    
    public $hasMany = array(
        'Visit' => array(
            'className' => 'Visit',
            'foreignKey' => 'outletid',
            'conditions' => array(
                'Visit.deletedat' => null
            ),
            'order' => 'Visit.createdat DESC',
            'dependent' => true
        )
    );
}