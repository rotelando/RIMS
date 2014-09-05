<?php

class FieldstaffsController extends AppController {

    public $name = 'Fieldstaffs';
    var $uses = array('User', 'Userrole', 'Outlet', 'Visit', 'Schedule', 'Order');

    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedFieldStaffsModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setSidebarActiveItem('fieldstaffs');
    }

    public function index() {

        $this->_sendUserrole();
        $this->_setTitleOfPage('User Management');
        $this->_fieldreps();
    }

    private function _fieldreps() {
        $currentUserSettings = $this->setCurrentUserSettings();
        $fieldrepid = $currentUserSettings['Setting']['fieldrepid'];
        $fieldreps = $this->User->find('all', array('conditions' => array('userroleid' => $fieldrepid)));
        $this->set(array('fieldreps' => $fieldreps));
    }

    public function compare() {

        $this->_fieldreplists();

        $fieldids = [];
        $fieldstaffcompare = [];

        $settings = $this->setCurrentUserSettings();

        if (isset($this->request->query['id1']))
            $fieldids[] = $this->request->query['id1'];
        if (isset($this->request->query['id2']))
            $fieldids[] = $this->request->query['id2'];
        if (isset($this->request->query['id3']))
            $fieldids[] = $this->request->query['id3'];
        if (isset($this->request->query['id4']))
            $fieldids[] = $this->request->query['id4'];
        if (isset($this->request->query['id5']))
            $fieldids[] = $this->request->query['id5'];



        foreach ($fieldids as $id) {

            $staffstat['staffid'] = $id;
            $staffstat['staffname'] = $this->User->find('first', array('recursive' => -1, 'fields' => array('User.firstname, User.lastname'), 'conditions' => array('User.id' => $id)));
            if ($staffstat['staffname'] == null)
                continue;

            $staffstat['outletcount'] = $this->Outlet->find('count', array('recursive' => 1, 'conditions' => array('Outlet.userid' => $id)));
            $staffstat['plannedvisitcount'] = $this->Schedule->find('count', array('recursive' => 1, 'conditions' => array('Outlet.userid' => $id)));
            $staffstat['actualvisitcount'] = $this->Visit->find('count', array('recursive' => 1, 'conditions' => array('Outlet.userid' => $id)));

            //Unbind Visit from Order to control the amount of data pulled from the database
            $this->Order->unbindModel(
                    array('belongsTo' => array('Visit'))
            );
            $staffstat['ordercount'] = $this->Order->find('count', array(
                'joins' => array(
                    array(
                        'table' => 'visits',
                        'alias' => 'Visit',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Order.visitid = Visit.id'
                        )
                    ),
                    array(
                        'table' => 'outlets',
                        'alias' => 'Outlet',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Visit.outletid = Outlet.id'
                        )
                    )
                ),
                'conditions' => array('Outlet.userid' => $id)
                    ));
            
            $ordervalue = $this->Order->find('all', array(
                'fields' => array('SUM( quantity * ( unitprice - discount * unitprice ) ) as totalordervalue'),
                'recursive' => -1,
                'joins' => array(
                    array(
                        'table' => 'visits',
                        'alias' => 'Visit',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Order.visitid = Visit.id'
                        )
                    ),
                    array(
                        'table' => 'outlets',
                        'alias' => 'Outlet',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Visit.outletid = Outlet.id'
                        )
                    )
                ),
                'conditions' => array('Outlet.userid' => $id)
                    ));
            $staffstat['ordervalue'] = isset($ordervalue[0][0]['totalordervalue']) ? $ordervalue[0][0]['totalordervalue'] : 0.00;
            $staffstat['ordervalue'] = "N " . round(floatval($staffstat['ordervalue']), 2);
//            debug($ordervalue);
            //Total number of exceptions by userid
            $staffstat['totalexception'] = $this->Visit->find('count', array(
                'recursive' => 1,
                'conditions' => array(
                    'Outlet.userid' => $id,
                    'Visit.distancefromoutlet >' => intval($settings['Setting']['VisitException'])
                    ))
            );

            //Location of User
            $this->Outlet->unbindModel(
                    array('belongsTo' => array('Location'))
            );
            $staffstat['location'] = $this->Outlet->find('first', array('fields' => array('Location.locationname'),
                'conditions' => array('Outlet.userid' => $id),
                'recursive' => -1,
                'joins' => array(
                    array(
                        'table' => 'locations',
                        'alias' => 'Location',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Location.id = Outlet.locationid'
                        )
                    )
                    )));

            //Calculating visits per day
            $rs = $this->Visit->query(
                    "SELECT
                        AVG(visitcount) AS averagevisit
                    FROM
                        (
                            SELECT
                                COUNT(`Visit`.`starttimestamp`) AS visitcount
                            FROM
                                `visits` AS `Visit`
                            LEFT JOIN `outlets` AS `Outlet` ON (
                                `Visit`.`outletid` = `Outlet`.`id`
                            )
                            WHERE
                                `Visit`.`deletedat` IS NULL AND `Outlet`.`userid` = '{$id}'
                            GROUP BY
                                DATE_FORMAT(
                                    FROM_UNIXTIME(`Visit`.`starttimestamp`),
                                    '%Y-%c-%e'
                                )
                        ) AS counttable"
            );
            if(isset($rs[0][0]['averagevisit']))
                $staffstat['visitperday'] = intval($rs[0][0]['averagevisit']);
            else
                $staffstat['visitperday'] = 0;
            
            
            $fieldstaffcompare[] = $staffstat;
        }



//        debug($rs);
//        debug($settings);
//        debug($fieldids);
//        debug($fieldstaffcompare);

        $this->set('fieldstaffcompare', $fieldstaffcompare);
    }

    private function _sendUserrole() {
        $user_roles = $this->Userrole->find('list');
        $this->set(array('user_roles' => $user_roles));
    }

    public function _setTitleOfPage($title) {
        $this->set(array(
            'title_of_page' => $title
        ));
    }

    public function _setSidebarActiveItem($topMenu) {
        $this->set(array('active_item' => $topMenu));
    }

}