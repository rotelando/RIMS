<?php

class Retailtype extends AppModel {

    var $name = 'Retailtype';
    var $displayField = 'retailtypename';

    var $hasMany = array(
        'Outlet' => array(
            'className' => 'Outlet',
            'foreignKey' => 'retailtype_id'
        )
    );

    public function getRetailtypeAsList() {

        $retailtypes = $this->find('list');
        return $retailtypes;
    }

}