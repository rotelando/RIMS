<?php

class Outletmerchandize extends AppModel {

    var $name = 'Outletmerchandize';
    var $useTable = 'outletmerchandize';
    var $displayField = 'outletmerchandizename';

    var $belongsTo = array(
        'Outlet' => array(
            'className' => 'Outlet',
            'foreignKey' => 'outlet_id',
        ),
        'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'brand_id',
        ),
        'Merchandize' => array(
            'className' => 'Merchandize',
            'foreignKey' => 'merchandize_id',
        )
    );
}