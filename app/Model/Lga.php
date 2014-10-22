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
} 