<?php

class State extends AppModel {
    
    var $name = 'State';
    var $displayField = 'statename';
    
    var $belongsTo = array(
        'Subregion' => array(
            'className' => 'Subregion',
            'foreignKey' => 'subregion_id'
        )
    );

    public $hasMany = array(
        'Territory' => array(
            'className' => 'Territory',
            'foreignKey' => 'state_id',
            'dependent' => true
        ),
    );

    public function getStateAsList() {

        $states = $this->find('list');
        return $states;
    }

    public function getCount() {

        return $this->find('count');
    }

    public function createStates($states, $subregionlist) {

        App::import('Model','Prestate');
        $prestate = new Prestate();
        $states = array_values($states);
        $size = count($states);
        for($i = 0; $i < $size; $i++) {

            $state = $prestate->findByStatename($states[$i]['State']['statename']);
            if(count($state) > 0) {
                $states[$i]['State']['subregion_id'] = array_search($states[$i]['State']['subregion'], $subregionlist);
                $states[$i]['State']['shortname'] = $state['Prestate']['shortname'];
                $states[$i]['State']['internalid'] = $state['Prestate']['internalid'];
                $states[$i]['State']['created_at'] = $this->_createNowTimeStamp();
                unset($states[$i]['State']['subregion']);
            }
        }

        if($this->saveAll($states)) {
            return $this->find('list');
        } else {
            return -1;
        }
    }

    public function stateBySubregion($subregion_id) {
        $new_state = array();
        $state = $this->find('list', array('conditions' => array('subregion_id' => $subregion_id)));
        if (isset($state)) {
            foreach ($state as $key => $value) {
                $key = 'sta_' . $key;
                $new_state[$key] = $value;
            }
        }
        return $new_state;
    }
}