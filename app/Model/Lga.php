<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 10/21/14
 * Time: 9:57 PM
 */

class Lga extends AppModel {

    var $name = 'Lga';
    var $displayField = 'lganame';

    var $belongsTo = array(
        'Territory' => array(
            'className' => 'Territory',
            'foreignKey' => 'territory_id'
        )
    );

    public $hasMany = array (
        'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'lga_id',
            'dependent' => true
        ),
    );

    public function getLgaAsList() {

        $lgas = $this->find('list');
        return $lgas;
    }

    public function getLgas() {

        $options['fields'] = array(
            'Lga.id',
            'Lga.lganame',
            'Territory.territoryname'
        );
        $options['recursive'] = 0;
        $options['order'] = array('Lga.created_at');

        $lgas = $this->find('all', $options);

        return $lgas;
    }

    public function getCount() {

        return $this->find('count');
    }

    public function createLgas($lgas, $territorylist) {

        $lgas = array_values($lgas);
        $size = count($lgas);
        for($i = 0; $i < $size; $i++) {

            $lgas[$i]['Lga']['territory_id'] = array_search($lgas[$i]['Lga']['territory'], $territorylist);
            $lgas[$i]['Lga']['created_at'] = $this->_createNowTimeStamp();
            unset($lgas[$i]['Lga']['territory']);
        }

        if($this->saveAll($lgas)) {
            return $this->find('list');
        } else {
            return -1;
        }
    }

    public function lgasByTerritories($id) {

        $new_lga = array();
        $lga = $this->find('list', array('conditions' => array('territory_id' => $id)));
        if(isset($lga)) {
            foreach ($lga as $key => $value) {
                $key = 'lga_' . $key;
                $new_lga[$key] = $value;
            }
            $outputlocation['Lgas'] = $new_lga;
        }
        return $new_lga;
    }
} 