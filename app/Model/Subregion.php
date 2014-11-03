<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 10/21/14
 * Time: 9:57 PM
 */

class Subregion extends AppModel {

    var $name = 'Subregion';
    public $tableName = 'subregions';
    var $displayField = 'subregionname';

    var $belongsTo = array(
        'Region' => array(
            'className' => 'Region',
            'foreignKey' => 'region_id'
        )
    );

    public $hasMany = array(
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'subregion_id'
        ),
    );

    public function getSubregions() {

        $options['fields'] = array(
            'Subregion.id',
            'Subregion.subregionname',
            'Region.regionname'
        );
        $options['recursive'] = 0;
        $options['order'] = array('Subregion.created_at');

        $subregions = $this->find('all', $options);

        return $subregions;
    }

    public function getSubregionList() {

        $subregions = $this->find('list');
        return $subregions;
    }

    public function getCount() {

        return $this->find('count');
    }

    public function createSubregions($subregions, $regionlist) {

        $subregions = array_values($subregions);
        $size = count($subregions);
        for($i = 0; $i < $size; $i++) {

            $subregions[$i]['Subregion']['region_id'] = array_search($subregions[$i]['Subregion']['region'], $regionlist);
            $subregions[$i]['Subregion']['created_at'] = $this->_createNowTimeStamp();
            unset($subregions[$i]['Subregion']['region']);
        }

        if($this->saveAll($subregions)) {
            return $this->find('list');
        } else {
            return -1;
        }
    }
} 