<?php

class Outlet extends AppModel {
    
    var $name = 'Outlet';
    var $displayField = 'outletname';
    
    var $belongsTo = array(
        'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'location_id',
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        ),
        'Outletclass' => array(
            'className' => 'Outletclass',
            'foreignKey' => 'outletclass_id',
        ),
        'Outletchannel' => array(
            'className' => 'Outletchannel',
        ),
        'Retailtype' => array(
            'className' => 'Retailtype',
            'foreignKey' => 'retailtype_id',
        )
    );
    
    public $hasMany = array(
        'Outletmerchandize' => array(
            'className' => 'Outletmerchandize',
            'foreignKey' => 'outlet_id',
            'dependent' => true
        ),
        'Productsource' => array(
            'className' => 'Productsource',
            'foreignKey' => 'outlet_id',
            'dependent' => true
        ),
        'Outletproduct' => array(
            'className' => 'Outletproduct',
            'foreignKey' => 'outlet_id',
            'dependent' => true
        ),
        'Outletimage' => array(
            'className' => 'Outletimage',
            'foreignKey' => 'outlet_id',
            'dependent' => true
        )
    );

    public function countOutlet($options = null) {

        return $this->find('count', $options);
    }

    public function leastCrowdedLocations($options = null, $number = 3) {

        $options['fields'] = array('Territory.id', 'Territory.territoryname', 'COUNT(Territory.id) as count');
        $options['group'] = array('Territory.id HAVING count > 0');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['order'] = array('count asc');

        $result = $this->find('all', $options);

        return $result;
    }

    public function mostCrowdedLocations($options = null, $number = 3) {

        $options['fields'] = array('Territory.id', 'Territory.territoryname', 'COUNT(Territory.id) as count');
        $options['group'] = array('Territory.id HAVING count > 0');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['order'] = array('count desc');

        $result = $this->find('all', $options);

        return $result;
    }

    public function getRecentOutlets($number = null, $options = null) {

        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Outlet.contactfirstname',
            'Outlet.contactlastname',
            'Outlet.contactphonenumber',
            'Outlet.phonenumber',
            'Retailtype.retailtypename',
            'Location.locationname',
            'CONCAT(User.firstname, " ",User.lastname) as fullname'
        );
        $options['order'] = array('Outlet.id DESC');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['joins'][] = array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.user_id'
                )
            );
        $options['joins'][] = array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Retailtype.id = Outlet.retailtype_id'
                )
            );

        $outlets = $this->find('all', $options);

        return $outlets;
        // debug($outlets);

    }

    public function outletClassDistribution($options = null) {

        $options['fields'] = array(
            'Outletclass.outletclassname',
            'Outletclass.id',
            'Count(Outlet.outletclass_id) as count'
        );
        $options['group'] = array('outletclass_id HAVING count > 0');
        $options['recursive'] = -1;
        $options['joins'][] = array(
                'table' => 'outletclasses',
                'alias' => 'Outletclass',
                'type' => 'INNER',
                'conditions' => array(
                    'Outlet.outletclass_id = Outletclass.id'
                )
            );

        $result = $this->find('all', $options);
        return $result;
    }

    public function outletChannelDistribution($options = null) {

        $options['fields'] = array(
            'Outletchannel.outletchannelname',
            'Outletchannel.id',
            'Count(Outlet.outletchannel_id) as count'
        );
        $options['group'] = array('outletchannel_id HAVING count > 0');
        $options['recursive'] = -1;
        $options['joins'][] = array(
                'table' => 'outletchannels',
                'alias' => 'Outletchannel',
                'type' => 'INNER',
                'conditions' => array(
                    'Outlet.outletchannel_id = Outletchannel.id'
                )
            );

        $result = $this->find('all', $options);
        return $result;
    }

    public function retailTypeDistribution($options = null) {

        $options['fields'] = array(
            'Retailtype.retailtypename',
            'Retailtype.id',
            'Count(Outlet.retailtype_id) as count'
        );
        $options['group'] = array('retailtype_id HAVING count > 0');
        $options['recursive'] = -1;
        $options['joins'][] = array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.retailtype_id = Retailtype.id'
                )
            );

        $result = $this->find('all', $options);
        return $result;
    }

    public function outletTypeDistribution($options = null) {

        $options['fields'] = array(
            'Outletclass.outletclassname',
            'Outletclass.id',
            'Count(Outlet.outletclass_id) as count'
        );
        $options['group'] = array('outletclass_id HAVING count > 0');
        $options['recursive'] = -1;
        $options['joins'][] = array(
                'table' => 'outletclasses',
                'alias' => 'Outletclass',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.outletclass_id = Outletclass.id'
                )
            );

        $result = $this->find('all', $options);
        return $result;
    }

    public function performanceTrend($options = null) {

        /*if(!is_null($options)) {
            if (!isset($options['conditions']["DATE_FORMAT( {modelClass}.created_at,  '%Y-%m-%d' ) <="])) {
                //Use last 2 weeks as default date range for the performance graph
                $today = date('Y-m-d');
                $lastweek = strtotime("-2 weeks");
                $lastweekdate = date('Y-m-d', $lastweek);
                $options['conditions']["DATE_FORMAT( {}.created_at,  '%Y-%m-%d' ) <="] = $today;
                $options['conditions']["DATE_FORMAT( {}.created_at,  '%Y-%m-%d' ) >="] = $lastweekdate;
            }
        }*/

        $options['fields'] = array('Outlet.created_at', 'COUNT(Outlet.created_at) as count');
        $options['recursive'] = -1;
        $options['group'] = array("DATE_FORMAT( Outlet.created_at,  '%Y-%m-%d' )");

        $result = $this->find('all', $options);

        return $result;
    }

    public function outletGeolocations($options = null) {

        $options['fields'] = array('Outlet.geolocation', 'Outlet.outletname');
        $options['recursive'] = -1;
        $locations = $this->find('all', $options);
        return $locations;
    }

    public function outletDetails($id) {

        $options['fields'] = array(
            'Outlet.*',
            'Retailtype.retailtypename',
            'Outletclass.outletclassname',
            'Location.locationname',
            'User.firstname',
            'User.lastname'
        );
        $options['conditions'] = array('Outlet.id' => $id);
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outletclasses',
                'alias' => 'Outletclass',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletclass.id = Outlet.outletclass_id'
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
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Retailtype.id = Outlet.retailtype_id'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.user_id'
                )
            )
        );

        $outlets = $this->find('first', $options);

        return $outlets;

    }

    public function getOutletCountByLocation($options) {
        //outlet count by locations
        $options['fields'] = array('State.internalid, COUNT(State.internalid) as outletcount');
        $options['group'] = array('State.internalid HAVING outletcount > 0');
        $options['recursive'] = -1;

        $outletbylocation = $this->find('all', $options);

        return $outletbylocation;
        //End outlet count by locations
    }


    public function getPaginatedOutlets($paginator, $options = null, $count = false) {

        $options['fields'] = array(
            'Outlet.*',
            'User.id',
            'User.username',
            'Location.id',
            'Location.locationname',
            'Outletclass.id',
            'Outletclass.outletclassname',
            'Retailtype.id',
            'Retailtype.retailtypename'
        );
        $options['joins'][] = array(
                'table' => 'outletclasses',
                'alias' => 'Outletclass',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outletclass.id = Outlet.outletclass_id'
                )
            );
        $options['joins'][] = array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Retailtype.id = Outlet.retailtype_id'
                )
            );
        $options['joins'][] = array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.user_id'
                )
            );

        $paginator->settings = $options;

        if($count) {
            $paginatedOutlets = $this->find('count', $options);
        } else {
            $paginatedOutlets = $paginator->paginate('Outlet');
        }
        return $paginatedOutlets;
    }

    public function getPaginatedPhonenumbers($paginator, $options = null, $count = false) {

        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Outlet.contactphonenumber',
            'Outlet.contactalternatenumber',
            'Outlet.vtunumber'
        );
        $options['joins'][] = array(
            'table' => 'outletclasses',
            'alias' => 'Outletclass',
            'type' => 'LEFT',
            'conditions' => array(
                'Outletclass.id = Outlet.outletclass_id'
            )
        );
        $options['joins'][] = array(
            'table' => 'retailtypes',
            'alias' => 'Retailtype',
            'type' => 'LEFT',
            'conditions' => array(
                'Retailtype.id = Outlet.retailtype_id'
            )
        );
        $options['joins'][] = array(
            'table' => 'users',
            'alias' => 'User',
            'type' => 'LEFT',
            'conditions' => array(
                'User.id = Outlet.user_id'
            )
        );

        //$options['conditions']['NOT'] = array('Outlet.contactphonenumber' => null, 'contactalternatenumber' => null, 'vtunumber' => null);

        $paginator->settings = $options;

        if($count) {
            $paginatedOutlets = $this->find('count', $options);
        } else {
            $paginatedOutlets = $paginator->paginate('Outlet');
        }
        return $paginatedOutlets;
    }

    public function getVTUShare($options = null) {

        $options['recursive'] = -1;
        $outletCount = $this->countOutlet($options);

        $options['conditions']['NOT'] = array('Outlet.vtunumber' => null);
        $vtu = $this->find('count', $options);

        $nonVtu = $outletCount - $vtu;
        return array('VTU Service' => $vtu, 'Non VTU Service' => $nonVtu);
    }

    public function getProductSourceShare($options = null) {

        $options['recursive'] = -1;
        $outletCount = $this->countOutlet($options);

        $options['joins'][] = array(
            'table' => 'productsources',
            'alias' => 'Productsource',
            'type' => 'RIGHT',
            'conditions' => array(
                'Outlet.id = Productsource.outlet_id'
            )
        );

        $options['group'] = array('Productsource.outlet_id');
        //$options['conditions']['NOT'] = array('Outlet.vtunumber' => null);
        $ps = $this->find('count', $options);

        $nonps = $outletCount - $ps;
        return array('Product Source' => $ps, 'Non Product Source' => $nonps);
    }

    public function getRetailClassBySubregion($options = null) {

        $options['fields'] = array(
            'Subregion.subregionname',
            'Subregion.id',
            'Retailtype.retailtypename',
            'Retailtype.id',
            'COUNT(Retailtype.id) as retailcount'
        );

        $options['group'] = array(
            'Subregion.id',
            'Retailtype.id HAVING retailcount > 0 AND COUNT(Subregion.id) > 0'
        );
        $options['recursive'] = -1;
        $options['joins'][] = array(
            'table' => 'retailtypes',
            'alias' => 'Retailtype',
            'type' => 'LEFT',
            'conditions' => array(
                'Retailtype.id = Outlet.retailtype_id'
            )
        );

        $retailsubregion = $this->find('all', $options);
        return $retailsubregion;
    }

}