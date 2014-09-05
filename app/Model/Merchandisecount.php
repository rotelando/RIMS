<?php

class Merchandisecount extends AppModel {
    
    var $name = 'Merchandisecount';
    
    var $belongsTo = array(
        'Visit' => array(
            'className' => 'Visit',
            'foreignKey' => 'visitid'
        ),
        'Brandelement' => array(
            'className' => 'Brandelement',
            'foreignKey' => 'visibilityelementid'
        )
    );
}
