<?php

class Region extends AppModel {
    
    var $name = 'Region';
    var $displayField = 'regionname';
    
    var $belongsTo = array(
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'countryid'
        )
    );
    
   public $hasMany = array(
       'State' => array(
           'className' => 'State',
           'foreignKey' => 'regionid',
           'conditions' => array(
               'State.deletedat' => null
           ),
           'order' => 'State.createdat DESC',
           'dependent' => true
       )
   );
}