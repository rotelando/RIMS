<?php

class Productsource extends AppModel {

    var $name = 'Productsource';
    var $displayField = 'productsourcename';

    var $belongsTo = array(
        'Outlet' => array(
            'className' => 'Outlet',
            'foreignKey' => 'outlet_id',
        )
    );

}