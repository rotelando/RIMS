<?php

class Order extends AppModel {
    
    var $name = 'Order';
    
    var $belongsTo = array(
        'Visit' => array(
            'className' => 'Visit',
            'foreignKey' => 'visitid',
        ),
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'productid',
        ),
        'Orderstatus' => array(
            'className' => 'Orderstatus',
            'foreignKey' => 'orderstatusid',
        )
    );
}
