<?php

class Product extends AppModel {
    
    var $name = 'Product';
    var $displayField = 'productname';
    
    var $belongsTo = array(
        'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'brandid'
        ),
        'Productcategory' => array(
            'className' => 'Productcategory',
            'foreignKey' => 'categoryid'
        )
    );
    
    public $hasMany = array(
        /*'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'productid',
            'conditions' => array(
                'Order.deleted_at' => null
            ),
            'order' => 'Order.created_at DESC',
            'dependent' => true
        )*/
    );
}