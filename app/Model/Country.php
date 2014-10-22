<?php

class Country extends AppModel {
    
    var $name = 'Country';
    var $displayField = 'countryname';

    public $hasMany = array(
        'Region' => array(
            'className' => 'Region',
            'foreignKey' => 'countryid',
            'conditions' => array(
                'Region.deleted_at' => null
            ),
            'order' => 'Region.created_at DESC',
            'dependent' => true
        )
    );
}
