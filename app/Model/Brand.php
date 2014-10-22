<?php

class Brand extends AppModel {

    var $name = 'Brand';
    var $displayField = 'brandname';

    var $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'brandid',
            'dependent' => true
        ),
        'Outletmerchandize' => array(
            'className' => 'Outletmerchandize',
            'foreignKey' => 'merchandize_id',
            'dependent' => true
        )
    );

}