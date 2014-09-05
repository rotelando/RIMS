<?php

class Locationgroup extends AppModel {
    
    var $name = 'Locationgroup';
    var $displayField = 'locationgroupname';
    
    var $belongsTo = array(
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'stateid'
        )
    );
    
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'locationgroupid',
            'conditions' => array(
                'User.deletedat' => null
            ),
            'order' => 'User.createdat DESC',
            'dependent' => true
        )
    );
}

