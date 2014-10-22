<?php

class Region extends AppModel {
    
    var $name = 'Region';
    var $displayField = 'regionname';
    
    var $belongsTo = array(
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id'
        )
    );
    
   public $hasMany = array(
       'Subregion' => array(
           'className' => 'Subregion',
           'foreignKey' => 'region_id',
           'dependent' => true
       )
   );
}