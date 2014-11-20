<?php

class Merchandize extends AppModel {

    public $name = 'Merchandize';
    public $useTable = 'merchandize';
    public $displayField = 'name';
    public $validate = array(
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
