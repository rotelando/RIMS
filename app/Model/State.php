<?php

class State extends AppModel {
    
    var $name = 'State';
    var $displayField = 'statename';
    
    var $belongsTo = array(
        'Subregion' => array(
            'className' => 'Subregion',
            'foreignKey' => 'subregion_id'
        )
    );

    public $hasMany = array(
        'Territory' => array(
            'className' => 'Territory',
            'foreignKey' => 'state_id',
            'dependent' => true
        ),
    );
}