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
        $options['group'] = array('Territory.id');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['order'] = array('count asc');
        $options['joins'] = array(
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'INNER',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
            ),
            array(
                'table' => 'lgas',
                'alias' => 'Lga',
                'type' => 'INNER',
                'conditions' => array(
                    'Location.lga_id = Lga.id'
                )
            ),
            array(
                'table' => 'territories',
                'alias' => 'Territory',
                'type' => 'INNER',
                'conditions' => array(
                    'Lga.territory_id = Territory.id'
                )
            )
        );

        $result = $this->find('all', $options);

        return $result;
    }

    public function mostCrowdedLocations($options = null, $number = 3) {

        $options['fields'] = array('Territory.id', 'Territory.territoryname', 'COUNT(Territory.id) as count');
        $options['group'] = array('Territory.id');
        $options['limit'] = $number;
        $options['recursive'] = -1;
        $options['order'] = array('count desc');
        $options['joins'] = array(
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'INNER',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
            ),
            array(
                'table' => 'lgas',
                'alias' => 'Lga',
                'type' => 'INNER',
                'conditions' => array(
                    'Location.lga_id = Lga.id'
                )
            ),
            array(
                'table' => 'territories',
                'alias' => 'Territory',
                'type' => 'INNER',
                'conditions' => array(
                    'Lga.territory_id = Territory.id'
                )
            )
        );

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
        $options['joins'] = array(
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.user_id'
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
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
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
        $options['group'] = array('outletclass_id');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outletclasses',
                'alias' => 'Outletclass',
                'type' => 'INNER',
                'conditions' => array(
                    'Outlet.outletclass_id = Outletclass.id'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'INNER',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
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
        $options['group'] = array('outletchannel_id');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outletchannels',
                'alias' => 'Outletchannel',
                'type' => 'INNER',
                'conditions' => array(
                    'Outlet.outletchannel_id = Outletchannel.id'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'INNER',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
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
        $options['group'] = array('retailtype_id');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.retailtype_id = Retailtype.id'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
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
        $options['joins'] = array(
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
            )
        );

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
                'type' => 'INNER',
                'conditions' => array(
                    'Outletclass.id = Outlet.outletclass_id'
                )
            ),
            array(
                'table' => 'retailtypes',
                'alias' => 'Retailtype',
                'type' => 'INNER',
                'conditions' => array(
                    'Retailtype.id = Outlet.retailtype_id'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'INNER',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'INNER',
                'conditions' => array(
                    'User.id = Outlet.user_id'
                )
            )
        );

        $outlets = $this->find('first', $options);

        return $outlets;

    }

    public function getOutletCountByLocation() {
        //outlet count by locations
        $options['fields'] = array('State.internalid, COUNT(State.internalid) as outletcount');
        $options['group'] = array('State.internalid HAVING outletcount > 0');
        $options['recursive'] = -1;
        $options['joins'] = array(
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
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.user_id'
                )
            )
        );
        $outletbylocation = $this->find('all', $options);

        return $outletbylocation;
        //End outlet count by locations
    }

}