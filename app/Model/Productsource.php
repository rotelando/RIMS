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

    public function productsourcesForOutlet($id) {

        $options['fields'] = array(
            'Productsource.id',
            'Productsource.productsourcename',
            'Productsource.phonenumber',
            'Productsource.alternatenumber',
            'Productsource.created_at'
        );
        $options['order'] = array('Productsource.id DESC');
        $options['conditions'] = array('Productsource.outlet_id' => $id);
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'INNER',
                'conditions' => array(
                    'Outlet.id = Productsource.outlet_id'
                )
            )
        );

        $productsources = $this->find('all', $options);
        return $productsources;
    }

    public function productsourceShare($options = null, $outletcount) {

        $options['recursive'] = -1;
        $options['joins'][] = array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'RIGHT',
            'conditions' => array(
                'Outlet.id = Productsource.outlet_id'
            )
        );

        $options['group'] = array('Productsource.outlet_id');
        //$options['conditions']['NOT'] = array('Outlet.vtunumber' => null);
        $ps = $this->find('count', $options);

        $nonps = $outletcount - $ps;
        return array('Product Source' => $ps, 'Non Product Source' => $nonps);
    }
}