<?php

class Merchandize extends AppModel {

    var $name = 'Merchandize';
    var $displayField = 'merchandizename';
    var $validate = array(
        'merchandizename' => array(
            'Must be unique' => array(
                'rule' => 'isUnique',
                'message' => 'Merchandize already exist'
            )
        )
    );

    public $hasMany = array(
        'Outletmerchandize' => array(
            'className' => 'Outletmerchandize',
            'foreignKey' => 'merchandize_id',
            'dependent' => true
        )
    );
}
