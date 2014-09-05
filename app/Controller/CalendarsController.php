<?php

class CalendarsController extends AppController {

    var $name = 'Calendars';
    var $uses = array('Schedule', 'Visit', 'Outlet');
    var $helpers = array('Time');
    public $components = array('Filter');
    
    public $urloptions = array();
    public $postoptions = array();

    public function index() {
        $this->set('visitcount', $this->_getVisitCount());
        $this->set('schedulecount', $this->_getScheduleVisitCount());
        $this->set('outletcount', $this->_getOutletCount());
    }

    private function _getScheduleVisitCount($options = null) {
        $options = $this->postoptions;
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Schedule.outletid'
                )
            )
        );
        $schedulevisit = $this->Schedule->find('count', $options);
        return $schedulevisit;
    }

    public function beforeFilter() {
        parent::beforeFilter();

//        $allowed = $this->UserAccessRight->isAllowedCalendarModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }

        $this->_setViewVariables();

        //get current user settings :)
        $this->setCurrentUserSettings();
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('calendars');
        $this->_setTitleOfPage('Calendar Management');
    }

    private function _getAllScheduleVisitDate($options = null) {

        
//        $options = $this->Filter->getPostDataFilterOptions($this->modelClass);
        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Schedule.id',
            "DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' ) as dateschedule",
            'Schedule.visited'
        );
        $options['order'] = array('Schedule.createdat desc');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Schedule.outletid'
                )
            )
        );
        $schedule = $this->Schedule->find('all', $options);
        return $schedule;
    }

    private function _getAllActualVisitDate($options = null) {

//        $options = $this->Filter->getUrlFilterOptions('Visit');

        $options['fields'] = array(
            'Outlet.id',
            'Outlet.outletname',
            'Schedule.id',
            "DATE_FORMAT(Schedule.scheduledate,'%Y-%m-%d') as scheduledate",
            'Schedule.visited'
        );
        $options['order'] = array('Schedule.scheduledate desc');
        $options['conditions']['Schedule.visited'] = 1;
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Schedule.outletid'
                )
            )
        );
        
        $visits = $this->Schedule->find('all', $options);
        return $visits;
//        $visits = $this->Visit->find('all', $options);
//        return $visits;
    }

    private function _getActualVisitCountPerDay() {

        $options = $this->Filter->getUrlFilterOptions('Visit');

        $options['recursive'] = -1;
        $options['fields'] = array(
            'Schedule.id',
            "DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' ) as scheduledate",
            "COUNT(DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' )) as Count"
        );
        $options['order'] = array('Schedule.scheduledate asc');
        $options['group'] = array("DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' )");
        $options['conditions']['Schedule.visited'] = 1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Schedule.outletid'
                )
            )
        );
//        $options['conditions'] = array('NOT' => array('visited' => 1));
        $actualvisits = $this->Schedule->find('all', $options);
        return $actualvisits;
    }

    private function _PlannedVisitCountPerDay() {

        $options = $this->Filter->getUrlFilterOptions('Schedule');

        $options['recursive'] = -1;
        $options['fields'] = array(
            'Schedule.id',
            "DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' ) as scheduledate",
            "COUNT(DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' )) as Count"
        );
        $options['order'] = array('Schedule.createdat asc');
        $options['group'] = array("DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' )");
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Schedule.outletid'
                )
            )
        );

        $schedulevisit = $this->Schedule->find('all', $options);
        return $schedulevisit;
    }

    public function schedulecalendar() {    //pass!
        $response = array();

        $plannedvisits = $this->_PlannedVisitCountPerDay();
        foreach ($plannedvisits as $plannedvisit) {
            $event['id'] = 'p';
//            $event['title'] = ' Planned Visits: ' . $plannedvisit[0]['Count'];
            $event['title'] = (intval($plannedvisit[0]['Count']) < 10 ? '0'.$plannedvisit[0]['Count'] : $plannedvisit[0]['Count']);
            $event['start'] = $plannedvisit[0]['scheduledate'];
            $event['className'] = 'label-primary';
            $response[] = $event;
        }

        $actualvisits = $this->_getActualVisitCountPerDay();
        foreach ($actualvisits as $actualvisit) {
            $event['id'] = 'a';
//            $event['title'] = 'Actual Visits: ' . $actualvisit[0]['Count'];
            $event['title'] = (intval($actualvisit[0]['Count']) < 10 ? '0'.$actualvisit[0]['Count'] : $actualvisit[0]['Count']);
            $event['start'] = $actualvisit[0]['scheduledate'];
            $event['className'] = 'label-success';
            $response[] = $event;
        }

        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    public function planneddetails($startdate) {

        $options = $this->Filter->getUrlFilterOptions('Schedule');
//        $options['conditions']['Schedule.scheduledate'] = $startdate;
        $options['conditions']["DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' )"] = $startdate;
        $plannedvisits = $this->_getAllScheduleVisitDate($options);

        $response = array();

        foreach ($plannedvisits as $pvisit) {
            $item['outletid'] = $pvisit['Outlet']['id'];
            $item['outletname'] = $pvisit['Outlet']['outletname'];
            $item['date'] = $startdate;
//            $item['date'] = $pvisit['Schedule']['scheduledate'];
            $item['visited'] = $pvisit['Schedule']['visited'];
            $response[] = $item;
        }

        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }

    public function actualdetails($startdate) {

        $options = $this->Filter->getUrlFilterOptions('Schedule');

        $options['conditions']["DATE_FORMAT( Schedule.scheduledate,  '%Y-%m-%d' )"] = $startdate;
        $actualvisits = $this->_getAllActualVisitDate($options);

        $response = array();

        foreach ($actualvisits as $avisit) {
            $item['outletid'] = $avisit['Outlet']['id'];
            $item['outletname'] = $avisit['Outlet']['outletname'];
            $item['visitid'] = $avisit['Schedule']['id'];
            $item['date'] = $avisit[0]['scheduledate'];
            $response[] = $item;
        }

        $jsonresponse = json_encode($response);

        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        $this->set('response', $jsonresponse);
    }
    
    public function schedulevisit() {
        
        $this->_outletList();   //get current outlets list based on the location handled by the user and sends it to the view
        
        if(!isset($this->request->data)) {
            $this->set('data', $this->request->data);
        } else {
            if($this->request->is('POST') || $this->request->is('PUT')) {
                $schedule['Schedule']['outletid'] = $this->request->data['Calendar']['outletid'];
                $schedule['Schedule']['scheduledate'] = $this->request->data['Calendar']['scheduledate'];
                $schedule['Schedule']['visited'] = 0;
                $schedule['Schedule']['created'] = $this->_createNowTimeStamp();
                if($this->Schedule->save($schedule)) {
                    $this->Session->setFlash('Outlet has been scheduled', 'page_notification_info');
                    $this->redirect(array('controller' => 'calendars', 'action' => 'index'));
                } else {
                    $this->Session->setFlash('Error scheduling outlet. Please, try again', 'page_notification_error');
                }
            }
        }
    }
}
