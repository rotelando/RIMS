<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 10/21/14
 * Time: 9:57 PM
 */

class Territory extends AppModel {

    var $name = 'Territory';
    var $displayField = 'territoryname';

    var $belongsTo = array(
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id'
        )
    );

    public $hasMany = array(
        'Lga' => array(
            'className' => 'Lga',
            'foreignKey' => 'territory_id',
            'dependent' => true
        ),
    );

    public function getTerritoryAsList() {

        $territories = $this->find('list');
        return $territories;
    }

    public function getTerritories() {

        $options['fields'] = array(
            'Territory.id',
            'Territory.territoryname',
            'State.statename'
        );
        $options['recursive'] = 0;
        $options['order'] = array('Territory.created_at');

        $lgas = $this->find('all', $options);

        return $lgas;
    }

    public function getCount() {

        return $this->find('count');
    }

    public function createTerritories($territories, $statelist) {

        $territories = array_values($territories);
        $size = count($territories);
        for($i = 0; $i < $size; $i++) {

            $territories[$i]['Territory']['state_id'] = array_search($territories[$i]['Territory']['state'], $statelist);
            $territories[$i]['Territory']['created_at'] = $this->_createNowTimeStamp();
            unset($territories[$i]['Territory']['state']);
        }

        if($this->saveAll($territories)) {
            return $this->find('list');
        } else {
            return -1;
        }
    }
} 