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

    public function outletMerchandizeDistribution($options = null) {

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
        //move the joins to the beginning of the array to allow proper flow
        array_unshift($options['joins'], array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'INNER',
                'conditions' => array(
                    'Brand.id = Outletmerchandize.brand_id'
                )
            )
        );
        array_unshift($options['joins'], array(
                'table' => 'merchandize',
                'alias' => 'Merchandize',
                'type' => 'INNER',
                'conditions' => array(
                    'Merchandize.id = Outletmerchandize.merchandize_id'
                )
            )
        );
        array_unshift($options['joins'], array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Outletmerchandize.outlet_id'
                )
            )
        );

        $outletmerchandize = $this->find('all', $options);
        return $outletmerchandize;
    }


    public function OutletMerchandizeByLocation($options = null) {

        //merchandize count by locations
        $options['fields'] = array(
            'State.internalid,
            COUNT(Outletmerchandize.elementcount * Merchandize.weight) as merchandizecount');
        $options['group'] = array('State.internalid HAVING merchandizecount > 0');
        $options['recursive'] = -1;
        //move the joins to the beginning of the array to allow proper flow
        array_unshift($options['joins'], array(
                'table' => 'merchandize',
                'alias' => 'Merchandize',
                'type' => 'LEFT',
                'conditions' => array(
                    'Merchandize.id = Outletmerchandize.merchandize_id'
                ))
        );
        array_unshift($options['joins'], array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Outletmerchandize.outlet_id'
                )
            )
        );

        $merchandizebylocation = $this->find('all', $options);

        return $merchandizebylocation;
        //End outlet count by locations
    }

    public function OutletMerchandizeBrandShares($options = null) {

        $options['fields'] = array(
            'Brand.brandname',
            'Brand.brandcolor',
            'Outletmerchandize.brand_id',
            'SUM(Outletmerchandize.elementcount * Merchandize.weight) as elementvalue'
        );
        $options['group'] = array('Outletmerchandize.brand_id');
        $options['recursive'] = -1;
        array_unshift($options['joins'], array(
            'table' => 'brands',
            'alias' => 'Brand',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.brand_id = Brand.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'merchandize',
            'alias' => 'Merchandize',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.merchandize_id = Merchandize.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'LEFT',
            'conditions' => array(
                'Outlet.id = Outletmerchandize.outlet_id'
            )
        ));

        $result = $this->find('all', $options);
        return $result;
    }

    public function topTenOutletMerchandize($options = null, $limit) {

        $options['fields'] = array(
            'Brand.brandname',
            'Merchandize.name',
            'Merchandize.weight',
            'Outletmerchandize.brand_id',
            'SUM(Outletmerchandize.elementcount) as elementcount',
            'SUM(Outletmerchandize.elementcount * Merchandize.weight) as weightedvalue'
        );
        $options['group'] = array('Outletmerchandize.brand_id, Merchandize.id');
        $options['recursive'] = -1;
        $options['limit'] = $limit;
        $options['order'] = array('weightedvalue' => 'DESC');
        array_unshift($options['joins'], array(
            'table' => 'brands',
            'alias' => 'Brand',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.brand_id = Brand.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'merchandize',
            'alias' => 'Merchandize',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.merchandize_id = Merchandize.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'LEFT',
            'conditions' => array(
                'Outlet.id = Outletmerchandize.outlet_id'
            )
        ));

        $result = $this->find('all', $options);
        return $result;
    }

    public function merchandizePerformance($options = null) {

        $options['fields'] = array(
            'Brand.brandname',
            'Brand.brandcolor',
            'Merchandize.name',
            // 'ISNULL(SUM(Outletmerchandize.elementcount), 0) AS count'
            'SUM(Outletmerchandize.elementcount * Merchandize.weight) as count'
        );
        $options['group'] = array('Outletmerchandize.brand_id', 'Outletmerchandize.merchandize_id');
        $options['recursive'] = -1;
        array_unshift($options['joins'], array(
            'table' => 'brands',
            'alias' => 'Brand',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.brand_id = Brand.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'merchandize',
            'alias' => 'Merchandize',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.merchandize_id = Merchandize.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'LEFT',
            'conditions' => array(
                'Outlet.id = Outletmerchandize.outlet_id'
            )
        ));

        $result = $this->find('all', $options);
        return $result;
    }

    public function getMerchandizeCountByBrand($options = null) {

        $options['fields'] = array(
            'Brand.id',
            'Brand.brandname',
            'Merchandize.id',
            'Merchandize.name',
            'Merchandize.weight',
            'Outletmerchandize.id',
            'SUM(Outletmerchandize.elementcount) AS totalquantity'
        );
        $options['recursive'] = -1;
        $options['order'] = array('Outletmerchandize.merchandize_id');
        $options['group'] = array('Outletmerchandize.merchandize_id, Outletmerchandize.brand_id');
        array_unshift($options['joins'], array(
            'table' => 'brands',
            'alias' => 'Brand',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.brand_id = Brand.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'merchandize',
            'alias' => 'Merchandize',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.merchandize_id = Merchandize.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'LEFT',
            'conditions' => array(
                'Outlet.id = Outletmerchandize.outlet_id'
            )
        ));

        $result = $this->find('all', $options);
        return $result;
    }

    public function getMerchandizeCountByLocation($options = null) {

        $options['fields'] = array(
            'Merchandize.name',
            'Brand.brandname',
            'Brand.brandcolor',
            'Outletmerchandize.brand_id',
            'State.internalid',
            'State.statename',
            // . 'SUM(Outletmerchandize.elementcount * Brandelement.weight) as elementvalue'
            'SUM(Outletmerchandize.elementcount) as elementvalue'
        );
        $options['group'] = array('State.internalid', 'Brand.id');
        $options['order'] = array('State.internalid', 'elementvalue DESC');
        $options['recursive'] = -1;
        array_unshift($options['joins'], array(
            'table' => 'brands',
            'alias' => 'Brand',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.brand_id = Brand.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'merchandize',
            'alias' => 'Merchandize',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.merchandize_id = Merchandize.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'LEFT',
            'conditions' => array(
                'Outlet.id = Outletmerchandize.outlet_id'
            )
        ));

        $merchandizebylocation = $this->find('all', $options);
        return $merchandizebylocation;
    }

    public function getMapInfo($state_internalid) {

        $options['joins'] = array();

        $options['fields'] = array(
            'Merchandize.name',
            'Brand.brandname',
            'Brand.brandcolor',
            'Outletmerchandize.brand_id',
            'State.internalid',
            'State.statename',
            'SUM(Outletmerchandize.elementcount) as elementvalue'
        );
        $options['conditions']['State.internalid'] = $state_internalid;
        $options['group'] = array('State.internalid', 'Brand.id', 'Merchandize.id');
        $options['order'] = array('Merchandize.id', 'elementvalue DESC');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.brand_id = Brand.id'
                )
            ),
            array(
                'table' => 'merchandize',
                'alias' => 'Merchandize',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletmerchandize.merchandize_id = Merchandize.id'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Outletmerchandize.outlet_id'
                )
            ),
            array(
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
                'table' => 'subregions',
                'alias' => 'Subregion',
                'type' => 'LEFT',
                'conditions' => array(
                    'Subregion.id = State.subregion_id'
                )
            ),
            array(
                'table' => 'regions',
                'alias' => 'Region',
                'type' => 'LEFT',
                'conditions' => array(
                    'Region.id = Subregion.region_id'
                )
            )
        );

        $mapinfo = $this->find('all', $options);
        return $mapinfo;
    }

    public function getShareByMerchandize($options = null) {

        $options['fields'] = array(
            'Merchandize.name',
            'Merchandize.id',
            'Brand.brandname',
            'Brand.brandcolor',
            'Outletmerchandize.brand_id',
            'SUM(Outletmerchandize.elementcount * Merchandize.weight) as elementvalue'
        );
        $options['group'] = array('Merchandize.id', 'Outletmerchandize.brand_id');
        $options['recursive'] = -1;
        array_unshift($options['joins'], array(
            'table' => 'brands',
            'alias' => 'Brand',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.brand_id = Brand.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'merchandize',
            'alias' => 'Merchandize',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.merchandize_id = Merchandize.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'LEFT',
            'conditions' => array(
                'Outlet.id = Outletmerchandize.outlet_id'
            )
        ));

        $merchandizeshare = $this->find('all', $options);
        return $merchandizeshare;
    }


    public function leastVisibilityTerritories($options = null, $number = 3) {

        $options['fields'] = array(
            'Territory.id',
            'Territory.territoryname',
            'COUNT(Territory.id) as count',
            'SUM(Outletmerchandize.elementcount * Merchandize.weight) as weightedcount');
        $options['group'] = array('Territory.id HAVING count > 0');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['order'] = array('weightedcount ASC');
        array_unshift($options['joins'], array(
            'table' => 'merchandize',
            'alias' => 'Merchandize',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.merchandize_id = Merchandize.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'LEFT',
            'conditions' => array(
                'Outlet.id = Outletmerchandize.outlet_id'
            )
        ));

        $result = $this->find('all', $options);

        return $result;
    }

    public function mostVisibilityTerritories($options = null, $number = 3) {

        $options['fields'] = array(
            'Territory.id',
            'Territory.territoryname',
            'COUNT(Territory.id) as count',
            'SUM(Outletmerchandize.elementcount * Merchandize.weight) as weightedcount');
        $options['group'] = array('Territory.id HAVING count > 0');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['order'] = array('weightedcount DESC');
        array_unshift($options['joins'], array(
            'table' => 'merchandize',
            'alias' => 'Merchandize',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletmerchandize.merchandize_id = Merchandize.id'
            )
        ));
        array_unshift($options['joins'], array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'LEFT',
            'conditions' => array(
                'Outlet.id = Outletmerchandize.outlet_id'
            )
        ));

        $result = $this->find('all', $options);

        return $result;
    }

    public function countMerchandize($options = null) {

        array_unshift($options['joins'], array(
            'table' => 'outlets',
            'alias' => 'Outlet',
            'type' => 'LEFT',
            'conditions' => array(
                'Outlet.id = Outletmerchandize.outlet_id'
            )
        ));

        return $this->find('count', $options);
    }
}