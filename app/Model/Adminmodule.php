<?php

class Adminmodule extends AppModel {
    
    var $name = 'Adminmodule';
    var $displayField = 'adminmodulename';
    
    public $hasMany = array(
        'Rolemodule' => array(
            'className' => 'Rolemodule',
            'foreignKey' => 'adminmoduleid',
            'conditions' => array(
                'Rolemodule.deleted_at' => null
            ),
            'order' => 'Rolemodule.created_at DESC',
            'dependent' => true
        )
    );
}

