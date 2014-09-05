<?php

class Visibilityevaluation extends AppModel {
    
    var $name = 'Visibilityevaluation';
    
    var $belongsTo = array(
        'Visit' => array(
            'className' => 'Visit',
            'foreignKey' => 'visitid'
        ),
        'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'brandid'
        ),
        'Brandelement' => array(
            'className' => 'Brandelement',
            'foreignKey' => 'visibilityelementid'
        )
    );
}
