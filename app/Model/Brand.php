<?php

class Brand extends AppModel {

    var $name = 'Brand';
    var $displayField = 'brandname';
//    var $validate = array(
//        'brandname' => array(
//            'Not Empty' => 'notEmpty',
//            'message' => 'Brand name cannot be empty'
//        )
//    );

    var $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'brandid',
            'conditions' => array(
                'Product.deletedat' => null
            ),
            'order' => 'Product.createdat DESC',
            'dependent' => true
        ),
        'Visibilityevaluation' => array(
            'className' => 'Visibilityevaluation',
            'foreignKey' => 'brandid'
        )
    );

}