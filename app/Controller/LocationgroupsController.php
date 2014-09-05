<?php

class LocationgroupsController extends AppController {

    var $name = 'Locationgroups';
    var $uses = array('Locationgroup', 'State', 'Region', 'Locationmaps');

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
                
            $this->request->data['Locationgroup']['locationids'] = implode(',', $this->request->data['Locationgroup']['locationids']);
            $this->request->data['Locationgroup']['stateid'] = $this->request->data['Locationgroup']['stateid'];
            $this->request->data['Locationgroup']['createdat'] = $this->_createNowTimeStamp();
            if ($this->Locationgroup->save($this->request->data)) {
                $this->Session->setFlash("Location group successfully created!", 'page_notification_info');
                $this->redirect(array('controller' => 'locationgroups', 'action' => 'index'));
            } else {
                $this->Session->setFlash('Problem creating location group. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }

    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid location group selected', 'page_notification_error');
            $this->redirect(array('controller' => 'locationgroups', 'action' => 'index'));
        }

        $this->Locationgroup->id = $id;

        if ($this->Locationgroup->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Location Group has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'locationgroups', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete Location Group. Please, try again', 'page_notification_error');
        }
    }

    public function edit($id = null) {

        $this->render('index');

        $this->Locationgroup->id = $id;
        
        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {

            $this->request->data = $this->Locationgroup->read();
            $locationids = $this->request->data['Locationgroup']['locationids'];
            $arr_loc_ids = explode(',',$locationids);
            $this->request->data['Locationgroup']['locationids'] = $arr_loc_ids;
            $this->set('data', $this->request->data);

            $locations = $this->_getAllLocations(false);
            for ($i = 0; $i < count($locations); $i++) {
                if(in_array(intval($locations[$i]['Location']['id']), $arr_loc_ids)) {
                    $locations[$i]['Locationgroup']['member'] = true;
                } else {
                    $locations[$i]['Locationgroup']['member'] = false;
                }
            }
            
            $this->_setViewVariables();
        }

        $this->add($id);
    }

    private function _getAllLocations($setValue = true) {
        $options['fields'] = array(
            'Location.id',
            'Location.locationname',
            'Location.stateid',
            'State.statename',
        );
        $options['recursive'] = -1;
        $options['order'] = array('Location.locationname');
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
        if($setValue) {
            $this->set(array('locations' => $locations));
        } else {
            return $locations;
        }
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setTitleOfPage('Location Groups');

        $this->_getAllRegions();
        $this->_getAllStates();
        $this->_getAllLocations();
        $this->getAllLocationGroup();
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
    
    public function getAllLocationGroup() {
        
        $locationgroups = $this->Locationgroup->find('all');
        
        if(count($locationgroups) != 0) {
            $allgroups = array();
            foreach ($locationgroups as $group) {
                $locationids = $group['Locationgroup']['locationids'];
                $arr_loc_ids = explode(',',$locationids);
                $locations = $this->Location->find('all', array('conditions' => array('Location.id' => $arr_loc_ids)));
                $arr_locations = [];
                foreach ($locations as $location) {
                    $arr_locations[] = $location['Location']['locationname'];
                }
                $str_locations = implode(', ', $arr_locations);
                $group['Locationgroup']['locations'] = $str_locations;
                $allgroups[] = $group;
            }
            $this->set('locationgroups', $allgroups);
        } else {
            $this->set('locationgroups', array());
        }
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
