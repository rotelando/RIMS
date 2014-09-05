<?php

class State extends AppModel {
    
    var $name = 'State';
    var $displayField = 'statename';
    
    var $belongsTo = array(
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'countryid'
        ),
        'Region' => array(
            'className' => 'Region',
            'foreignKey' => 'regionid'
        )
    );
    
    public $hasMany = array(
        'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'stateid',
            'conditions' => array(
                'Location.deletedat' => null
            ),
            'order' => 'Location.createdat DESC',
            'dependent' => true
        ),
        'Locationgroup' => array(
            'className' => 'Locationgroup',
            'foreignKey' => 'stateid',
            'conditions' => array(
                'Locationgroup.deletedat' => null
            ),
            'order' => 'Locationgroup.createdat DESC',
            'dependent' => true
        )
    );
}