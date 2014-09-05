<?php

class OutlettypesController extends AppController {

    var $name = 'Outlettypes';
    var $uses = array('Outlettype', 'Outletchannel');

    public function beforeFilter() {
        parent::beforeFilter();
        
//        $allowed = $this->UserAccessRight->isAllowedSetupModule($this->_getCurrentUserId(), 'view');
//        if(!$allowed) {
//            $this->Session->setFlash('You are not authorized to view that page!', 'page_notification_error');
//            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
//        }
        
        $this->_setViewVariables();
        $this->_fetchAndSetAllOutletTypes();
        $this->_fetchAllOutletChannels();
    }
    
    public function index() {
        
    }

    public function add($id = null) {
        
        $this->render('index');
        
//        debug($this->request->data);
        if ($this->request->is('Post') || $this->request->is('Put')) {
                
            $this->request->data['Outlettype']['createdat'] = $this->_createNowTimeStamp();    //create now timestamp if not set
            if ($this->Outlettype->save($this->request->data)) {
                $this->Session->setFlash($this->request->data['Outlettype']['outlettypename'] . ' has been added', 'page_notification_info');
                $this->redirect(array('controller' => 'outlettypes', 'action' => 'index'));
            } else {
                $this->Session->setFlash('problem adding outlet type. Please, try again', 'page_notification_error');
                $this->_setViewVariables();
            }
        }
    }
    
    public function delete($id = null) {
        if (!$id) {

            $this->Session->setFlash('Invalid outlet type selected', 'page_notification_error');
            $this->redirect(array('controller' => 'outlettypes', 'action' => 'index'));
        }

        $this->Outlettype->id = $id;

        if ($this->Outlettype->saveField('deletedat', "{$this->_createNowTimeStamp()}")) {
            $this->Session->setFlash('Outlet type has been deleted', 'page_notification_info');
            $this->redirect(array('controller' => 'outlettypes', 'action' => 'index'));
        } else {
            $this->Session->setFlash('Unable to delete type. Please, try again', 'page_notification_error');
        }
    }
    
    public function edit($id = null) {
        
        $this->render('index');
        
        $this->Outlettype->id = $id;
        
        if (!($this->request->is('Post') || $this->request->is('Put')) && isset($id)) {
            
            $this->request->data = $this->Outlettype->read();
            $this->set('data', $this->request->data);
            $this->_fetchAndSetAllOutletTypes();
            $this->_setViewVariables();
        }
        
        $this->add($id);
        
    }
    
    private function _fetchAndSetAllOutletTypes() {
        $outlettypes = $this->Outlettype->find('all'); 
        $this->set(array('outlettypes'=>$outlettypes));
    }

    private function _fetchAllOutletChannels() {
        $outletchannels = $this->Outletchannel->find('all'); 
        $this->set(array('outletchannels'=>$outletchannels));   
    }

    private function _setViewVariables() {
        $this->_setSidebarActiveItem('setup');
        $this->_setSidebarActiveSubItem('types');
        $this->_setTitleOfPage('Outlet Types');
    }
    
    public function exists($name = null) {
        $this->layout = 'ajax';
        $this->view = 'ajax_response';
        
        $result = $this->Outlettype->find('all', array('conditions'=>array('outlettypename'=>$name))); 

        if(!empty($result))  {
            $response = '{ "meta" : { "status" : true, "message" : "'. $name . ' already exist" } }';
        } else
            $response = '{ "meta" : { "status" : false, "message" : "'. $name . ' is available" } }';
        
        $this->set('response' , $response);
    }
}
