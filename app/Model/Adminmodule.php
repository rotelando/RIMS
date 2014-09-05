<?php

class Adminmodule extends AppModel {
    
    var $name = 'Adminmodule';
    var $displayField = 'adminmodulename';
    
    public $hasMany = array(
        'Rolemodule' => array(
            'className' => 'Rolemodule',
            'foreignKey' => 'adminmoduleid',
            'conditions' => array(
                'Rolemodule.deletedat' => null
            ),
            'order' => 'Rolemodule.createdat DESC',
            'dependent' => true
        )
    );
}

