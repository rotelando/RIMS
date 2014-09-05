<?php

class Productcategory extends AppModel {
    
    //Model field variables
    var $name = 'Productcategory';
    var $displayField = 'productcategoryname';
    
    //Validation rule
    var $validate = array(
        'productcategoryname' => array(
            'Not Empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Category name cannot be empty'
            )
        )
    );
    
    //Relationship or Association

    var $hasMany = array (
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'categoryid',
            'conditions' => array(
                'Product.deletedat' => null
            ),
            'order' => 'Product.createdat DESC',
            'dependent' => true
        )
    );

}