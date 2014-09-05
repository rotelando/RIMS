
<?php

class Orderstatus extends AppModel {
    
    var $name = 'Orderstatus';
    
    var $hasMany = array(
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'orderstatusid'
        )
    );
}