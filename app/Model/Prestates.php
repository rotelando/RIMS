<?php

class Prestate extends AppModel {
    
    var $name = 'State';
    var $displayField = 'statename';
    
    var $belongsTo = array(
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
        )
    );
}