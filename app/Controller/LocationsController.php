<?php

class LocationsController extends AppController {

    var $name = 'Locations';
    var $uses = array('Location', 'State', 'Region', 'Locationmaps');

    public function beforeFilter() {
        parent::beforeFilter();

//        $allowed = $this->UserAccessRight->isAllowedSetupModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }

        $this->_setViewVariables();
    }

    public function index() {
        
    }

    public function add($id = null) {

        $this->render('index');

//        debug($this->request->data);

        if ($this->request->is('Post') || $this->request->is('Put')) {
            if (isset($this->request->data['Location']['usestate'])) {
                $allmylocation = array();
                $$mylocation = array();
                $stateid = $this->request->data['Location']['stateid'];
                $regionid = $this->request->data['Location']['regionid'];
                $locations = $this->Locationmaps->find('all', array("conditions" => array('stateid' => $stateid)));
//             debug($locations);
                foreach ($locations as $location) {
                    $mylocation['Location']['id'] = $location['Locationmaps']['id'];
                    $mylocation['Location']['locationname'] = $location['Locationmaps']['locationmapname'];
                    $mylocation['Location']['stateid'] = $stateid;
//                    $mylocation['Location']['regionid'] = $regionid;
                    $mylocation['Location']['createdat'] = $this->_createNowTimeStamp();
                    $allmylocation[] = $mylocation;
                }

//            debug($mylocation);
                if ($this->Location->saveAll($allmylocation)) {
                    $this->Session->setFlash("All locations in state have been added", 'page_notification_info');
                    $this->redirect(array('controller' => 'locations', 'action' => 'index'));
                } else {
                    $this->Session->setFlash('problem adding locations. Please, try again', 'page_notification_error');
                    $this->_setViewVariables();
                }
            }
         else {

            $this->request->data['Location']['createdat'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            if ($this->Location->save($this->request->data)) {
                $this->Session->setFlash($this->request->data['Location']['locationname'] . ' has been added', 'page_notification_info');
                $this->redirect(array('controller' => 'locations', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding location. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
        }
    }

    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid location selected', 'page_notification_error');
            $this->redirect(array('controller' => 'locations', 'action' => 'index'));
        }

        $this->Location->id = $id;

        if ($this->Location->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Location has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'locations', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete Location. Please, try again', 'page_notification_error');
        }
    }

    public function edit($id = null) {

        $this->render('index');

        $this->Location->id = $id;

        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {

            $this->request->data = $this->Location->read();
            $this->set('data', $this->request->data);
            $this->_getAllLocations();
            $this->_setViewVariables();
        }

        $this->add($id);
    }

    private function _getAllLocations() {
        $options['fields'] = array(
            'Location.id',
            'Location.locationname',
            'Location.stateid',
            'State.statename'
        );
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Location.stateid'
                )
            )
//            ,
//            array(
//                'table' => 'regions',
//                'alias' => 'Region',
//                'type' => 'LEFT',
//                'conditions' => array(
//                    'Region.id = State.regionid'
//                )
//            )
        );

        $locations = $this->Location->find('all', $options);
//        debug($locations);
        $this->set(array('locations' => $locations));
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('locations');
        $this->_setTitleOfPage('Location');

        $this->_getAllRegions();
        $this->_getAllStates();
        $this->_getAllLocations();
    }

    public function states() {
        $this->layout = 'ajax';
        $this->view = 'ajax_response';

//        $result = $this->Location->find('all', 
//                array('fields'=>array('DISTINCT (Location.state)')));

        $result = $this->State->find('all', array('fields' => array('DISTINCT (State.statename)'), 'recursive' => -1));

        $states['states'] = $result;
        $response = json_encode($states);
        $this->set('response', $response);
    }

    public function regions() {
        $this->layout = 'ajax';
        $this->view = 'ajax_response';

//        $result = $this->Location->find('all', 
//                array('fields'=>array('DISTINCT (Location.region)')));

        $result = $this->Region->find('all', array('fields' => array('DISTINCT (Region.regionname)'), 'recursive' => -1));

        $regions['regions'] = $result;
        $response = json_encode($regions);
        $this->set('response', $response);
    }

    private function _getAllRegions() {
        $regions = $this->Region->find('all');
        $regionlist = $this->Region->find('list');
        $this->set(array('regions' => $regions, 'regionlist' => $regionlist));
    }

    private function _getAllStates() {
        $states = $this->State->find('all');
        $statelist = $this->State->find('list');
        $this->set(array('states' => $states, 'statelist' => $statelist));
    }

}
