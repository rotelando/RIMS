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

    public function getAllBrands() {
        //Get All Brand List except Current Order by ProductId => Columns
        $options['fields'] = array(
            'Brand.id',
            'Brand.brandname',
            'Brand.brandcolor',
        );
        $options['order'] = array('Brand.id');
        $options['recursive'] = -1;

        $allbrands = $this->find('all', $options);
        return $allbrands;
    }

}