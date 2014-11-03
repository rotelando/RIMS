<?php

class OutletclassesController extends AppController {

    var $name = 'Outletclasses';
    var $uses = array('Outletclass', 'Outletchannel', 'Retailtype');

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
                
            $this->request->data['Outletclass']['created_at'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            if ($this->Outletclass->save($this->request->data)) {
                $this->Session->setFlash($this->request->data['Outletclass']['outletclassname'] . ' has been added', 'page_notification_info');
                $this->redirect(array('controller' => 'outletclasses', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding outlet class. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }
    
    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid outlet class selected', 'page_notification_error');
            $this->redirect(array('controller' => 'outletclasses', 'action' => 'index'));
        }

        $this->Outletclass->id = $id;

        if ($this->Outletclass->saveField('deleted_at', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Outlet class has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'outletclasses', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete type. Please, try again', 'page_notification_error');
        }
    }
    
    public function edit($id = null) {
        
        $this->render('index');
        
        $this->Outletclass->id = $id;
        
        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {
            
            $this->request->data = $this->Outletclass->read();
            $this->set('data', $this->request->data);
            $this->_fetchAndSetAllOutletclasses();
            $this->_setViewVariables();
        }
        
        $this->add($id);
        
    }
    
    private function _fetchAndSetAllOutletclasses() {
        $outletclasses = $this->Outletclass->find('all');
        $this->set(array('outletclasses'=>$outletclasses));
    }

    private function _fetchAllOutletChannels() {
        $outletchannels = $this->Outletchannel->find('all'); 
        $this->set(array('outletchannels'=>$outletchannels));   
    }

    private function _fetchAllRetailTypes() {
        $retailtypes = $this->Retailtype->find('all');
        $this->set(array('retailtypes'=>$retailtypes));
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('types');
        $this->_setTitleOfPage('Outlet Class');

        $this->_fetchAndSetAllOutletclasses();
        $this->_fetchAllOutletChannels();
        $this->_fetchAllRetailTypes();
    }
    
    public function exists($name = null) {
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        
        $result = $this->Outletclass->find('all', array('conditions'=>array('Outletclassname'=>$name))); 

        if(!empty($result))  {
            $response = '{ "meta" : { "status" : true, "message" : "'. $name . ' already exist" } }';
        } else
            $response = '{ "meta" : { "status" : false, "message" : "'. $name . ' is available" } }';
        
        $this->set('response' , $response);
    }
}
