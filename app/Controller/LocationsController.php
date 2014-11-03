<?php

class LocationsController extends AppController {

    var $name = 'Locations';
    var $uses = array('Location', 'Region', 'Subregion', 'State', 'Territory', 'Lga');

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

            $this->request->data['Location']['created_at'] = $this->_createNowTimeStamp();
            if ($this->Location->save($this->request->data)) {
                $this->Session->setFlash("POP {$this->request->data['Location']['locationname']} has been successfully created!", 'page_notification_info');
                $this->redirect(array('controller' => 'locations', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding POP. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }

        }
    }

    public function delete($id = null) {

        if (!$id) {

            $this->Session->setFlash('Invalid POP selected', 'page_notification_error');
            $this->redirect(array('controller' => 'locations', 'action' => 'index'));
        }

        $this->Location->id = $id;
        $locationname = $this->Location->locationname;

        if ($this->Location->saveField('deleted_at', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash("POP {$locationname} has been deleted", 'page_notification_info');
            $this->redirect(array('controller' => 'locations', 'action' => 'index'));
        } else {
            $this->Session->setFlash("Unable to delete POP {$locationname}. Please, try again", 'page_notification_error');
        }
    }

    public function edit($id = null) {

        $this->render('index');

        $this->Location->id = $id;

        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {

            $this->request->data = $this->Location->read();
            $this->set('data', $this->request->data);
            $this->_setViewVariables();
        }

        $this->add($id);
    }



    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('locations');
        $this->_setTitleOfPage('Location');

        $locations = $this->Location->getLocations();
        $lgalist = $this->Lga->getLgaAsList();

        $this->set(array(
           'locations' => $locations,
            'lgalist' => $lgalist
        ));
    }

    public function states() {
        $this->layout = 'ajax';
        $this->view = 'ajax_response';

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

}
