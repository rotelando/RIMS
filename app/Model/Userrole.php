<?php

class Userrole extends AppModel {
    
    var $name = 'Userrole';
    var $displayField = 'userrolename';
    
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'userroleid',
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
