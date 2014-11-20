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

    public function merchandizeForOutlet($id) {

        $options['fields'] = array(
            'Outletmerchandize.id',
            'Outletmerchandize.created_at',
            'Outletmerchandize.elementcount',
            'Outletmerchandize.appropriatelydeployed',
            'Brand.id',
            'Brand.brandname',
            'Merchandize.id',
            'Merchandize.name'
        );
        $options['order'] = array('Outletmerchandize.id DESC');
        $options['conditions'] = array('Outletmerchandize.outlet_id' => $id);
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'INNER',
                'conditions' => array(
                    'Outlet.id = Outletmerchandize.outlet_id'
                )
            ),
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'INNER',
                'conditions' => array(
                    'Brand.id = Outletmerchandize.brand_id'
                )
            ),
            array(
                'table' => 'merchandize',
                'alias' => 'Merchandize',
                'type' => 'INNER',
                'conditions' => array(
                    'Merchandize.id = Outletmerchandize.merchandize_id'
                )
            )
        );

        $merchandize = $this->find('all', $options);
        return $merchandize;
    }

    public function outletMerchandizeDistribution() {

        $options['fields'] = array(
            'Brand.id',
            'Brand.brandcolor',
            'Brand.brandname',
            'Merchandize.id',
            'Merchandize.name',
            'SUM(Outletmerchandize.elementcount * Merchandize.weight) as count'
        );
        $options['order'] = array('Outletmerchandize.id DESC');
        $options['recursive'] = -1;
        $options['group'] = array('Brand.id HAVING count > 0');
        $options['joins'] = array(
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'INNER',
                'conditions' => array(
                    'Brand.id = Outletmerchandize.brand_id'
                )
            ),
            array(
                'table' => 'merchandize',
                'alias' => 'Merchandize',
                'type' => 'INNER',
                'conditions' => array(
                    'Merchandize.id = Outletmerchandize.merchandize_id'
                )
            )
        );

        $outletmerchandize = $this->find('all', $options);
        return $outletmerchandize;
    }


    public function OutletMerchandizeByLocation() {

        //merchandize count by locations
        $options['fields'] = array(
            'State.internalid,
            COUNT(Outletmerchandize.elementcount * Merchandize.weight) as merchandizecount');
        $options['group'] = array('State.internalid HAVING merchandizecount > 0');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Outletmerchandize.outlet_id'
                )
            ),array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
            ),
            array(
                'table' => 'lgas',
                'alias' => 'Lga',
                'type' => 'LEFT',
                'conditions' => array(
                    'Lga.id = Location.lga_id'
                )
            ),
            array(
                'table' => 'territories',
                'alias' => 'Territory',
                'type' => 'LEFT',
                'conditions' => array(
                    'Territory.id = Lga.territory_id'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Territory.state_id'
                )
            ),
            array(
                'table' => 'merchandize',
                'alias' => 'Merchandize',
                'type' => 'LEFT',
                'conditions' => array(
                    'Merchandize.id = Outletmerchandize.merchandize_id'
                )
            )
        );
        $merchandizebylocation = $this->find('all', $options);

        return $merchandizebylocation;
        //End outlet count by locations
    }
}