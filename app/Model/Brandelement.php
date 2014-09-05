<?php

class Brandelement extends AppModel {

    var $name = 'Brandelement';
    var $displayField = 'brandelementname';
    var $validate = array(
        'brandelementname' => array(
            'Must be unique' => array(
                'rule' => 'isUnique',
                'message' => 'Element name already exist'
            )
        )
    );
    
    var $hasMany = array(
      'Visibilityevaluation' => array(
          'className' => 'Visibilityevaluation',
          'foreignKey' => 'visibilityelementid'
      )  
    );
}
