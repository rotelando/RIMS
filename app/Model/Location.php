<?php

class Location extends AppModel {
    
    var $name = 'Location';
    var $displayField = 'locationname';
    
     var $belongsTo = array(
        'Lga' => array(
            'className' => 'Lga',
            'foreignKey' => 'lga_id'
        )
    );

    public $hasMany = array(
        'Outlet' => array(
            'className' => 'Outlet',
            'foreignKey' => 'location_id',
            'dependent' => true
        ),
    );

    public function getLocations() {
        $options['fields'] = array(
            'Location.id',
            'Location.locationname',
            'Lga.lganame'
        );
        $options['recursive'] = 0;
        $options['order'] = array('Location.created_at');

        $locations = $this->find('all', $options);

        return $locations;
    }

    public function getLocationList() {

        $subregions = $this->find('list');
        return $subregions;
    }

    private function _getAllLocations() {
        $options['fields'] = array(
            'Location.id',
            'Location.locationname',
            'Location.lga_id',
            'Lga.lganame'
        );
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'lgas',
                'alias' => 'Lga',
                'type' => 'LEFT',
                'conditions' => array(
                    'Lga.id = Location.id'
                )
            )
        );

        $locations = $this->find('all', $options);

        return $locations;
    }

    public function getCount() {

        return $this->find('count');
    }

    public function createLocations($locations, $lgalist) {

        $locations = array_values($locations);
        $size = count($locations);
        for($i = 0; $i < $size; $i++) {

            $locations[$i]['Location']['lga_id'] = array_search($locations[$i]['Location']['lga'], $lgalist);
            $locations[$i]['Location']['created_at'] = $this->_createNowTimeStamp();
            unset($locations[$i]['Location']['lga']);
        }

        if($this->saveAll($locations)) {
            return $this->find('list');
        } else {
            return -1;
        }
    }
     
}