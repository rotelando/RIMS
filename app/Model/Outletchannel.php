<?php

class Outletchannel extends AppModel {
    
    public $name = 'Outletchannel';
    public $useTable = 'outletchannels';
    public $displayField = 'outletchannelname';
    
    var $hasMany = array(
      'Outlet' => array(
          'className' => 'Outlet',
          'foreignKey' => 'outletchannel_id'
      )  
    );

    public function getChannelAsList() {

        $channels = $this->find('list');
        return $channels;
    }
}