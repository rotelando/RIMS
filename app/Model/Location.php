<?php

class Location extends AppModel {
    
    var $name = 'Location';
    var $displayField = 'locationname';
    
     var $belongsTo = array(
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'stateid'
        )
    );
     
}