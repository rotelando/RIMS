<?php

class Userrole extends AppModel {
    
    var $name = 'Userrole';
    var $displayField = 'userrolename';
    
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'userroleid',
            'conditions' => array(
                'User.deletedat' => null
            ),
            'order' => 'User.createdat DESC',
            'dependent' => true
        )
    );
    
    public $belongsTo = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'brandid'
        )
    );
}
