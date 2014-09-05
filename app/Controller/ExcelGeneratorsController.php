<?php

class ExcelGeneratorsController extends AppController {
    
    public $uses = array('User', 'Visibilityevaluation', 'Outlet', 'Visit', 'Brandelement', 'Visit', 'Image', 'State', 'Location');
    public $components = array('PhpExcel');
    public $helpers = array('PhpExcel');
    
    // public function beforeFilter() {
    //     parent::beforeFilter();
    //     $this->_setViewVariables();
    // }
    
    public function index() {
        // create new empty worksheet and set default font
        $this->PhpExcel->createWorksheet()
            ->setDefaultFont('Calibri', 12);

        // define table cells
        $table = array(
            array('label' => __('Outlet ID')),
            array('label' => __('Outlet Name')),
            array('label' => __('Visibility Element')),
            // array('label' => __('Element Count'), 'width' => 50, 'wrap' => true),
            array('label' => __('Element Count'), 'wrap' => true),
            array('label' => __('Field Agent')),
            array('label' => __('State')),
            array('label' => __('Location')),
            array('label' => __('Images'))
        );

        $options['fields'] = array(
            "Outlet.id",
            "Outlet.outletname",
            "Brandelement.brandelementname",
            "Visibilityevaluation.elementcount",
            "Image.id",
            "Image.filename",
            "Visit.id",
            "User.firstname",
            "User.lastname",
            "State.statename",
            "Location.locationname"
        );
        // $options['limit'] = 2000;
        $options['recursive'] = -1;
        $options['Order'] = array('Outlet.outletname');
        $options['joins'] = array(
            array(
                'table' => 'brandelements',
                'alias' => 'Brandelement',
                'type' => 'LEFT',
                'conditions' => array(
                    'Brandelement.id = Visibilityevaluation.visibilityelementid'
                )
            ),
            array(
                'table' => 'visits',
                'alias' => 'Visit',
                'type' => 'LEFT',
                'conditions' => array(
                    'Visit.id = Visibilityevaluation.visitid'
                )
            ),
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Visit.outletid'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'User.id = Outlet.userid'
                )
            ),
            array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.locationid'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            ),
            array(
                'table' => 'images',
                'alias' => 'Image',
                'type' => 'LEFT',
                'conditions' => array(
                    'Image.visitid = Visit.id'
                )
            )
        );
        
        $options['conditions']['State.id'] = 2;

        $data = $this->Visibilityevaluation->find('all', $options);


        // add heading with different font and bold text
        $this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));



        debug($data);

        $belement = $this->Brandelement->find('all');
        $visTable = array();
        $visTable[0]["Outlet"] = array();
        foreach ($belement as $key => $value) {
            $visTable[0][$value["Brandelement"]["brandelementname"]] = array();
        }

        $brands = $this->Brand->find("all");
        
        
        foreach ($data as $value) {
            $outletid = $value["Outlet"]["id"];
            $visTable[[$outletid]["Outletname"]] = $value["Outlet"]["outletname"];
        }
        // add data
        // foreach ($data as $d) {
        //     $this->PhpExcel->addTableRow(array(
        //         $d['Outlet']['id'],
        //         $d['Outlet']['outletname'],
        //         $d['Brandelement']['brandelementname'],
        //         $d['Visibilityevaluation']['elementcount'],
        //         $d['User']['firstname'] . ' ' . $d['User']['firstname'],
        //         $d['State']['statename'],
        //         $d['Location']['locationname'],
        //         'http://papyrusapi.alexanderharing.com/files/images/'. $d['Image']['filename']
        //     ));
        // }

        // close table and output
        // $this->PhpExcel->addTableFooter()
        //     ->output();
    }
}