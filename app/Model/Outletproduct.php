<?php

class Outletproduct extends AppModel {

    var $name = 'Outletproduct';
    var $displayField = 'outletproductname';

    var $belongsTo = array(
        'Outlet' => array(
            'className' => 'Outlet',
            'foreignKey' => 'outlet_id',
        ),
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_id',
        ),
        'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'brand_id',
        )
    );

}