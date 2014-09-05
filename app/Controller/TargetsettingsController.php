<?php

class TargetsettingsController extends AppController {
    
    var $name = 'Targetsettings';
    var $uses = array('Targetsetting', 'Country', 'State', 'Region', 'Location', 'Locationgroup');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->_setViewVariables();
    }
    
    public function index() {
    
        
//        debug(Inflector::pluralize('Targetsetting'));
        $this->_getAllCountries();
        $this->_getAllRegions();
        $this->_getAllStates();
        $this->_getAllLocations();
        $this->_getAllLocationGroups();
        
    }
    
    private function _getAllCountries(){
        $countries = $this->Country->find('all'); 
//        $countrysettings = $this->Targetsetting->find('all', array('conditions' => array('type' => 'c')));
        $this->set(array('countries'=>$countries));
    }
    
    private function _getAllStates(){
        $states = $this->State->find('all'); 
        $this->set(array('states'=>$states));
    }
    
    private function _getAllRegions($setValue = true){
        
        $regions = $this->Region->find('all');
        
        if(count($regions) != 0) {
            $allgroups = array();
            foreach ($regions as $group) {
                $stateids = $group['Region']['stateids'];
                $arr_state_ids = explode(',',$stateids);
                $states = $this->State->find('all', array('conditions' => array('State.id' => $arr_state_ids)));
                $arr_states = [];
                foreach ($states as $state) {
                    $arr_states[] = $state['State']['statename'];
                }
                $str_states = implode(', ', $arr_states);
                $group['Region']['states'] = $str_states;
                $allgroups[] = $group;
            }
            if($setValue) {
                $this->set('regions', $allgroups);
            } else {
                return $allgroups;
            }
        } else {
            if($setValue) {
                $this->set('regions', array());
            } else {
                return null;
            }
        }
    }
   
    private function _getAllLocations() {
        $locations = $this->Location->find('all'); 
        $this->set(array('locations'=>$locations));
    }
    
    private function _getAllLocationGroups() {
        
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
    
    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setTitleOfPage('Setup');
        
//        $this->_getAllCountries();
    }
    
    public function save() {
       
       $this->render('index');

        if ($this->request->is('Post') || $this->request->is('Put')) {
            
            if (!$this->Targetsetting->deleteAll())    {
                $this->Session->setFlash('Problem saving target settings. Please, try again', 'page_notification_error');
                $this->redirect(array('controller' => 'targetsettings', 'action' => 'index'));
            }
            
            $targetSetting = array();
            
            foreach ($this->request->data as $key => $value) {
                $temp = array();
                $arr_key = explode('_', $key);
                $type = $arr_key[0];
                $tid = $arr_key[1];
                $tsetting = $arr_key[2];
                $tmp_key = $type . '_' . $tid;
                if(!isset($targetSetting[$tmp_key])) {
                    $targetSetting[$tmp_key]['Targetsetting']['tid'] = $tid;
                    $targetSetting[$tmp_key]['Targetsetting']['type'] = $type;
                    $targetSetting[$tmp_key]['Targetsetting']['createdat'] = $this->_createNowTimeStamp();
                }
                
                if($tsetting == 'targetvisit') {
                    $targetSetting[$tmp_key]['Targetsetting']['visittarget'] = $value;
                } else if($tsetting == 'targetorder') {
                    $targetSetting[$tmp_key]['Targetsetting']['salestargetcount'] = $value;
                } else {
                    $targetSetting[$tmp_key]['Targetsetting']['salestargetvalue'] = $value;
                }
            }
            
            $settings = array_values($targetSetting);
            if ($this->Targetsetting->saveAll($settings))    {
                $this->Session->setFlash("Target settings successfully saved!", 'page_notification_info');
            } else {
                $this->Session->setFlash('Problem saving target settings. Please, try again', 'page_notification_error');
            }
        }
        
        $this->_setViewVariables();
    }
}
