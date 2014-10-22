<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 10/21/14
 * Time: 9:57 PM
 */

class Subregion extends AppModel {

    var $name = 'Subregion';
    var $displayField = 'territoryname';

    var $belongsTo = array(
        'Region' => array(
            'className' => 'Region',
            'foreignKey' => 'region_id'
        )
    );

    public $hasMany = array(
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'subregion_id',
            'dependent' => true
        ),
    );
} 