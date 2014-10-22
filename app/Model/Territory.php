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
} 