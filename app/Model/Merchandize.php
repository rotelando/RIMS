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


    public function getAllMerchandize() {
        //Get All Brand Elements
        $options['fields'] = array(
            'Merchandize.id',
            'Merchandize.name',
            'Merchandize.weight',
        );
        $options['order'] = array('Merchandize.id');
        $options['recursive'] = -1;

        $merchandize = $this->find('all', $options);
        return $merchandize;
    }
}
