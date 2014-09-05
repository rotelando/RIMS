<?php

class Outletchannel extends AppModel {
    
    var $name = 'Outletchannel';
    var $displayField = 'outletchannelname';
    
    var $hasMany = array(
      'Outlet' => array(
          'className' => 'Outlet',
          'foreignKey' => 'outletchannelid'
      )  
    );
}