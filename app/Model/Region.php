<?php

class Region extends AppModel {
    
    var $name = 'Region';
    var $displayField = 'regionname';
    
    var $belongsTo = array(
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id'
        )
    );
    
   public $hasMany = array(
       'Subregion' => array(
           'className' => 'Subregion',
           'foreignKey' => 'region_id',
           'dependent' => true
       )
   );

    public function getRegions() {

        $options['fields'] = array(
            'Region.id',
            'Region.regionname',
            'Country.countryname'
        );
        $options['recursive'] = 0;
        $options['order'] = array('Region.created_at');

        $regions = $this->find('all', $options);

        return $regions;
    }

    public function getRegionList() {

        $regions = $this->find('list');
        return $regions;
    }

    public function getCount() {

        return $this->find('count');
    }

    public function createRegions($regions) {

        $regions = array_values($regions);
        $size = count($regions);
        for($i = 0; $i < $size; $i++) {
            $regions[$i]['Region']['created_at'] = $this->_createNowTimeStamp();
        }

        if ($this->saveAll($regions)) {
            return $this->find('list');
        } else {
            return -1;
        }
    }
}