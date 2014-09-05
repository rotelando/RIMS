<?php

class Rolemodule extends AppModel {
    
    var $name = 'Rolemodule';
    
    public $belongsTo = array(
        'Adminmodule' => array(
            'className' => 'Adminmodule',
            'foreignKey' => 'adminmoduleid',
        ),
        'Userrole' => array(
            'className' => 'Userrole',
            'foreignKey' => 'userroleid',
        )
    );
}