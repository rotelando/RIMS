<?php

class Country extends AppModel {
    
    var $name = 'Country';
    var $displayField = 'countryname';
    
//    var $belongsTo = array(
//        'Region' => array(
//            'className' => 'Region',
//            'foreignKey' => 'countryid'
//        )
//    );
//    
    public $hasMany = array(
        'Region' => array(
            'className' => 'Region',
            'foreignKey' => 'countryid',
            'conditions' => array(
                'Region.deletedat' => null
            ),
            'order' => 'Region.createdat DESC',
            'dependent' => true
        )
    );
}
