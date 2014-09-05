<?php

class RegionsController extends AppController {
    
    var $name = 'Regions';
    var $uses = array('Region', 'State', 'Location');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->_setViewVariables();
    }
    
    public function index() {

    }
   
    
    public function add($id = null) {
        
        $this->render('index');

//        debug($this->request->data);

        if ($this->request->is('Post') || $this->request->is('Put')) {
                
            $this->request->data['Region']['stateids'] = implode(',', $this->request->data['Region']['stateids']);
            $this->request->data['Region']['countryid'] = 1;    //save the country - Defaults to Nigeria for now
            $this->request->data['Region']['createdat'] = $this->_createNowTimeStamp();
            if ($this->Region->save($this->request->data)) {
                $this->Session->setFlash("Region group successfully created!", 'page_notification_info');
                $this->redirect(array('controller' => 'regions', 'action' => 'index'));
            } else {
                $this->Session->setFlash('Problem creating state group. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }
    
    public function delete($id = null) {
        
        if (!$id) {

            $this->Session->setFlash('Invalid region selected', 'page_notification_error');
            $this->redirect(array('controller' => 'regions', 'action' => 'index'));
        }

        $this->Region->id = $id;

        if ($this->Region->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Region has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'regions', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete region. Please, try again', 'page_notification_error');
        }
    }
    
    public function edit($id = null) {

        $this->render('index');

        $this->Region->id = $id;
        
        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {

            $this->request->data = $this->Region->read();
            $stateids = $this->request->data['Region']['stateids'];
            $arr_state_ids = explode(',',$stateids);
            $this->request->data['Region']['stateids'] = $arr_state_ids;
            $this->set('data', $this->request->data);

            $states = $this->_getAllStates(false);
            for ($i = 0; $i < count($states); $i++) {
                if(in_array(intval($states[$i]['State']['id']), $arr_state_ids)) {
                    $states[$i]['Region']['member'] = true;
                } else {
                    $states[$i]['Region']['member'] = false;
                }
            }
            
            $this->_setViewVariables();
            $this->set('states', $states);
        }

        $this->add($id);
    }
    
    private function _getAllStates($setValue = true) {
        $options['fields'] = array(
            'State.id',
            'State.statename'
        );
        $options['recursive'] = -1;
        $options['order'] = array('State.statename');

        $states = $this->State->find('all', $options);
//        debug($locations);
        if($setValue) {
            $this->set(array('states' => $states));
        } else {
            return $states;
        }
    }
    
    public function _getAllStateGroup($setValue = true) {
        
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
    
    
    public function beforeRender() {
        
        
        return true;
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setTitleOfPage('Setup');
        
        $this->_getAllStates();
        $this->_getAllStateGroup();
        
    }
}
